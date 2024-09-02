<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\SignController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\TaregistrationController;
use App\Http\Controllers\TaskuploadController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::middleware('auth')->group(function () {
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/edit', [PasswordController::class, 'update'])->name('pass_update');
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
Route::get('/usersprofile', function () 
                    {
                        return view('usersprofile');
                    })->name('usersprofile');
Route::get('/edit', function()
                    {
                        return view('edit');
                    })->name('edit');
Route::get('/adminedit', function()
                    {
                        return view('adminedit');
                    })->name('adminedit');
Route::get('/taedit', function()
                    {
                        return view('taedit');
                    })->name('taedit');
Route::get('/adminseatview', function() {
                        return view('adminseatview');
                    })->name('adminseatview');
Route::get('/admintask', function() {
                        return view('admintask');
                    })->name('admintask');
Route::get('/adminchat', function() {
                        return view('adminchat');
                    })->name('adminchat');
Route::get('/adminquery', function() {
                        return view('adminquery');
                    })->name('adminquery');
Route::get('/taskupload', function() {
                        return view('taskupload');
                    })->name('taskupload');
Route::get('/taqueries', function() {
                        return view('taqueries');
                    })->name('taqueries');
Route::get('/tasign', function() {
                        return view('tasign');
                    })->name('tasign');
Route::get('/attendance', function() {
                        return view('attendance');
                    })->name('attendance');
Route::get('/adminfeedback', function() {
                        return view('adminfeedback');
                    })->name('adminfeedback');
Route::get('/search', function() {
                        return view('search');
                    })->name('search');
Route::post('/seat_value', [SeatController::class, 'store'])->name('seat_value');
Route::post('/seat_vupdate/{id}', [SeatController::class, 'update'])->name('seat_vupdate');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/query_form',[QueryController::class,'store'])->name('query_form');
Route::post('/sign_form',[SignController::class,'store'])->name('sign_form');
Route::get('/seat', [SeatController::class, 'showSeatSelection'])->name('seat');
Route::get('/seatwithnav', [SeatController::class, 'show'])->name('seatwithnav');
Route::get('/home', [SeatController::class, 'homeindex'])->name('home');
Route::get('/query', [QueryController::class, 'show'])->name('query');
Route::get('/query/{id}', [QueryController::class, 'destroy'])->name('query.delete');
Route::get('/sign', [SignController::class, 'show'])->name('sign');
Route::get('/signd/{id}', [SignController::class, 'destroy'])->name('item.delete');
Route::get('signview/{sign}', [SignController::class, 'signView'])->name('signview');
Route::get('signedit/{id}',[SignController::class,'edit'])->name('signedit');
Route::put('signupdate/{id}',[SignController::class,'update'])->name('signupdate');
Route::post('/chat_form',[ChatController::class,'store'])->name('chat_form');
Route::get('/chat', [ChatController::class, 'show'])->name('chat');
Route::post('/feedback_form',[FeedbackController::class,'store'])->name('feedback_form');
Route::get('/usersprofile', [ProfileController::class, 'show'])->name('usersprofile');
Route::put('profileuserupdate/{id}',[ProfileController::class,'profileuupdate'])->name('profileuserupdate');
Route::get('/delete/{id}', [ProfileController::class, 'delete'])->name('profileuser.delete');
Route::get('/adminseatview', [SeatController::class, 'adminseatshow'])->name('adminseatview');
Route::get('/adminchat', [ChatController::class, 'adminshow'])->name('adminchat');
Route::get('/adminquery', [QueryController::class, 'showQueries'])->name('adminquery');
Route::get('/taqueries', [QueryController::class, 'taQueries'])->name('taqueries');
Route::post('/taqueries', [QueryController::class, 'query_solution'])->name('query_solution');
Route::get('/refresh-queries', [QueryController::class, 'refreshqueries'])->name('refresh_queries');
Route::post('/update-query-status', [QueryController::class, 'QueryStatus'])->name('query_status');
Route::get('/adminsign', [SignController::class, 'showsign'])->name('adminsign');
Route::get('/refresh-sign', [SignController::class, 'refreshsigns'])->name('refresh_signs');
Route::post('/tasign', [SignController::class, 'signsolution'])->name('sign_solution');
Route::post('/update-sign-status', [SignController::class, 'SignStatus'])->name('sign_status');
Route::get('/tasign', [SignController::class, 'tasign'])->name('tasign');
Route::get('/chat', [ChatController::class, 'showlayout'])->name('chat');
Route::post('/taskupload',[TaskuploadController::class,'store'])->name('task_upload_form');
Route::get('/taskupload', [TaskuploadController::class, 'show'])->name('taskupload');
Route::get('/taskuploadedit/{id}', [TaskuploadController::class, 'edit'])->name('taskuploadedit');
Route::put('/task/update/{id}', [TaskuploadController::class, 'update'])->name('task_update_form');
Route::delete('/task/delete/{id}', [TaskuploadController::class, 'destroy'])->name('edittaskadmin.delete');
Route::get('/task', [TaskuploadController::class, 'labdetails'])->name('task');
Route::get('/adminfeedback', [FeedbackController::class, 'show'])->name('adminfeedback');
Route::get('/chat/refresh', [ChatController::class, 'refreshchat'])->name('chat.refresh');
Route::get('/adminchat/refresh', [ChatController::class, 'adminrefreshchat'])->name('msg.refresh');
Route::get('/attendance', [AttendanceController::class, 'show'])->name('attendance');
Route::get('/download-csv', [AttendanceController::class, 'downloadcsv'])->name('downloadcsvforatten');
Route::post('/reset-in-progress-queries', [QueryController::class, 'resetinprogressquery'])->name('reset_in_progressqueries');
Route::post('/reset-in-progress-signs', [SignController::class, 'resetinprogresssign'])->name('reset_in_progresssign');
Route::post('/search', [SearchController::class, 'show'])->name('searchbar');
Route::put('/signoff-update/{id}', [SignController::class, 'signupdatestd'])->name('signoff_edit');
Route::put('/attendance-update/{id}', [AttendanceController::class, 'attenupdate'])->name('attendance_update');

});





require __DIR__.'/auth.php';
