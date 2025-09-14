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

Route::get('produkhukum-jdih', [ApiController::class, 'productHukumJdih']);
Route::get('selayangpandang', [ApiController::class, 'selayangPandang']);
Route::get('berita', [ApiController::class, 'berita']);
Route::get('statistic', [ApiController::class, 'statistic']);
