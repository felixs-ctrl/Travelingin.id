<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Destination::withCount('bookings');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('package_type')) {
            $query->where('package_type', $request->package_type);
        }

        // Filter by Promo
        if ($request->filled('promo')) {
            $query->where(function($q) {
                $q->where('is_special_offer', true)
                  ->orWhereNotNull('discount_price');
            });
        }

        // Apply Sorting / Ordering
        if ($request->sort == 'price_asc') {
            $query->orderByRaw("COALESCE(discount_price, price) ASC");
        } elseif ($request->sort == 'price_desc') {
            $query->orderByRaw("COALESCE(discount_price, price) DESC");
        } else {
            // If best seller is active and no price sort is requested, prioritize bookings count and loyalty points
            if ($request->filled('best_seller')) {
                $query->orderByDesc('bookings_count')
                      ->orderByDesc('loyalty_points');
            }
            
            // Default sort sequence: tiket -> paket -> tourguide, then latest
            $query->orderByRaw("CASE WHEN type = 'tiket' THEN 1 WHEN type = 'paket' THEN 2 WHEN type = 'tourguide' THEN 3 ELSE 4 END")
                  ->latest();
        }

        $destinations = $query->get();

        return view('destinations.index', compact('destinations'));
    }

    public function specialOffers()
    {
        $offers = Destination::where('is_special_offer', true)
            ->orWhereNotNull('discount_price')
            ->latest()
            ->get();
            
        return view('special-offers', compact('offers'));
    }

    
    public function create()
    {
    return view('destinations.create');
    }

    public function store(Request $request)
    {
    Destination::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
    ]);

    return redirect('/destinations');
    }

    
    public function show(Destination $destination)
    {
        return view('destinations.show', compact('destination'));
    }

    
    public function edit(Destination $destination)
    {
        $destination = Destination::findOrFail($id);
        return view('destinations.edit', compact('destination'));
    }

    
    public function update(Request $request, $id)
    {
    $destination = Destination::findOrFail($id);

    $destination->update([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
    ]);

    return redirect('/destinations');
    }

    public function destroy($id)
    {
    $destination = Destination::findOrFail($id);
    $destination->delete();

    return redirect('/destinations');
    }

    
    public function recommend(Request $request)
    {
        if (!$request->has('step')) {
            return view('destinations.recommend-form');
        }

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

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'destinations' => $recommendations
            ]);
        }

        return view('destinations.recommend-results', compact('recommendations'));
    }
}
