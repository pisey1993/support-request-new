<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\SupportRequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubTaskController;

Route::prefix('support-requests/{supportRequest}')->group(function () {
    Route::post('sub-tasks', [SubTaskController::class, 'store'])->name('support-requests.sub-tasks.store');
});


// Redirect root URL "/" to "/home"
Route::redirect('/', '/home');

// Route for "/home" pointing to index method in SupportRequestController
Route::get('/home', [SupportRequestController::class, 'index'])->name('support-requests.home');
Route::get('/support-requests/home', [SupportRequestController::class, 'index'])->name('support-requests.home');
Route::get('/support-requests/myrequest', [SupportRequestController::class, 'myRequests'])->name('support-requests.myrequest');
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('name', 'password');

    if (Auth::attempt($credentials, $request->remember)) {
        $request->session()->regenerate();
        return redirect()->intended('/support-requests/');
    }

    return back()->with('error', 'Invalid credentials.');
});

Route::middleware('auth')->get('/support-requests/', function () {
    return view('home');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::resource('support-requests', SupportRequestController::class)->middleware('auth');


Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
