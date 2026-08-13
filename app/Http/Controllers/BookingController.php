<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;

class BookingController extends Controller
{
    public function checkout(Request $request)
    {
        $destination = Destination::findOrFail($request->destination_id);
        $travelers = $request->travelers ?? 1;
        
        return view('bookings.checkout', compact('destination', 'travelers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:20',
            'jumlah_orang' => 'required|integer|min:1',
            'tanggal_booking' => 'required|date',
        ]);

        $destination = Destination::findOrFail($request->destination_id);
        
        
        $basePrice = $destination->discount_price ?? $destination->price;
        $totalPrice = $basePrice * $request->jumlah_orang;
        $dpAmount = ($destination->type === 'tiket') ? $totalPrice : ($totalPrice * 0.3); 

        $booking = Booking::create([
            'destination_id' => $request->destination_id,
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'jumlah_orang' => $request->jumlah_orang,
            'tanggal_booking' => $request->tanggal_booking,
            'total_price' => $totalPrice,
            'dp_amount' => $dpAmount,
            'points_earned' => $destination->loyalty_points * $request->jumlah_orang,
            'status' => 'pending'
        ]);

        return redirect()->route('bookings.payment', $booking->id);
    }

    public function payment($id)
    {
        $booking = Booking::with('destination')->findOrFail($id);

        $snapToken = null;
        try {
            if (class_exists('\Midtrans\Config')) {
                \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
                \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
                \Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
                \Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');

                $amount = ($booking->status === 'confirmed') ? ($booking->total_price - $booking->dp_amount) : $booking->dp_amount;
                if ($amount <= 0) {
                    $amount = $booking->total_price;
                }

                $params = [
                    'transaction_details' => [
                        'order_id' => 'TRV-' . $booking->id . '-' . time(),
                        'gross_amount' => (int) $amount,
                    ],
                    'customer_details' => [
                        'first_name' => $booking->nama,
                        'email' => $booking->email,
                        'phone' => $booking->no_hp,
                    ],
                    'item_details' => [
                        [
                            'id' => 'DEST-' . $booking->destination_id,
                            'price' => (int) $amount,
                            'quantity' => 1,
                            'name' => substr($booking->destination->title ?? 'Paket Wisata', 0, 50),
                        ]
                    ]
                ];

                $snapToken = \Midtrans\Snap::getSnapToken($params);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Midtrans Snap Error: ' . $e->getMessage());
        }

        return view('bookings.payment', compact('booking', 'snapToken'));
    }

    public function confirmPayment(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $booking = Booking::findOrFail($id);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payments', 'public');
            
            if (in_array($booking->status, ['pending', 'dp_processed'])) {
                $booking->update([
                    'payment_proof' => $path,
                    'status' => 'dp_processed'
                ]);
            } elseif (in_array($booking->status, ['confirmed', 'pelunasan_processed'])) {
                $booking->update([
                    'pelunasan_proof' => $path,
                    'status' => 'pelunasan_processed'
                ]);
            }
        }

        return redirect()->route('bookings.success', $booking->id);
    }

    public function success($id)
    {
        $booking = Booking::with('destination')->findOrFail($id);
        return view('bookings.success', compact('booking'));
    }

    public function requestCancellation(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->email !== auth()->user()->email) {
            abort(403, 'Unauthorized action.');
        }

        if (!in_array($booking->status, ['dp_paid', 'confirmed'])) {
            return redirect()->back()->with('error', 'Status pesanan tidak dapat diajukan pembatalan.');
        }

        $request->validate([
            'cancellation_reason' => 'required|string|min:10|max:1000',
        ]);

        $booking->update([
            'status' => 'cancel_pending',
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        return redirect()->back()->with('success', 'Pengajuan pembatalan pemesanan Anda berhasil dikirim dan sedang menunggu konfirmasi admin.');
    }

    public function invoice($id)
    {
        $booking = Booking::with('destination')->findOrFail($id);

        if ($booking->email !== auth()->user()->email && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        return view('bookings.invoice', compact('booking'));
    }
}
