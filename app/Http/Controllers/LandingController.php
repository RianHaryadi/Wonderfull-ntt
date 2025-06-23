<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Hotel;
use App\Models\TourPackage;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing', [
            'destinasiUnggulan' => Destination::latest()->take(6)->get(),
            'hotelRekomendasi' => Hotel::latest()->take(5)->get(),
            'paketTourPopuler' => TourPackage::latest()->take(4)->get(),
        ]);
    }
}
