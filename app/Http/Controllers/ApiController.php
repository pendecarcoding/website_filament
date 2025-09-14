<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdukHukum;
use App\Services\ProdukHukumService;
use App\Models\Page;

class ApiController extends Controller
{
    public function productHukumJdih(Request $request)
    {
        if ($request->jenis = 'perbub') {
            $produkHukum = ProdukHukum::where('category_id', '3')->get();
        } elseif ($request->jenis == 'perda') {
            $produkHukum = ProdukHukum::where('category_id', '5')->get();
        } else {
            $produkHukum = ProdukHukum::all();
        }

        return response()->json($produkHukum);
    }

    public function selayangPandang(Request $r)
    {
        $data = Page::where('title', 'Selayang Pandang')->first();
        return response()->json($data);
    }
}
