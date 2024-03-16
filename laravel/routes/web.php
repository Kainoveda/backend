<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerificationController;

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

Route::get('/confirm/{user}', 'ConfirmationController@confirm')->name('confirmation.confirm');
// In your web.php routes file
Route::get('/verify/{user}/{token}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/artists', [AuthController::class, 'index'])->name('artists.index');



