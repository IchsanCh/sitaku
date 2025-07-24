<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Package;
use Midtrans\Transaction;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    public function index()
    {
        $user = Auth::guard('user')->user();

        $billing = $user->subscriptions()
            ->latest()
            ->paginate(10)
            ->withQueryString();
        $packages = Package::all();

        return view('user.billing', compact('user', 'billing', 'packages'));
    }

    public function pay(Request $request)
    {
        do {
            $kodeInvoice = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (Subscription::where('id', $kodeInvoice)->exists());
        $user = Auth::guard('user')->user();
        $package = Package::findOrFail($request->package_id);

        // Log payment initiation
        Log::info('Payment initiated:', [
            'user_id' => $user->id,
            'package_id' => $package->id,
            'package_name' => $package->name,
            'price' => $package->price
        ]);

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = uniqid('ORDER-' . $user->id . '-');

        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => $package->price,
        ];

        $customerDetails = [
            'first_name' => $user->name,
            'email' => $user->email,
        ];

        $itemDetails = [[
            'id' => $package->id,
            'price' => $package->price,
            'quantity' => 1,
            'name' => $package->name,
        ]];

        $snapPayload = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails,
            'callbacks' => [
                'finish' => route('billing.success', [
                    'package_id' => $package->id,
                    'order_id' => $orderId,
                ]),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($snapPayload);

            Log::info('Snap token generated:', [
                'order_id' => $orderId,
                'user_id' => $user->id
            ]);
            // Tambahkan sebelum return $snapToken;
            $subscription = Subscription::create([
                'id' => $kodeInvoice,
                'user_id' => $user->id,
                'package_id' => $package->id,
                'status' => "failed",
                'total' => $package->price,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays($package->duration ?? 30),
                'payment_token' => $orderId,
            ]);

            return view('user.billing-payment', compact('snapToken', 'package'));
        } catch (\Exception $e) {
            Log::error('Failed to generate snap token:', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('user.billing')
                ->with('error', 'Gagal memproses pembayaran. Silakan coba lagi.');
        }
    }

    public function paymentSuccess(Request $request)
    {
        do {
            $kodeInvoice = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (Subscription::where('id', $kodeInvoice)->exists());
        $user = Auth::guard('user')->user();
        $packageId = $request->query('package_id');
        $orderId = $request->query('order_id');

        // Log payment success page access
        Log::info('Payment success page accessed:', [
            'user_id' => $user->id,
            'package_id' => $packageId,
            'order_id' => $orderId,
            'query_params' => $request->query()
        ]);

        if (!$packageId || !$orderId) {
            Log::error('Missing parameters on success page:', [
                'package_id' => $packageId,
                'order_id' => $orderId
            ]);

            return redirect()->route('user.billing')
                ->with('error', 'Parameter pembayaran tidak valid.');
        }

        try {
            // Ambil data paket
            $package = Package::findOrFail($packageId);

            // Cek apakah transaksi sudah ada untuk menghindari duplikasi
            $existingSubscription = Subscription::where('user_id', $user->id)
                ->where('payment_token', $orderId)
                ->first();

            if ($existingSubscription) {
                Log::info('Subscription already exists:', [
                    'subscription_id' => $existingSubscription->id,
                    'status' => $existingSubscription->status,
                    'order_id' => $orderId
                ]);

                $message = match ($existingSubscription->status) {
                    'success' => 'Pembayaran sudah berhasil diproses sebelumnya.',
                    'pending' => 'Pembayaran sedang diproses.',
                    'failed' => 'Pembayaran gagal. Silakan coba lagi.',
                    default => 'Transaksi ini sudah tercatat.'
                };

                return redirect()->route('user.billing')->with('info', $message);
            }

            // Verify payment status with Midtrans (optional but recommended)
            $isPaymentVerified = $this->verifyPaymentStatus($orderId);

            // Create subscription record
            $subscriptionStatus = $isPaymentVerified ? 'success' : 'pending';

            $message = $isPaymentVerified
                ? 'Pembayaran berhasil! Paket telah diaktifkan.'
                : 'Pembayaran berhasil! Paket sedang diproses.';

            return redirect()->route('user.billing')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error in payment success:', [
                'order_id' => $orderId,
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('user.billing')
                ->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
        }
    }

    public function handleCallback(Request $request)
    {
        Log::info('Midtrans Callback Received:', [
            'all_data' => $request->all(),
            'headers' => $request->headers->all(),
            'ip' => $request->ip()
        ]);

        $serverKey = config('midtrans.server_key');
        $signatureKey = $request->signature_key;
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;
        $transactionStatus = $request->transaction_status;

        if (!$signatureKey || !$orderId || !$statusCode || !$grossAmount) {
            Log::error('Missing required callback parameters');
            return response()->json(['message' => 'Missing required parameters'], 400);
        }

        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey !== $expectedSignature) {
            Log::error('Invalid signature for callback', [
                'order_id' => $orderId
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $subscription = Subscription::where('payment_token', $orderId)->first();

        if (!$subscription) {
            Log::error('Subscription not found for callback:', [
                'order_id' => $orderId
            ]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        $oldStatus = $subscription->status;
        $newStatus = $this->determineSubscriptionStatus($transactionStatus, $request->fraud_status);

        // Prevent downgrade
        $statusPriority = ['failed' => 0, 'pending' => 1, 'success' => 2];
        if ($statusPriority[$newStatus] < $statusPriority[$oldStatus]) {
            Log::info('Preventing status downgrade', [
                'order_id' => $orderId,
                'old_status' => $oldStatus,
                'attempted_status' => $newStatus
            ]);
            return response()->json(['message' => 'Status downgrade prevented'], 200);
        }

        // Update fields
        $subscription->status = $newStatus;
        $subscription->updated_at = now();
        $subscription->save();
        $this->updateSubscription($subscription);
        Log::info('Subscription updated via Midtrans callback:', [
            'subscription_id' => $subscription->id,
            'user_id' => $subscription->user_id,
            'order_id' => $orderId,
            'new_status' => $newStatus
        ]);

        return response()->json([
            'message' => 'Notification handled successfully',
            'order_id' => $orderId,
            'status' => $newStatus
        ], 200);
    }


    /**
     * Verify payment status with Midtrans API
     */
    public function verifyPaymentStatus($orderId)
    {
        try {
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');

            $status = Transaction::status($orderId);

            Log::info('Midtrans payment status verification:', [
                'order_id' => $orderId,
                'transaction_status' => $status->transaction_status,
                'fraud_status' => $status->fraud_status ?? 'accept',
                'payment_type' => $status->payment_type ?? null
            ]);

            // Payment is successful if status is capture/settlement and not fraudulent
            $isSuccessful = in_array($status->transaction_status, ['capture', 'settlement']) &&
                ($status->fraud_status ?? 'accept') === 'accept';

            return $isSuccessful;
        } catch (\Exception $e) {
            Log::error('Failed to verify payment status with Midtrans:', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);

            return false; // Return false if verification fails
        }
    }
    public function updateSubscription(Subscription $subscription)
    {
        // Ambil user dari relasi
        $user = $subscription->user;

        // Cek status
        if ($subscription->status !== 'success') {
            Log::info('Subscription not successful, skip updating expiration.', [
                'subscription_id' => $subscription->id,
                'status' => $subscription->status
            ]);
            return;
        }

        $duration = $subscription->package->duration ?? 30;

        // Inisialisasi tanggal expired sekarang atau sekarang() jika null
        $currentExpiration = $user->subscription_expires_at ?? now();

        // Hitung tanggal baru
        $newExpiration = $currentExpiration->greaterThan(now())
            ? $currentExpiration->copy()->addDays($duration)
            : now()->addDays($duration);

        $user->subscription_expires_at = $newExpiration;
        $user->save();

        Log::info('User subscription extended:', [
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'new_expiration' => $newExpiration
        ]);
    }

    /**
     * Determine subscription status based on Midtrans transaction status
     */
    public function determineSubscriptionStatus($transactionStatus, $fraudStatus = null)
    {
        // Handle fraud status
        if ($fraudStatus && $fraudStatus !== 'accept') {
            Log::warning('Fraudulent transaction detected:', [
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus
            ]);
            return 'failed';
        }

        // Map transaction status to subscription status
        return match ($transactionStatus) {
            'capture', 'settlement' => 'success',
            'pending' => 'pending',
            'deny', 'expire', 'cancel', 'failure' => 'failed',
            default => 'pending' // For unknown statuses, set as pending
        };
    }
    public function paketStatus($payToken)
    {
        $subscription = Subscription::where('payment_token', $payToken)->first();
        $package = Package::find($subscription->package_id);
        return view('user.billing-status', compact('subscription', 'package'));
    }
}
