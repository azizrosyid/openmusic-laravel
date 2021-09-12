<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollaborationController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\PlaylistSongController;
use App\Http\Controllers\SongController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::name("song.")->group(function () {
    Route::post('/songs', [SongController::class, 'store']);
    Route::get('/songs', [SongController::class, 'index']);
    Route::get('/songs/{song}', [SongController::class, 'show']);
    Route::put('/songs/{song}', [SongController::class, 'update']);
    Route::delete('/songs/{song}', [SongController::class, 'destroy']);
});

Route::name("auth.")->group(function () {
    Route::post('/users', [AuthController::class, 'store'])->name('register');
    Route::post('/authentications', [AuthController::class, 'login'])->name('login');
    Route::delete('/authentications', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
});

Route::name("playlist.")->middleware('auth:sanctum')->group(function () {
    Route::post('/playlists', [PlaylistController::class, 'store']);
    Route::get('/playlists', [PlaylistController::class, 'index']);
    Route::delete('/playlists/{playlist}', [PlaylistController::class, 'destroy']);
});

Route::name("playlist.song.")->middleware('auth:sanctum')->group(function () {
    Route::post('/playlists/{playlist}/songs/{song}', [PlaylistSongController::class, 'store']);
    Route::get('/playlists/{playlist}/songs', [PlaylistSongController::class, 'index']);
    Route::delete('/playlists/{playlist}/songs/{song}', [PlaylistSongController::class, 'destroy']);
});

Route::name('collaboration.')->middleware('auth:sanctum')->group(function () {
    Route::post('/collaborations', [CollaborationController::class, 'store']);
    Route::delete('/collaborations', [CollaborationController::class, 'destroy']);
});
