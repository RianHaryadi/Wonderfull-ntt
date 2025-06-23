<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Culture;

class CultureController extends Controller
{
    /**
     * Display a listing of the NTT cultural contents.
     */
    public function index()
    {
        $cultures = Culture::latest()->get(); // ambil semua budaya, urut terbaru
        return view('culture.index', compact('cultures'));
    }
}
