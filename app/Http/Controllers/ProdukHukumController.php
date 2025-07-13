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
        if ($produkHukum !== null) {
            $totalBaca = $produkHukum->dibaca + 1;
            ProdukHukum::where('judul', $id)->update([
                'dibaca' => $totalBaca
            ]);
        }
        return view('frontend.detailpage.peraturan.index', compact('produkHukum'));
    }

    public function importJson($year)
    {
        try {
            $message = app(ProdukHukumService::class)->fetchFromJsonAndStore($year);
            return response()->json(['message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
