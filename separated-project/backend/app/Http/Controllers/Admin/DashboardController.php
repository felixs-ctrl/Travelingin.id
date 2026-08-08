<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Destination;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Destination::count();
        $totalOrders = Booking::count();
        
        
        $pendingOrders = Booking::where('status', 'dp_paid')->count();
        $confirmedOrders = Booking::where('status', 'confirmed')->count();

        
        $revenue = Booking::where('bookings.status', 'confirmed')
            ->join('destinations', 'bookings.destination_id', '=', 'destinations.id')
            ->sum(\DB::raw('destinations.price * bookings.jumlah_orang'));

        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalOrders', 
            'pendingOrders', 
            'confirmedOrders',
            'revenue'
        ));
    }
}
