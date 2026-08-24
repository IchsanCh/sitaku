<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class MidNotif extends Controller
{
    public function notif(Request $request)
    {
        $payload = $request->all();

        $orderId      = $payload['order_id'] ?? null;
        $statusCode   = $payload['status_code'] ?? null;
        $grossAmount  = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;

        $serverKey = config('services.midtrans.server_key');
        $expectedSignature = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        if ($signatureKey !== $expectedSignature) {
            Log::warning('Midtrans signature mismatch', $payload);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $targetUrl = null;
        if (str_starts_with($orderId, 'EXAVRO-')) {
            $targetUrl =  "https://exavro.lotusaja.com/api/midtrans/callback";
        } elseif (str_starts_with($orderId, 'SINOMU-')) {
            $targetUrl = "https://sinomu.lotusaja.com/api/midtrans/callback";
        }

        if ($targetUrl) {
            try {
                $response = Http::post($targetUrl, $payload);
                Log::info("Forwarded Midtrans notif to {$targetUrl}", [
                    'order_id' => $orderId,
                    'response' => $response->body(),
                ]);
            } catch (\Exception $e) {
                Log::error("Failed forwarding notif to {$targetUrl}", [
                    'error' => $e->getMessage(),
                    'order_id' => $orderId,
                ]);
            }
        }
        return response()->json(['message' => 'Notification handled']);
    }
}