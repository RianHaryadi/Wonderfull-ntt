<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Hotel;
use App\Models\TourPackage;
use App\Models\Culture;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $destinations = Destination::latest()->take(3)->get();
        $hotels = Hotel::latest()->take(6)->get();
        $TourPackage = TourPackage::latest()->take(3)->get();
        $cultures = Culture::latest()->take(3)->get();

       return view('home', compact('destinations', 'hotels', 'TourPackage', 'cultures'));
}
}
