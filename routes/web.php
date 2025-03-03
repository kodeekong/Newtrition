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

// Route::get('personal', [AuthController::class, 'showUserHome'])->name('personal');

Route::middleware('auth')->group(function () {
    Route::get('/personal', [ProfileController::class, 'showForm'])->name('personal');
    Route::post('/personal', [ProfileController::class, 'submitForm']);
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::middleware('auth')->get('/dashboard', [ProfileController::class, 'showDashboard'])->name('dashboard');
});

Route::get('home', [AuthController::class, 'home'])->name('home'); // Show registration form

//Profile
// Route::middleware(['auth'])->group(function () {
//     // Show the profile form to fill in data
//     Route::get('/profile/form', [ProfileController::class, 'showProfileForm'])->name('profile.form');

//     // Handle profile form submission
//     Route::post('/profile/submit', [ProfileController::class, 'submitProfile'])->name('profile.submit');

//     // Show profile completion page
//     Route::get('/profile/complete', [ProfileController::class, 'showProfileCompletion'])->name('profile.complete');

//     // Calculate daily calorie needs based on user profile
//     Route::get('/profile/calories', [ProfileController::class, 'calculateDailyCalorieNeeds'])->name('profile.calories');
// });