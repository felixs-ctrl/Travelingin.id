<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\DpConfirmed;
use App\Mail\PelunasanConfirmed;
use Midtrans\Notification;
use Midtrans\Config;

class PaymentCallbackController extends Controller
{
    public function handleCallback(Request $request)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');

        try {
            $notif = new Notification();

            $transactionStatus = $notif->transaction_status;
            $type = $notif->payment_type;
            $orderId = $notif->order_id;
            $fraudStatus = $notif->fraud_status;

            // Extract booking ID (Order ID format: TRV-{id}-{timestamp})
            $parts = explode('-', $orderId);
            $bookingId = $parts[1] ?? null;

            if (!$bookingId) {
                return response()->json(['message' => 'Invalid Order ID'], 400);
            }

            $booking = Booking::find($bookingId);
            if (!$booking) {
                return response()->json(['message' => 'Booking not found'], 404);
            }

            if ($transactionStatus == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraudStatus == 'challenge') {
                        $booking->update(['status' => 'pending']);
                    } else {
                        $this->markAsPaid($booking);
                    }
                }
            } else if ($transactionStatus == 'settlement') {
                $this->markAsPaid($booking);
            } else if ($transactionStatus == 'pending') {
                $booking->update(['status' => 'pending']);
            } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                $booking->update(['status' => 'cancelled']);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Midtrans Callback Error: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    private function markAsPaid(Booking $booking)
    {
        if (in_array($booking->status, ['pending', 'dp_processed', 'dp_paid'])) {
            $booking->update(['status' => 'dp_paid']);
            try {
                Mail::to($booking->email)->send(new DpConfirmed($booking));
            } catch (\Exception $e) {
                Log::error("Mail error: " . $e->getMessage());
            }
        } elseif (in_array($booking->status, ['confirmed', 'pelunasan_processed'])) {
            $booking->update(['status' => 'confirmed']);
            try {
                Mail::to($booking->email)->send(new PelunasanConfirmed($booking));
            } catch (\Exception $e) {
                Log::error("Mail error: " . $e->getMessage());
            }
        }
    }
}
