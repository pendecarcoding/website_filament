<?php

namespace App\Services;

use App\Models\ProdukHukum;
use App\Models\Category;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProdukHukumService
{
    public function fetchFromJsonAndStore()
    {
        $response = Http::get('https://jdih.bengkaliskab.go.id/integrasijdihn/jdihbengkalis/index2.php');

        if (!$response->ok()) {
            throw new \Exception("Failed to fetch data.");
        }

        $dataList = $response->json();

        foreach ($dataList as $item) {
            // Download file
            $fileUrl = $item['urlDownload'];
            $fileName = 'produk_hukum/' . basename($fileUrl);

            // Only download if it doesn't exist
            if (!Storage::disk('public')->exists($fileName)) {
                $fileContents = Http::get($fileUrl)->body();
                Storage::disk('public')->put($fileName, $fileContents);
            }

            //
            $category = Category::where('name', $item['jenis'])->first();

            // Save to database
            ProdukHukum::updateOrCreate(
                ['no_peraturan' => $item['noPeraturan']],
                [
                    'judul' => $item['judul'],
                    'category_id' => $category->id,
                    'tanggal_penetapan' => $item['tanggal_pengundangan'], // not available
                    'tanggal_diundangkan' => $item['tanggal_pengundangan'],
                    'no_lembaran_daerah' => $item['noPeraturan'], // not provided
                    'file_produk_hukum' => $fileName,
                ]
            );
        }

        return count($dataList) . " data items processed.";
    }
}
