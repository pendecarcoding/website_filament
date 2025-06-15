<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class GalleryScraper {
    private $client;
    private $baseUrl = 'https://diskominfotik.bengkaliskab.go.id/';

    public function __construct() {
        $this->client = new Client([
            'verify' => false, // Disable SSL verification for development
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            ]
        ]);
    }

    public function scrapeGallery() {
        try {
            $response = $this->client->get($this->baseUrl);
            $html = (string) $response->getBody();

            $crawler = new Crawler($html);

            $galleryItems = [];

            // Find all gallery items in the swiper section
            $crawler->filter('.swiper-slide')->each(function (Crawler $node) use (&$galleryItems) {
                $title = $node->filter('.post-title a')->text();
                $link = $node->filter('.post-title a')->attr('href');
                $imageUrl = $node->filter('.video-cover')->attr('src');
                $date = $node->filter('.post-date span')->text();

                $galleryItems[] = [
                    'title' => $title,
                    'link' => $link,
                    'image_url' => $imageUrl,
                    'date' => $date
                ];
            });

            return $galleryItems;

        } catch (\Exception $e) {
            throw new \Exception('Error scraping gallery: ' . $e->getMessage());
        }
    }
}

// Usage example
try {
    $scraper = new GalleryScraper();
    $galleryItems = $scraper->scrapeGallery();

    // Output the results
    foreach ($galleryItems as $item) {
        echo "Title: " . $item['title'] . "\n";
        echo "Link: " . $item['link'] . "\n";
        echo "Image URL: " . $item['image_url'] . "\n";
        echo "Date: " . $item['date'] . "\n";
        echo "------------------------\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
