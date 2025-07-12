<?php

namespace App\Services;

use App\Models\ProdukHukum;
use App\Models\Category;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProdukHukumService
{
    public function fetchFromJsonAndStore()
    {
        $response = Http::timeout(30)->get('https://jdih.bengkaliskab.go.id/integrasijdihn/jdihbengkalis/index2.php');

        if (!$response->ok()) {
            throw new \Exception("Failed to fetch data.");
        }

        $dataList = $response->json();

        foreach ($dataList as $item) {
            $fileUrl = $item['urlDownload'];
            $fileName = 'produk_hukum/' . basename($fileUrl);

            // Download the file if not exists
            if (!Storage::disk('public')->exists($fileName)) {
                try {
                    $response = Http::timeout(60)->get($fileUrl);

                    if ($response->successful()) {
                        Storage::disk('public')->put($fileName, $response->body());
                    } else {
                        Log::error("Failed to download file. URL: {$fileUrl}. HTTP status: {$response->status()}");
                        continue; // skip to next item
                    }
                } catch (\Exception $e) {
                    Log::error("Exception while downloading file: {$fileUrl}. Error: {$e->getMessage()}");
                    continue; // skip to next item
                }
            }

            $category = Category::where('name', $item['jenis'])->first();

            ProdukHukum::updateOrCreate(
                ['no_peraturan' => $item['noPeraturan']],
                [
                    'judul' => $item['judul'],
                    'category_id' => $category ? $category->id : null,
                    'tanggal_penetapan' => $item['tanggal_pengundangan'] ?? null,
                    'tanggal_diundangkan' => $item['tanggal_pengundangan'] ?? null,
                    'no_lembaran_daerah' => $item['noPeraturan'],
                    'file_produk_hukum' => $fileName,
                ]
            );
        }
    }
}
