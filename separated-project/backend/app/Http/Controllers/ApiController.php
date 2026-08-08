<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    /**
     * Get list of destinations with optional filters.
     */
    public function getDestinations(Request $request)
    {
        $query = Destination::withCount('bookings');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('package_type')) {
            $query->where('package_type', $request->package_type);
        }

        if ($request->filled('promo')) {
            $query->where(function($q) {
                $q->where('is_special_offer', true)
                  ->orWhereNotNull('discount_price');
            });
        }

        if ($request->sort == 'price_asc') {
            $query->orderByRaw("COALESCE(discount_price, price) ASC");
        } elseif ($request->sort == 'price_desc') {
            $query->orderByRaw("COALESCE(discount_price, price) DESC");
        } else {
            if ($request->filled('best_seller')) {
                $query->orderByDesc('bookings_count')
                      ->orderByDesc('loyalty_points');
            }
            $query->orderByRaw("CASE WHEN type = 'tiket' THEN 1 WHEN type = 'paket' THEN 2 WHEN type = 'tourguide' THEN 3 ELSE 4 END")
                  ->latest();
        }

        $destinations = $query->get();

        return response()->json([
            'success' => true,
            'data' => $destinations
        ]);
    }

    /**
     * Get single destination details.
     */
    public function getDestination($id)
    {
        $destination = Destination::find($id);

        if (!$destination) {
            return response()->json([
                'success' => false,
                'message' => 'Destinasi tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $destination
        ]);
    }

    /**
     * Get recommended destinations.
     */
    public function getRecommendations(Request $request)
    {
        $query = Destination::query();

        if ($request->filled('budget')) {
            if ($request->budget == 'economy') {
                $query->where('price', '<', 2000000);
            } elseif ($request->budget == 'mid') {
                $query->whereBetween('price', [2000000, 7000000]);
            } elseif ($request->budget == 'luxury') {
                $query->where('price', '>', 7000000);
            }
        }

        if ($request->filled('package_type')) {
            $query->where('package_type', $request->package_type);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $recommendations = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $recommendations
        ]);
    }

    /**
     * Create a booking.
     */
    public function createBooking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'destination_id' => 'required|exists:destinations,id',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:20',
            'jumlah_orang' => 'required|integer|min:1',
            'tanggal_booking' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

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

        return response()->json([
            'success' => true,
            'message' => 'Pemesanan berhasil dibuat.',
            'data' => $booking->load('destination')
        ], 201);
    }

    /**
     * Get booking details.
     */
    public function getBooking($id)
    {
        $booking = Booking::with('destination')->find($id);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Pemesanan tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $booking
        ]);
    }

    /**
     * Confirm payment.
     */
    public function confirmPayment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Pemesanan tidak ditemukan.'
            ], 404);
        }

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

        return response()->json([
            'success' => true,
            'message' => 'Bukti pembayaran berhasil diunggah.',
            'data' => $booking->load('destination')
        ]);
    }
}
