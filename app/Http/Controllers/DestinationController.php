<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $query = Destination::query();

        // Pencarian berdasarkan nama atau deskripsi
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Ambil hasil paginasi dan simpan query string agar search dan filter tetap aktif saat pindah halaman
        $destinations = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        return view('destinations.index', compact('destinations'));
    }
}
