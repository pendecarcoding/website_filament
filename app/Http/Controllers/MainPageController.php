<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\ProdukHukum;
use App\Models\Employee;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use App\Models\Partner;
use App\Models\Category;

class MainPageController extends Controller
{
    private $client;
    private $baseUrl = 'https://diskominfotik.bengkaliskab.go.id/';
    private $cacheTime = 240; // Cache for 1 minute

    const CATEGORY_PERDA = 'Peraturan Daerah';
    const CATEGORY_BUPATI = 'Peraturan Bupati';

    /**
     * Get data from cache with Redis fallback to regular cache
     *
     * @param string $key
     * @return mixed|null
     */
    private function getFromCache($key)
    {
        try {
            if (Redis::exists($key)) {
                return unserialize(Redis::get($key));
            }
        } catch (\Exception $e) {
            Log::warning('Redis connection failed, falling back to regular cache: ' . $e->getMessage());
        }

        return Cache::get($key);
    }

    /**
     * Store data in cache with Redis fallback to regular cache
     *
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     * @return void
     */
    private function storeInCache($key, $value, $ttl)
    {
        try {
            Redis::setex($key, $ttl, serialize($value));
        } catch (\Exception $e) {
            Log::warning('Redis connection failed, falling back to regular cache: ' . $e->getMessage());
            Cache::put($key, $value, $ttl);
        }
    }

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false, // Disable SSL verification for development
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            ]
        ]);
    }

    /**
     * Display the main page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $partners = Partner::all();
        $sliders = Slider::all();
        $categories = Category::all();
        $produkHukum = ProdukHukum::latest()->paginate(10);
        $employees = Employee::all();
        $countProdukHukumPerda = ProdukHukum::whereHas('category', function ($query) {
            $query->where('name', Self::CATEGORY_PERDA);
        })->count();
        $countProdukHukumBupati = ProdukHukum::whereHas('category', function ($query) {
            $query->where('name', Self::CATEGORY_BUPATI);
        })->count();

        $galleryItems = $this->getGalleryItems(request()->get('page', 1), 6);
        $newsItems = $this->getNewsItems(request()->get('page', 1), 6);

        return view('frontend.page.main', compact('sliders', 'produkHukum', 'employees', 'galleryItems', 'newsItems', 'partners', 'countProdukHukumPerda', 'countProdukHukumBupati', 'categories'));
    }

    public function berita()
    {
        $newsItems = $this->getNewsItems(request()->get('page', 1), 6);
        return view('frontend.page.berita', compact('newsItems'));
    }

    public function galeri()
    {
        $galleryItems = $this->getGalleryItems(request()->get('page', 1), 6);
        return view('frontend.page.galery', compact('galleryItems'));
    }

    public function video()
    {
        $categories = Category::all();
        $videoItems = $this->getVideoItems(request()->get('page', 1), 6);
        return view('frontend.page.video', compact('videoItems'));
    }

    public function produkHukum(Request $request)
    {
        try {
            // Validate the request with custom error messages
            $validated = $request->validate([
                'search' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z0-9\s\-_.,]+$/'],
                'nomor' => ['nullable', 'string', 'max:50', 'regex:/^[A-Za-z0-9\s\-_.,\/]+$/'],
                'tahun' => ['nullable', 'integer', 'min:2016', 'max:' . date('Y')],
                'kategori' => ['nullable', 'exists:categories,id']
            ], [
                'search.regex' => 'Kata kunci hanya boleh berisi huruf, angka, dan karakter dasar.',
                'nomor.regex' => 'Nomor hanya boleh berisi huruf, angka, dan karakter dasar.',
                'tahun.min' => 'Tahun harus antara 2016 dan ' . date('Y'),
                'tahun.max' => 'Tahun harus antara 2016 dan ' . date('Y'),
                'kategori.exists' => 'Kategori yang dipilih tidak valid.'
            ]);

            $query = ProdukHukum::query();

            if ($request->filled('search')) {
                $query->where('judul', 'like', '%' . e($request->search) . '%');
            }

            if ($request->filled('nomor')) {
                $query->where('no_peraturan', 'like', '%' . e($request->nomor) . '%');
            }

            if ($request->filled('tahun')) {
                $query->whereYear('tanggal_penetapan', $request->tahun);
            }

            if ($request->filled('kategori')) {
                $query->where('category_id', $request->kategori);
            }

            $produkHukum = $query->latest()->paginate(10);
            $categories = Category::all();

            // Log successful searches
            Log::info('Successful search', [
                'search' => $request->search,
                'nomor' => $request->nomor,
                'tahun' => $request->tahun,
                'kategori' => $request->kategori,
                'results_count' => $produkHukum->total()
            ]);

            return view('frontend.page.produk-hukum', compact('produkHukum', 'categories'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            Log::warning('Search validation failed', [
                'errors' => $e->errors(),
                'input' => $request->except('_token')
            ]);

            return back()
                ->withInput($request->except('_token'))
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            // Log other exceptions
            Log::error('Search error', [
                'error' => $e->getMessage(),
                'input' => $request->except('_token')
            ]);

            return back()
                ->withInput($request->except('_token'))
                ->withErrors(['error' => 'Terjadi kesalahan dalam pencarian. Silakan coba lagi.']);
        }
    }

    private function getNewsItems($page = 1, $perPage = 10)
    {
        $cacheKey = "news_items_page_{$page}_per_page_{$perPage}";

        // Try to get from cache (Redis or regular cache)
        $cachedData = $this->getFromCache($cacheKey);
        if ($cachedData) {
            return $cachedData;
        }

        try {
            $response = $this->client->get($this->baseUrl . 'web/link/publikasi');
            $html = (string) $response->getBody();
            $crawler = new Crawler($html);

            $newsItems = [];

            // Find all news articles
            $crawler->filter('.block-content .post')->each(function (Crawler $node) use (&$newsItems) {
                try {
                    // Get title and link
                    $titleNode = $node->filter('.post-title a');
                    $title = $titleNode->text();
                    $link = $titleNode->attr('href');

                    // Get image
                    $imageNode = $node->filter('.featured-image img');
                    $imageUrl = $imageNode->attr('src');

                    // Get category
                    $categoryNode = $node->filter('.post-link a span');
                    $category = $categoryNode->text();

                    // Get date
                    $dateNode = $node->filter('.post-meta .post-comments span');
                    $date = $dateNode->text();

                    $newsItems[] = [
                        'title' => $title,
                        'link' => $link,
                        'image_url' => $imageUrl,
                        'category' => $category,
                        'date' => $date
                    ];
                } catch (\Exception $e) {
                    Log::warning('Error processing news item: ' . $e->getMessage());
                }
            });

            // Create paginator instance
            $total = count($newsItems);
            $items = array_slice($newsItems, ($page - 1) * $perPage, $perPage);

            $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
                $items,
                $total,
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            // Store in cache (Redis or regular cache)
            $this->storeInCache($cacheKey, $paginator, $this->cacheTime);

            return $paginator;
        } catch (\Exception $e) {
            Log::error('Error scraping news: ' . $e->getMessage());
            return new \Illuminate\Pagination\LengthAwarePaginator([], 0, $perPage);
        }
    }

    /**
     * Clear news cache
     */
    public function clearNewsCache()
    {
        $pattern = 'news_items_page_*';
        try {
            $keys = Redis::keys($pattern);
            if (!empty($keys)) {
                Redis::del($keys);
            }
        } catch (\Exception $e) {
            Log::warning('Redis connection failed while clearing news cache: ' . $e->getMessage());
        }

        // Clear regular cache as well
        Cache::forget($pattern);

        return response()->json(['message' => 'News cache cleared successfully']);
    }

    /**
     * Get gallery items from the external website with pagination
     *
     * @param int $page
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    private function getGalleryItems($page = 1, $perPage = 10)
    {
        $cacheKey = "gallery_items_page_{$page}_per_page_{$perPage}";

        // Try to get from cache (Redis or regular cache)
        $cachedData = $this->getFromCache($cacheKey);
        if ($cachedData) {
            return $cachedData;
        }

        try {
            $response = $this->client->get($this->baseUrl);
            $html = (string) $response->getBody();

            // Log the response status and content length for debugging
            Log::info('Gallery scraper response status: ' . $response->getStatusCode());
            Log::info('Gallery scraper content length: ' . strlen($html));

            $crawler = new Crawler($html);

            // Check if the main container exists
            $mainContainer = $crawler->filter('.section.panel.overflow-hidden.swiper-parent.uc-dark');
            if ($mainContainer->count() === 0) {
                Log::warning('Gallery container not found in the HTML');
                return new \Illuminate\Pagination\LengthAwarePaginator([], 0, $perPage);
            }

            $galleryItems = [];

            // Find all gallery items in the swiper section
            $crawler->filter('.swiper-slide')->each(function (Crawler $node) use (&$galleryItems) {
                try {
                    // Get title
                    $titleNode = $node->filter('.post-title a');
                    if ($titleNode->count() === 0) {
                        Log::warning('Title element not found in gallery item');
                        return;
                    }
                    $title = $titleNode->text();
                    $link = $titleNode->attr('href');

                    // Get image
                    $imageNode = $node->filter('.video-cover');
                    if ($imageNode->count() === 0) {
                        Log::warning('Image element not found in gallery item');
                        return;
                    }
                    $imageUrl = $imageNode->attr('src');

                    // Get date
                    $dateNode = $node->filter('.post-date span');
                    if ($dateNode->count() === 0) {
                        Log::warning('Date element not found in gallery item');
                        return;
                    }
                    $date = $dateNode->text();

                    $galleryItems[] = [
                        'title' => $title,
                        'link' => $link,
                        'image_url' => $imageUrl,
                        'date' => $date
                    ];
                } catch (\Exception $e) {
                    Log::warning('Error processing gallery item: ' . $e->getMessage());
                }
            });

            // Log the number of items found
            Log::info('Number of gallery items found: ' . count($galleryItems));

            // Create a paginator instance
            $total = count($galleryItems);
            $items = array_slice($galleryItems, ($page - 1) * $perPage, $perPage);

            $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
                $items,
                $total,
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            // Store in cache (Redis or regular cache)
            $this->storeInCache($cacheKey, $paginator, $this->cacheTime);

            return $paginator;
        } catch (\Exception $e) {
            Log::error('Error scraping gallery: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return new \Illuminate\Pagination\LengthAwarePaginator([], 0, $perPage);
        }
    }

    private function getVideoItems($page = 1, $perPage = 10)
    {
        $cacheKey = "video_items_page_{$page}_per_page_{$perPage}";

        // Try to get from cache (Redis or regular cache)
        $cachedData = $this->getFromCache($cacheKey);
        if ($cachedData) {
            return $cachedData;
        }

        try {
            $response = $this->client->get($this->baseUrl . 'web/link/video-kegiatan');
            $html = (string) $response->getBody();
            $crawler = new Crawler($html);

            $videoItems = [];

            // Find all video articles
            $crawler->filter('.post.type-post')->each(function (Crawler $node) use (&$videoItems) {
                try {
                    // Get title and link
                    $titleNode = $node->filter('.post-title a');
                    $title = $titleNode->text();
                    $link = $titleNode->attr('href');

                    // Get image
                    $imageNode = $node->filter('.featured-image img');
                    $imageUrl = $imageNode->attr('src');

                    // Get date
                    $dateNode = $node->filter('.post-date span');
                    $date = $dateNode->text();

                    $videoItems[] = [
                        'title' => $title,
                        'link' => $link,
                        'image_url' => $imageUrl,
                        'date' => $date
                    ];
                } catch (\Exception $e) {
                    Log::warning('Error processing video item: ' . $e->getMessage());
                }
            });

            // Create paginator instance
            $total = count($videoItems);
            $items = array_slice($videoItems, ($page - 1) * $perPage, $perPage);

            $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
                $items,
                $total,
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            // Store in cache (Redis or regular cache)
            $this->storeInCache($cacheKey, $paginator, $this->cacheTime);

            return $paginator;
        } catch (\Exception $e) {
            Log::error('Error scraping videos: ' . $e->getMessage());
            return new \Illuminate\Pagination\LengthAwarePaginator([], 0, $perPage);
        }
    }

    /**
     * Clear video cache
     */
    public function clearVideoCache()
    {
        $pattern = 'video_items_page_*';
        try {
            $keys = Redis::keys($pattern);
            if (!empty($keys)) {
                Redis::del($keys);
            }
        } catch (\Exception $e) {
            Log::warning('Redis connection failed while clearing video cache: ' . $e->getMessage());
        }

        // Clear regular cache as well
        Cache::forget($pattern);

        return response()->json(['message' => 'Video cache cleared successfully']);
    }

    public function privacyPolicy(Request $r)
    {
        return response()->view('privacy-policy');
    }
}
