<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FoodController;


Route::get('/', function () {
    return view('home'); 
});

// Authentication Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']); 
Route::post('logout', [AuthController::class, 'logout'])->name('logout'); 

Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']); // handle registration

Route::middleware('auth')->group(function () {
    Route::get('/personal', [ProfileController::class, 'showForm'])->name('personal');
    Route::post('/personal', [ProfileController::class, 'submitForm'])->name('personal');
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::middleware('auth')->get('/dashboard', [ProfileController::class, 'showDashboard'])->name('dashboard');
});

Route::get('home', [AuthController::class, 'home'])->name('home'); // Show registration form

//Food

Route::prefix('food')->name('food.')->middleware('auth')->group(function () {
    Route::get('search', [FoodController::class, 'search'])->name('search'); // Show search form and list all foods
    Route::get('search/results', [FoodController::class, 'searchFood'])->name('search.results'); // Handle food search
    Route::get('search/open-food-facts', [FoodController::class, 'searchOpenFoodFacts'])->name('search.openFoodFacts'); // Search Open Food Facts API
    Route::post('add', [FoodController::class, 'addFood'])->name('add'); // Add food to food entries
    Route::get('add/{id}', [FoodController::class, 'addOpenFoodToDatabase'])->name('add.openFood'); // Add food from Open Food Facts to the database
});


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