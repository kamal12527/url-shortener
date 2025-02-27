<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\UrlShortenerController;

Route::get('/', [UrlShortenerController::class, 'index']);
Route::post('/shorten', [UrlShortenerController::class, 'shorten']);
Route::get('/{shortCode}', [UrlShortenerController::class, 'redirect']);



