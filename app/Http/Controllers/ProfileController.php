<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    
    public function edit(Request $request): View
    {
        $email = $request->user()->email;
        $bookingsCount = \App\Models\Booking::where('email', $email)->count();
        
        $paidBookings = \App\Models\Booking::where('email', $email)
            ->whereIn('status', ['dp_processed', 'confirmed', 'pelunasan_processed', 'lunas', 'cancel_pending'])
            ->get();
            
        $visitedCount = $paidBookings->pluck('destination_id')->unique()->count();
        $totalPoints = $paidBookings->sum('points_earned');

        return view('profile.edit', [
            'user' => $request->user(),
            'bookingsCount' => $bookingsCount,
            'visitedCount' => $visitedCount,
            'totalPoints' => $totalPoints
        ]);
    }

    
    public function bookings(Request $request): View
    {
        $bookings = \App\Models\Booking::with('destination')
            ->where('email', $request->user()->email)
            ->latest()
            ->get();
            
        return view('profile.bookings', compact('bookings'));
    }

    
    public function savedPlaces(Request $request): View
    {
        $savedDestinations = \App\Models\Destination::whereIn('id', [2, 4])->get();
        return view('profile.saved-places', compact('savedDestinations'));
    }

    
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

}
