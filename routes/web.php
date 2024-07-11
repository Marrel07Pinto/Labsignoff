<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\SignController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Auth\PasswordController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [PasswordController::class, 'update'])->name('pass_update');
});
Route::middleware('auth')->group(function () {
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::get('/register', function () {
    return view('auth.register'); 
})->name('register');
Route::get('/seat', function()
                    {
                        return view('seat');
                    })->name('seat');
Route::get('/seatwithnav', function()
                    {
                        return view('seatwithnav');
                    })->name('seatwithnav');
Route::get('/sign', function () 
                    {
                        return view('sign');
                    })->name('sign');
Route::get('/chat', function () 
                    {
                        return view('chat');
                    })->name('chat');
Route::get('/feedback', function () 
                    {
                        return view('feedback');
                    })->name('feedback');
Route::get('/task', function () 
                    {
                        return view('task');
                    })->name('task');
Route::post('/seat_value', [SeatController::class, 'store'])->name('seat_value');
Route::post('/seat_vupdate/{id}', [SeatController::class, 'update'])->name('seat_vupdate');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/query_form',[QueryController::class,'store'])->name('query_form');
Route::post('/sign_form',[SignController::class,'store'])->name('sign_form');
Route::get('/seat', [SeatController::class, 'showSeatSelection'])->name('seat');
Route::get('/home', [SeatController::class, 'homeindex'])->name('home');
Route::get('/query', [QueryController::class, 'show'])->name('query');
Route::get('/delete/{id}', [QueryController::class, 'destroy'])->name('item.delete');
Route::get('/sign', [SignController::class, 'show'])->name('sign');
Route::get('/signd/{id}', [SignController::class, 'destroy'])->name('item.delete');
Route::get('signview/{sign}', [SignController::class, 'signView'])->name('signview');
Route::get('signedit/{id}',[SignController::class,'edit'])->name('signedit');
Route::put('signupdate/{id}',[SignController::class,'update'])->name('signupdate');
Route::post('/chat_form',[ChatController::class,'store'])->name('chat_form');
Route::get('/chat', [ChatController::class, 'show'])->name('chat');
Route::post('/feedback_form',[FeedbackController::class,'store'])->name('feedback_form');

});




require __DIR__.'/auth.php';
