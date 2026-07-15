<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Employee;
use App\Models\Page;
use App\Models\Partner;
use App\Models\ProdukHukum;
use App\Models\Slider;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;




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

    public function home(Request $request)
    {
        $selayangPandang = Page::where('title', 'Selayang Pandang')->first();

        return response()->json([
            'branding' => [
                'name' => 'JDIH Kabupaten Bengkalis',
                'tagline' => 'Informasi Hukum dalam Genggaman',
                'logo_url' => asset('assets/img/jdih-image/logo-jdih-bengkalis.png'),
                'website' => 'https://jdih.bengkaliskab.go.id',
            ],
            'sliders' => Slider::query()
                ->latest('id')
                ->get()
                ->map(fn (Slider $slider) => [
                    'id' => $slider->id,
                    'title' => $slider->title,
                    'image_url' => $this->assetStorageUrl($slider->image_path),
                ])
                ->values(),
            'quick_menu' => [
                ['key' => 'produk', 'label' => 'Produk Hukum', 'icon' => 'document-text', 'route' => 'Products'],
                ['key' => 'berita', 'label' => 'Berita', 'icon' => 'newspaper', 'route' => 'News'],
                ['key' => 'video', 'label' => 'Video', 'icon' => 'play-circle', 'route' => 'Video'],
                ['key' => 'galeri', 'label' => 'Galeri', 'icon' => 'images', 'route' => 'Gallery'],
                ['key' => 'faq', 'label' => 'FAQ', 'icon' => 'help-circle', 'route' => 'FAQ'],
                ['key' => 'kontak', 'label' => 'Kontak', 'icon' => 'call', 'route' => 'Contact'],
            ],
            'statistics' => [
                'total_produk_hukum' => ProdukHukum::count(),
                'peraturan_daerah' => ProdukHukum::whereHas('category', fn ($query) => $query->where('name', 'Peraturan Daerah'))->count(),
                'peraturan_bupati' => ProdukHukum::whereHas('category', fn ($query) => $query->where('name', 'Peraturan Bupati'))->count(),
                'keputusan' => ProdukHukum::whereHas('category', fn ($query) => $query->where('name', 'like', '%Keputusan%'))->count(),
            ],
            'latest_products' => ProdukHukum::query()
                ->with('category')
                ->latest('tanggal_penetapan')
                ->limit(5)
                ->get()
                ->map(fn (ProdukHukum $item) => $this->transformProdukHukum($item))
                ->values(),
            'latest_news' => $this->fetchNewsPage(1, 4)['data'],
            'featured_gallery' => $this->fetchGalleryPage(1, 6)['data'],
            'featured_videos' => $this->fetchVideoPage(1, 4)['data'],
            'organization' => Employee::query()
                ->latest('id')
                ->limit(6)
                ->get()
                ->map(fn (Employee $employee) => [
                    'id' => $employee->id,
                    'name' => $employee->nama_pegawai,
                    'position' => $employee->jabatan,
                    'image_url' => $this->assetStorageUrl($employee->image_path),
                ])
                ->values(),
            'partners' => Partner::query()
                ->latest('id')
                ->get()
                ->map(fn (Partner $partner) => [
                    'id' => $partner->id,
                    'name' => $partner->name,
                    'link' => $partner->link,
                    'image_url' => $this->assetStorageUrl($partner->image_path),
                ])
                ->values(),
            'selayang_pandang' => $this->formatPage($selayangPandang),
            'contact' => $this->contactPayload(),
        ]);
    }

    public function productHukumJdih(Request $request)
    {
        $query = ProdukHukum::query()->with('category');

        switch ($request->get('jenis')) {
            case 'perbub':
                $query->whereHas('category', fn ($builder) => $builder->where('name', 'Peraturan Bupati'));
                break;
            case 'perda':
                $query->whereHas('category', fn ($builder) => $builder->where('name', 'Peraturan Daerah'));
                break;
        }

        return response()->json(
            $query->latest('tanggal_penetapan')
                ->get()
                ->map(fn (ProdukHukum $item) => $this->transformProdukHukum($item))
                ->values()
        );
    }

    public function products(Request $request)
    {
        $perPage = max(1, min((int) $request->get('per_page', 10), 50));
        $query = ProdukHukum::query()->with('category');

        if ($request->filled('search')) {
            $keyword = trim((string) $request->get('search'));
            $query->where(function ($builder) use ($keyword) {
                $builder->where('judul', 'like', "%{$keyword}%")
                    ->orWhere('no_peraturan', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('nomor')) {
            $query->where('no_peraturan', 'like', '%' . trim((string) $request->get('nomor')) . '%');
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_penetapan', (int) $request->get('tahun'));
        }

        if ($request->filled('kategori')) {
            $kategori = $request->get('kategori');

            if (is_numeric($kategori)) {
                $query->where('category_id', (int) $kategori);
            } else {
                $query->whereHas('category', fn ($builder) => $builder->where('slug', $kategori)->orWhere('name', $kategori));
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        $paginator = $query->latest('tanggal_penetapan')->paginate($perPage);

        return response()->json([
            'data' => collect($paginator->items())
                ->map(fn (ProdukHukum $item) => $this->transformProdukHukum($item))
                ->values(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
            ],
            'filters' => [
                'categories' => Category::query()
                    ->orderBy('name')
                    ->get()
                    ->map(fn (Category $category) => [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                    ])
                    ->values(),
            ],
        ]);
    }

    public function productDetail(ProdukHukum $produkHukum)
    {
        $produkHukum->load('category');
        $produkHukum->increment('dibaca');
        $produkHukum->refresh();

        return response()->json([
            'data' => $this->transformProdukHukum($produkHukum, true),
        ]);
    }


    public function selayangPandang(Request $r)
    {
        $data = Page::where('title', 'Selayang Pandang')->first();
        return response()->json($this->formatPage($data));
    }

    public function berita(Request $request)
    {
        $page     = (int) $request->get('page', 1);
        $perPage  = (int) $request->get('per_page', 10);
        return response()->json($this->fetchNewsPage($page, $perPage));
    }

    public function galeri(Request $request)
    {
        $page = (int) $request->get('page', 1);
        $perPage = (int) $request->get('per_page', 12);

        return response()->json($this->fetchGalleryPage($page, $perPage));
    }

    public function video(Request $request)
    {
        $page = (int) $request->get('page', 1);
        $perPage = (int) $request->get('per_page', 12);

        return response()->json($this->fetchVideoPage($page, $perPage));
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
            'summary' => [
                'total_produk_hukum' => ProdukHukum::count(),
                'peraturan_bupati' => array_sum($perbub),
                'peraturan_daerah' => array_sum($perda),
            ],
        ]);
    }

    public function faq()
    {
        return response()->json([
            'data' => [
                [
                    'id' => 1,
                    'question' => 'Apa itu JDIH Kabupaten Bengkalis?',
                    'answer' => 'JDIH adalah Jaringan Dokumentasi dan Informasi Hukum yang menyediakan akses terhadap berbagai produk hukum daerah secara lengkap dan mudah diakses.',
                ],
                [
                    'id' => 2,
                    'question' => 'Bagaimana cara mencari produk hukum?',
                    'answer' => 'Anda dapat mencari produk hukum melalui fitur pencarian dengan kata kunci, nomor peraturan, tahun, atau jenis dokumen.',
                ],
                [
                    'id' => 3,
                    'question' => 'Bagaimana cara mengunduh dokumen?',
                    'answer' => 'Buka detail produk hukum yang diinginkan lalu gunakan tombol unduh untuk membuka atau mengunduh dokumen PDF.',
                ],
                [
                    'id' => 4,
                    'question' => 'Apakah semua produk hukum dapat diunduh?',
                    'answer' => 'Sebagian besar dokumen dapat diunduh langsung. Jika ada kendala, silakan hubungi Bagian Hukum Kabupaten Bengkalis.',
                ],
                [
                    'id' => 5,
                    'question' => 'Siapa yang mengelola JDIH Kabupaten Bengkalis?',
                    'answer' => 'JDIH Kabupaten Bengkalis dikelola oleh Bagian Hukum Sekretariat Daerah Kabupaten Bengkalis.',
                ],
            ],
        ]);
    }

    public function contact()
    {
        return response()->json([
            'data' => $this->contactPayload(),
        ]);
    }

    public function page(string $slug)
    {
        $page = Page::where('slug', $slug)->first();

        if (!$page) {
            return response()->json([
                'message' => 'Halaman tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'data' => $this->formatPage($page),
        ]);
    }

    private function fetchNewsPage(int $page, int $perPage): array
    {
        $cacheKey = "api_news_items_page_{$page}_per_page_{$perPage}";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = $this->client->get($this->baseUrl . 'web/link/publikasi');
            $html = (string) $response->getBody();
            $crawler = new Crawler($html);

            $newsItems = [];

            $crawler->filter('.block-content .post')->each(function (Crawler $node) use (&$newsItems) {
                try {
                    $titleNode = $node->filter('.post-title a');
                    $title = $titleNode->text();
                    $link = $titleNode->attr('href');

                    $imageNode = $node->filter('.featured-image img');
                    $imageUrl = $imageNode->attr('src');

                    $categoryNode = $node->filter('.post-link a span');
                    $category = $categoryNode->count() ? $categoryNode->text() : 'Berita';

                    $dateNode = $node->filter('.post-meta .post-comments span');
                    $date = $dateNode->count() ? $dateNode->text() : null;

                    $newsItems[] = [
                        'title' => $title,
                        'link' => $link,
                        'image_url' => $this->absoluteUrl($imageUrl),
                        'category' => $category,
                        'date' => $date,
                    ];
                } catch (\Exception $e) {
                    Log::warning('Error processing news item: ' . $e->getMessage());
                }
            });

            $result = $this->paginateArray($newsItems, $page, $perPage);
            Cache::put($cacheKey, $result, $this->cacheTime);

            return $result;
        } catch (\Exception $e) {
            Log::error('Error scraping news: ' . $e->getMessage());

            return $this->emptyPagination($page, $perPage);
        }
    }

    private function fetchGalleryPage(int $page, int $perPage): array
    {
        $cacheKey = "api_gallery_items_v2_page_{$page}_per_page_{$perPage}";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = $this->client->get($this->baseUrl);
            $html = (string) $response->getBody();
            $crawler = new Crawler($html);

            $galleryItems = [];

            $crawler->filter('.swiper-slide')->each(function (Crawler $node) use (&$galleryItems) {
                try {
                    $titleNode = $node->filter('.post-title a');

                    if ($titleNode->count() === 0) {
                        return;
                    }

                    $link = $titleNode->attr('href');

                    if (!$link || !Str::contains($link, '/web/detailfoto/')) {
                        return;
                    }

                    $imageNode = $node->filter('img.video-cover, .featured-image img, .featured-video img');
                    $dateNode = $node->filter('.post-date span');
                    $imageUrl = $this->extractScrapedImageUrl($imageNode);

                    $galleryItems[] = [
                        'title' => $titleNode->text(),
                        'link' => $link,
                        'image_url' => $imageUrl ? $this->absoluteUrl($imageUrl) : null,
                        'date' => $dateNode->count() ? $dateNode->text() : null,
                    ];
                } catch (\Exception $e) {
                    Log::warning('Error processing gallery item: ' . $e->getMessage());
                }
            });

            $result = $this->paginateArray($galleryItems, $page, $perPage);
            Cache::put($cacheKey, $result, $this->cacheTime);

            return $result;
        } catch (\Exception $e) {
            Log::error('Error scraping gallery: ' . $e->getMessage());

            return $this->emptyPagination($page, $perPage);
        }
    }

    private function fetchVideoPage(int $page, int $perPage): array
    {
        $cacheKey = "api_video_items_page_{$page}_per_page_{$perPage}";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = $this->client->get($this->baseUrl . 'web/link/video-kegiatan');
            $html = (string) $response->getBody();
            $crawler = new Crawler($html);

            $videoItems = [];

            $crawler->filter('.post.type-post')->each(function (Crawler $node) use (&$videoItems) {
                try {
                    $titleNode = $node->filter('.post-title a');

                    if ($titleNode->count() === 0) {
                        return;
                    }

                    $imageNode = $node->filter('.featured-image img');
                    $dateNode = $node->filter('.post-date span');

                    $videoItems[] = [
                        'title' => $titleNode->text(),
                        'link' => $titleNode->attr('href'),
                        'image_url' => $imageNode->count() ? $this->absoluteUrl($imageNode->attr('src')) : null,
                        'date' => $dateNode->count() ? $dateNode->text() : null,
                    ];
                } catch (\Exception $e) {
                    Log::warning('Error processing video item: ' . $e->getMessage());
                }
            });

            $result = $this->paginateArray($videoItems, $page, $perPage);
            Cache::put($cacheKey, $result, $this->cacheTime);

            return $result;
        } catch (\Exception $e) {
            Log::error('Error scraping videos: ' . $e->getMessage());

            return $this->emptyPagination($page, $perPage);
        }
    }

    private function paginateArray(array $items, int $page, int $perPage): array
    {
        $paginator = new LengthAwarePaginator(
            array_slice($items, ($page - 1) * $perPage, $perPage),
            count($items),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return [
            'data' => array_values($paginator->items()),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
            ],
        ];
    }

    private function emptyPagination(int $page, int $perPage): array
    {
        return [
            'data' => [],
            'meta' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => 0,
                'last_page' => 0,
            ],
        ];
    }

    private function transformProdukHukum(ProdukHukum $item, bool $detailed = false): array
    {
        $fileUrl = $this->assetStorageUrl($item->file_produk_hukum);

        return [
            'id' => $item->id,
            'title' => $item->judul,
            'number' => $item->no_peraturan,
            'category' => $item->category?->name,
            'category_slug' => $item->category?->slug,
            'year' => optional($item->tanggal_penetapan)->format('Y'),
            'status' => $item->status ?: 'Berlaku',
            'published_at' => $item->tanggal_penetapan,
            'promulgated_at' => $item->tanggal_diundangkan,
            'read_count' => (int) $item->dibaca,
            'file_url' => $fileUrl,
            'detail_url' => url('/view/produk-hukum/detail/' . urlencode($item->judul)),
            'excerpt' => Str::limit(strip_tags((string) $item->abstract), 120),
            'abstract' => $detailed ? $item->abstract : null,
            'metadata' => [
                'jenis' => $item->category?->name,
                'tahun' => optional($item->tanggal_penetapan)->format('Y'),
                'status' => $item->status ?: 'Berlaku',
                'tanggal_penetapan' => $item->tanggal_penetapan,
                'tanggal_diundangkan' => $item->tanggal_diundangkan,
            ],
        ];
    }

    private function formatPage(?Page $page): ?array
    {
        if (!$page) {
            return null;
        }

        return [
            'id' => $page->id,
            'title' => $page->title,
            'slug' => $page->slug,
            'content_html' => $page->content,
            'content_text' => trim(strip_tags((string) $page->content)),
            'image_url' => $this->assetStorageUrl($page->image_path),
            'is_published' => (bool) $page->is_published,
        ];
    }

    private function contactPayload(): array
    {
        return [
            'address' => 'Jl. Ahmad Yani No. 070 Bengkalis, Kabupaten Bengkalis, Riau 28711',
            'phone' => '(0766) 800 1000',
            'email' => 'bagianhukum@bengkaliskab.go.id',
            'website' => 'https://jdih.bengkaliskab.go.id',
            'map_url' => 'https://www.google.com/maps/search/?api=1&query=Kantor+Bupati+Bengkalis',
        ];
    }

    private function assetStorageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (is_numeric($path)) {
            return null;
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    private function absoluteUrl(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        if (Str::startsWith($url, ['http://', 'https://'])) {
            return $url;
        }

        return rtrim($this->baseUrl, '/') . '/' . ltrim($url, '/');
    }

    private function extractScrapedImageUrl(Crawler $imageNode): ?string
    {
        if ($imageNode->count() === 0) {
            return null;
        }

        foreach (['data-src', 'data-lazy-src', 'src'] as $attribute) {
            $value = $imageNode->attr($attribute);

            if ($value) {
                return $value;
            }
        }

        return null;
    }
}
