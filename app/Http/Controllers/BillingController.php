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

            $subscription = Subscription::create([
                'id' => $kodeInvoice,
                'user_id' => $user->id,
                'package_id' => $package->id,
                'status' => $subscriptionStatus,
                'total' => $package->price,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays($package->duration ?? 30),
                'payment_token' => $orderId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            Log::info('New subscription created:', [
                'subscription_id' => $subscription->id,
                'status' => $subscription->status,
                'order_id' => $orderId,
                'user_id' => $user->id,
                'is_verified' => $isPaymentVerified
            ]);

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
        // Log all incoming callback data
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

        // Validate required fields
        if (!$signatureKey || !$orderId || !$statusCode || !$grossAmount) {
            Log::error('Missing required callback parameters:', [
                'signature_key' => $signatureKey ? 'present' : 'missing',
                'order_id' => $orderId ? 'present' : 'missing',
                'status_code' => $statusCode ? 'present' : 'missing',
                'gross_amount' => $grossAmount ? 'present' : 'missing'
            ]);

            return response()->json(['message' => 'Missing required parameters'], 400);
        }

        // Generate expected signature
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        Log::info('Signature Validation:', [
            'order_id' => $orderId,
            'received_signature' => $signatureKey,
            'expected_signature' => $expectedSignature,
            'is_valid' => $signatureKey === $expectedSignature,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'transaction_status' => $transactionStatus
        ]);

        // Validate signature
        if ($signatureKey !== $expectedSignature) {
            Log::error('Invalid signature for callback:', [
                'order_id' => $orderId,
                'received' => $signatureKey,
                'expected' => $expectedSignature
            ]);

            return response()->json(['message' => 'Invalid signature'], 403);
        }

        Log::info('Processing transaction callback:', [
            'order_id' => $orderId,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $request->fraud_status
        ]);

        // Find subscription by payment token
        $subscription = Subscription::where('payment_token', $orderId)->first();

        if (!$subscription) {
            Log::error('Subscription not found for callback:', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus
            ]);

            return response()->json(['message' => 'Order not found'], 404);
        }

        Log::info('Found subscription for callback:', [
            'subscription_id' => $subscription->id,
            'current_status' => $subscription->status,
            'user_id' => $subscription->user_id,
            'order_id' => $orderId
        ]);

        $oldStatus = $subscription->status;
        $newStatus = $this->determineSubscriptionStatus($transactionStatus, $request->fraud_status);

        // Update subscription status
        $subscription->status = $newStatus;
        $subscription->updated_at = Carbon::now();

        // Add payment details if available
        if ($request->payment_type) {
            $subscription->payment_method = $request->payment_type;
        }

        $subscription->save();

        Log::info('Subscription status updated via callback:', [
            'subscription_id' => $subscription->id,
            'order_id' => $orderId,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $request->fraud_status,
            'payment_type' => $request->payment_type
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
    private function verifyPaymentStatus($orderId)
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

    /**
     * Determine subscription status based on Midtrans transaction status
     */
    private function determineSubscriptionStatus($transactionStatus, $fraudStatus = null)
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
}
