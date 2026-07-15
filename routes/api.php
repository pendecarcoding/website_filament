<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukHukumController;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/jdihn-sync', [ProdukHukumController::class, 'apiProdukHukum']);

Route::get('home', [ApiController::class, 'home']);
Route::get('products', [ApiController::class, 'products']);
Route::get('products/{produkHukum}', [ApiController::class, 'productDetail']);
Route::get('produkhukum-jdih', [ApiController::class, 'productHukumJdih']);
Route::get('selayangpandang', [ApiController::class, 'selayangPandang']);
Route::get('pages/{slug}', [ApiController::class, 'page']);
Route::get('berita', [ApiController::class, 'berita']);
Route::get('galeri', [ApiController::class, 'galeri']);
Route::get('video', [ApiController::class, 'video']);
Route::get('faq', [ApiController::class, 'faq']);
Route::get('contact', [ApiController::class, 'contact']);
Route::get('statistic', [ApiController::class, 'statistic']);
