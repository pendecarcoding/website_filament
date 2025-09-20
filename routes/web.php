<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\ProdukHukumController;
use App\Http\Controllers\PageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainPageController::class, 'index'])->name('home');
Route::get('/clear-news-cache', [MainPageController::class, 'clearNewsCache'])->name('clear.news.cache');
Route::get('/berita', [MainPageController::class, 'berita'])->name('berita');
Route::get('/galeri', [MainPageController::class, 'galeri'])->name('galeri');
Route::get('/video', [MainPageController::class, 'video'])->name('video');
Route::get('/produk-hukum', [MainPageController::class, 'produkHukum'])->name('produk-hukum');
Route::get('/view/produk-hukum/detail/{id}', [ProdukHukumController::class, 'detail'])->name('produk-hukum.detail');
Route::get('/statistik', [App\Http\Controllers\Frontend\StatistikController::class, 'index'])->name('statistik');
Route::match(['get', 'post'], '/page/{slug}', [PageController::class, 'index'])->name('page');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');

Route::get('/import-produkhukum/{year}', [ProdukHukumController::class, 'importJson']);

Route::get('Privacy-Policy', [MainPageController::class, 'privacyPolicy']);
