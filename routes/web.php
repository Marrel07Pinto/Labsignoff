<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\SignController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::get('/seat', function()
                    {
                        return view('seat');
                    })->name('seat');
Route::get('/sign', function () 
                    {
                        return view('sign');
                    });
Route::get('/query', function () 
                    {
                        return view('query');
                    });
Route::post('/seat_value', [SeatController::class, 'store'])->name('seat_value');
Route::post('/seat_vupdate/{id}', [SeatController::class, 'update'])->name('seat_vupdate');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/query_form',[QueryController::class,'store'])->name('query_form');
Route::post('/sign_form',[SignController::class,'store'])->name('sign_form');

require __DIR__.'/auth.php';
