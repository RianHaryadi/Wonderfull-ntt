<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use Illuminate\Http\Request;
use App\Models\Hotel;

class PaketTourController extends Controller
{
    public function index(Request $request)
    {
        // Get unique destinations for filter dropdown
        $destinations = TourPackage::select('location')
                         ->distinct()
                         ->orderBy('location')
                         ->pluck('location');

        // Base query with relationships
        $query = TourPackage::with(['variants', 'hotels']);

        // Search filter
        if ($request->has('q')) {
            $searchTerm = '%'.$request->q.'%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('location', 'like', $searchTerm);
            });
        }

        // Destination filter
        if ($request->filled('destination')) {
            $query->where('location', $request->destination);
        }

        // Price filter
        if ($request->filled('price')) {
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

        // Paginate results (12 items per page)
        $paketTours = $query->paginate(12)
                       ->appends($request->query());

        return view('paket_tour.index', [
            'paketTours' => $paketTours,
            'destinations' => $destinations
        ]);
    }

    public function show($id)
    {
        $paketTour = TourPackage::with(['hotels', 'variants'])
                      ->findOrFail($id);

        $availableHotels = $paketTour->nearbyHotels();
        $allHotels = $paketTour->hotels->merge($availableHotels)->unique('id');

        return view('paket_tour.show', [
            'paketTour' => $paketTour,
            'allHotels' => $allHotels
        ]);
    }

    public function updateHotel(Request $request, $id)
    {
        $validated = $request->validate([
            'hotel_id' => 'nullable|exists:hotels,id'
        ]);

        $tourPackage = TourPackage::findOrFail($id);
        $tourPackage->update($validated);

        return back()->with('success', 'Hotel berhasil diperbarui.');
    }
}