<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\SongController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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
Route::get('/users', [AuthController::class, 'index']);

Route::put('/ban', [AuthController::class, 'banUser']);

Route::get('/all', [AuthController::class, 'all']);

Route::post('/upload', [UploadController::class, 'upload']);

Route::get('/songs', [SongController::class, 'getAllMusic']);


Route::prefix('api')->group(function () {
    Route::put('/artists/{artistId}/approve', [AuthController::class, 'approveArtist']);
    Route::put('/artists/{artistId}/decline', [AuthController::class, 'declineArtist']);
});

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user'])->name('user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
