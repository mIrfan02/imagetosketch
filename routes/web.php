<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [ImageController::class, 'index']);
Route::post('/upload', [ImageController::class, 'upload']);
Route::get('/test-image', function () {
    $img = Image::make('https://via.placeholder.com/300')->resize(200, 200);
    return $img->response('jpg');
});

