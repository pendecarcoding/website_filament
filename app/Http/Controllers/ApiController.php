<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\ProdukHukum;
use App\Services\ProdukHukumService;
use App\Models\Page;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Cache;




class ApiController extends Controller
{

    private $client;
    private $baseUrl = 'https://diskominfotik.bengkaliskab.go.id/';
    private $cacheTime = 240; // Cache for 1 minute

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false, // Disable SSL verification for development
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            ]
        ]);
    }

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

    public function berita(Request $request)
    {
        $page     = (int) $request->get('page', 1);
        $perPage  = (int) $request->get('per_page', 10);
        $cacheKey = "news_items_page_{$page}_per_page_{$perPage}";

        // cek cache
        if (Cache::has($cacheKey)) {
            return response()->json(Cache::get($cacheKey));
        }

        try {
            $response = $this->client->get($this->baseUrl . 'web/link/publikasi');
            $html = (string) $response->getBody();
            $crawler = new Crawler($html);

            $newsItems = [];

            $crawler->filter('.block-content .post')->each(function (Crawler $node) use (&$newsItems) {
                try {
                    $titleNode = $node->filter('.post-title a');
                    $title     = $titleNode->text();
                    $link      = $titleNode->attr('href');

                    $imageNode = $node->filter('.featured-image img');
                    $imageUrl  = $imageNode->attr('src');

                    $categoryNode = $node->filter('.post-link a span');
                    $category     = $categoryNode->text();

                    $dateNode = $node->filter('.post-meta .post-comments span');
                    $date     = $dateNode->text();

                    $newsItems[] = [
                        'title'     => $title,
                        'link'      => $link,
                        'image_url' => $imageUrl,
                        'category'  => $category,
                        'date'      => $date,
                    ];
                } catch (\Exception $e) {
                    Log::warning('Error processing news item: ' . $e->getMessage());
                }
            });

            $total = count($newsItems);
            $items = array_slice($newsItems, ($page - 1) * $perPage, $perPage);

            $paginator = new LengthAwarePaginator(
                $items,
                $total,
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            $result = [
                'data' => $paginator->items(),
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'per_page'     => $paginator->perPage(),
                    'total'        => $paginator->total(),
                    'last_page'    => $paginator->lastPage(),
                ]
            ];

            Cache::put($cacheKey, $result, $this->cacheTime);

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Error scraping news: ' . $e->getMessage());

            return response()->json([
                'data' => [],
                'meta' => [
                    'current_page' => $page,
                    'per_page'     => $perPage,
                    'total'        => 0,
                    'last_page'    => 0,
                ]
            ], 500);
        }
    }

    public function statistic(Request $r)
    {
        // Range tahun
        $years = range(2016, 2025);

        // Ambil data jumlah dokumen per tahun
        // Misal tabel: produk_hukum (id, kategori, tahun, ...)
        $perbub = [];
        $perda = [];

        foreach ($years as $year) {
            $perbub[] = ProdukHukum::where('category_id', '3')
                ->whereYear('tanggal_penetapan', $year)
                ->count();

            $perda[] = ProdukHukum::where('category_id', '5')
                ->whereYear('tanggal_penetapan', $year)
                ->count();
        }

        return response()->json([
            'years' => $years,
            'data' => [
                'perbub' => $perbub,
                'perda'  => $perda,
            ],
        ]);
    }
}
