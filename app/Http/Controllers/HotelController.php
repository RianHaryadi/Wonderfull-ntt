<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        // Get unique locations for the filter dropdown
        $locations = Hotel::select('location')
                         ->distinct()
                         ->whereNotNull('location')
                         ->orderBy('location')
                         ->pluck('location');

        // Filter hotels based on location if provided
        $hotels = Hotel::when($request->location, function($query) use ($request) {
            return $query->where('location', $request->location);
        })
        ->orderBy('name') // Default sorting
        ->paginate(12); // 12 items per page

        return view('hotel.index', [
            'hotels' => $hotels,
            'locations' => $locations,
            'selectedLocation' => $request->location
        ]);
    }

    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('hotel.show', compact('hotel'));
    }

    
}