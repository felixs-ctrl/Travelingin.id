<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $orders = Booking::with('destination')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Booking::with('destination')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function confirm(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'confirmed';
        $booking->save();

        return redirect()->back()->with('success', 'Pesanan berhasil dikonfirmasi.');
    }

    public function confirmDp(Request $request, $id)
    {
        $booking = Booking::with('destination')->findOrFail($id);
        
        if ($booking->destination->type === 'tiket') {
            $booking->status = 'lunas';
            $booking->save();

            try {
                \Illuminate\Support\Facades\Mail::to($booking->email)->send(new \App\Mail\PelunasanConfirmed($booking));
            } catch (\Exception $e) {
                return redirect()->back()->with('success', 'Pembayaran Tiket Lunas berhasil dikonfirmasi. TAPI EMAIL GAGAL DIKIRIM: ' . $e->getMessage());
            }

            return redirect()->back()->with('success', 'Pembayaran Tiket Lunas berhasil dikonfirmasi.');
        }

        $booking->status = 'confirmed';
        $booking->save();

        try {
            \Illuminate\Support\Facades\Mail::to($booking->email)->send(new \App\Mail\DpConfirmed($booking));
        } catch (\Exception $e) {
            return redirect()->back()->with('success', 'Pembayaran Down Payment berhasil dikonfirmasi. TAPI EMAIL GAGAL DIKIRIM: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Pembayaran Down Payment berhasil dikonfirmasi.');
    }

    public function confirmPelunasan(Request $request, $id)
    {
        $booking = Booking::with('destination')->findOrFail($id);
        $booking->status = 'lunas';
        $booking->save();

        try {
            \Illuminate\Support\Facades\Mail::to($booking->email)->send(new \App\Mail\PelunasanConfirmed($booking));
        } catch (\Exception $e) {
            return redirect()->back()->with('success', 'Pembayaran Pelunasan berhasil dikonfirmasi. Status pesanan diubah menjadi Lunas. TAPI EMAIL GAGAL: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Pembayaran Pelunasan berhasil dikonfirmasi. Status pesanan diubah menjadi Lunas.');
    }

    public function approveCancellation(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->status !== 'cancel_pending') {
            return redirect()->back()->with('error', 'Status pesanan tidak valid.');
        }

        $booking->status = 'cancelled';
        $booking->save();

        return redirect()->back()->with('success', 'Pengajuan pembatalan berhasil disetujui. Status pesanan diubah menjadi Dibatalkan.');
    }

    public function rejectCancellation(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->status !== 'cancel_pending') {
            return redirect()->back()->with('error', 'Status pesanan tidak valid.');
        }

        $booking->status = 'confirmed';
        $booking->save();

        return redirect()->back()->with('success', 'Pengajuan pembatalan ditolak. Status pesanan dikembalikan menjadi Terkonfirmasi.');
    }
}
