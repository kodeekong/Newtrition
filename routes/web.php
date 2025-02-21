<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('home'); 
});

// Authentication Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login'); // Show login form
Route::post('login', [AuthController::class, 'login']); // Handle login
Route::post('logout', [AuthController::class, 'logout'])->name('logout'); // handle logout

Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register'); // Show registration form
Route::post('register', [AuthController::class, 'register']); // handle registration

Route::get('personal', [AuthController::class, 'showUserHome'])->name('personal'); // Show user home page
Route::middleware('auth')->get('/profile', [ProfileController::class, 'showProfileForm'])->name('profile.form');
Route::middleware('auth')->post('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

// Protected routes
Route::get('home', [AuthController::class, 'home'])->name('home'); // Show registration form
