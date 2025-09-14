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

    public function apiProdukHukum(Request $r)
    {
        try {
            $produkHukum = ProdukHukum::all();
            $response =  $produkHukum->map(function ($item) {
                return [
                    'idData' => $item->id,
                    'tahun_pengundangan' => \Carbon\Carbon::parse($item->tanggal_diundangkan)->format('Y'),
                    'tanggal_pengundangan' => $item->tanggal_diundangkan,
                    'jenis' => 'Peraturan Bupati', // if fixed
                    'noPeraturan' => $item->no_peraturan,
                    'judul' => $item->judul,
                    'noPanggil' => '-', // placeholder if not in your table
                    'singkatanJenis' => 'Perbup', // if fixed
                    'tempatTerbit' => 'Bengkalis', // fixed or optional
                    'penerbit' => 'Pemerintah Kabupaten Bengkalis',
                    'deskripsiFisik' => '-',
                    'sumber' => '-',
                    'subjek' => '-',
                    'isbn' => '-',
                    'status' => 'Berlaku', // or from status column
                    'bahasa' => 'Indonesia',
                    'bidangHukum' => 'Pemerintah',
                    'teuBadan' => '-',
                    'nomorIndukBuku' => '-',
                    'fileDownload' => $item->file_produk_hukum,
                    'urlDownload' => asset('storage/' . $item->file_produk_hukum),
                    'abstrak' => '-',
                    'urlabstrak' => '-',
                    'urlDetailPeraturan' => url('/web/detailperaturan/' . $item->id),
                    'operasi' => '4',
                    'display' => '1',
                ];
            });

            return response()->json($response);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function productHukumJdih(Request $request)
    {
        if ($request->jenis = 'perbub') {
            $produkHukum = ProdukHukum::where('category_id', '3')->get();
        } elseif ($request->jenis == 'perda') {
            $produkHukum = ProdukHukum::where('category_id', '5')->get();
        }

        return response()->json($produkHukum);
    }
}
