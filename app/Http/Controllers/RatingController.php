<?php

namespace App\Http\Controllers;

use App\Models\JenisLayanan;
use App\Models\Unit;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function create(Request $request)
    {
        // Ambil daftar layanan aktif — sesuaikan query bila perlu (mis. only active)
        $layanans = JenisLayanan::orderBy('nama')->get();
        $upts = Unit::orderBy('name')->get();

        // Pass juga query params supaya form bisa prefill (controller view sudah memakai request())
        return view('pengaduan.rating-landing', compact('layanans', 'upts'));
    }
}
