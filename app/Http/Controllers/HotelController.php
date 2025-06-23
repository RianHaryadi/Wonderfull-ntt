<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $location = $request->input('location');

        $hotels = Hotel::when($location, function ($query, $location) {
            return $query->where('location', $location);
        })->get();
        
        return view('hotel.index', compact('hotels'));
    }
}
