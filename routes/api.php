<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenraController;
use App\Http\Controllers\SongController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// public route
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);







// protected route

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/artist', [ArtistController::class, 'index']);
    Route::get('/artist/{id}', [ArtistController::class, 'show']);
    Route::get('/artist/search/{search}', [ArtistController::class, 'search']);

    Route::get('/album', [AlbumController::class, 'index']);
    Route::get('/album/{id}', [AlbumController::class, 'show']);
    Route::get('/album/search/{search}', [AlbumController::class, 'search']);

    Route::get('/song', [SongController::class, 'index']);
    Route::get('/song/{id}', [SongController::class, 'show']);
    Route::get('/song/search/{search}', [SongController::class, 'search']);
    Route::get('/song/search/{field}/{search}', [SongController::class, 'fieldSearch']);

    Route::post('/artist/create', [ArtistController::class, 'store']);
    Route::post('/artist/update/{id}', [ArtistController::class, 'update']);
    Route::delete('/artist/delete/{id}', [ArtistController::class, 'destroy']);

    Route::post('/album/create', [AlbumController::class, 'store']);
    Route::post('/album/update/{id}', [AlbumController::class, 'update']);
    Route::delete('/album/delete/{id}', [AlbumController::class, 'destroy']);

    Route::post('/song/create', [SongController::class, 'store']);
    Route::post('/song/update/{id}', [SongController::class, 'update']);
    Route::delete('/song/delete/{id}', [SongController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
});


