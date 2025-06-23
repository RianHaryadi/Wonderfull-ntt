<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use Illuminate\Http\Request;
use App\Models\Hotel;

class PaketTourController extends Controller
{
    public function index(Request $request)
{
    $query = TourPackage::with('variants');

    if ($request->has('q')) {
        $query->where('name', 'like', '%' . $request->q . '%')
              ->orWhere('location', 'like', '%' . $request->q . '%');
    }

    if ($request->destination) {
        $query->where('location', $request->destination);
    }

    if ($request->price) {
        switch ($request->price) {
            case 'under-1000000':
                $query->where('price', '<', 1000000);
                break;
            case '1-3':
                $query->whereBetween('price', [1000000, 3000000]);
                break;
            case '3-5':
                $query->whereBetween('price', [3000000, 5000000]);
                break;
            case 'above-5000000':
                $query->where('price', '>', 5000000);
                break;
        }
    }

    $paketTours = $query->get();

    return view('paket_tour.index', compact('paketTours'));
}


   public function show($id)
    {
        $paketTour = TourPackage::with('hotels')->findOrFail($id);
        $availableHotels = $paketTour->nearbyHotels();

        // Gabungkan hotel dari pivot dan nearbyHotels tanpa duplikat
        $allHotels = $paketTour->hotels->merge($availableHotels)->unique('id');

        return view('paket_tour.show', compact('paketTour', 'allHotels'));
    }
    public function updateHotel($id)
   {
       $variant = TourPackage::findOrFail($id);
       $data = request()->validate([
           'hotel_id' => 'nullable|exists:hotels,id',
       ]);

       $variant->update($data);

       return redirect()->back()->with('success', 'Hotel berhasil diperbarui.');
   }

   
}
