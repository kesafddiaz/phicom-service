<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProgressController;
use Illuminate\Support\Facades\Route;
use App\Models\Services;
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

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/progress', [ProgressController::class, 'index'])->name('progress');
Route::get('/services/print/{service}', function (Services $service) {
    $transactions = $service->transactions()->with('item')->get();
    
    return view('services.nota', [
        'service' => $service,
        'transactions' => $transactions
    ]);
})->name('services.print');