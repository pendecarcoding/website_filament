<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdukHukum;
use App\Services\ProdukHukumService;

class ProdukHukumController extends Controller
{
    public function detail($id)
    {
        $produkHukum = ProdukHukum::where('judul', $id)->first();
        return view('frontend.detailpage.peraturan.index', compact('produkHukum'));
    }

    public function importJson()
    {
        try {
            $message = app(ProdukHukumService::class)->fetchFromJsonAndStore();
            return response()->json(['message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
