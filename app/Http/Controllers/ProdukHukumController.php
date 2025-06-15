<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdukHukum;

class ProdukHukumController extends Controller
{
    public function detail($id)
    {
        $produkHukum = ProdukHukum::where('judul', $id)->first();
        return view('frontend.detailpage.peraturan.index', compact('produkHukum'));
    }
}
