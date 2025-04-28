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
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('/personal', [ProfileController::class, 'showForm'])->name('personal');
    Route::post('/personal', [ProfileController::class, 'submitForm'])->name('personal');
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::middleware('auth')->get('/dashboard', [ProfileController::class, 'showDashboard'])->name('dashboard');
});

Route::get('home', [AuthController::class, 'home'])->name('home'); 


//Food
Route::prefix('food')->name('food.')->middleware('auth')->group(function () {
    // Search for food form
    Route::get('search', [FoodController::class, 'search'])->name('search');
    Route::get('search/results', [FoodController::class, 'searchFood'])->name('search.results');

    // Handle the Open Food Facts API interaction
    Route::get('search/open-food-facts', [FoodController::class, 'searchOpenFoodFacts'])->name('search.openFoodFacts');

    // Add food entries to user profile (Make sure this is a POST method)
    Route::post('add/{foodId}', [FoodController::class, 'addFoodToProfile'])->name('add'); // Note: I added {foodId} here for better clarity
    
    // Barcode scanner route
    Route::get('food/barcode/{barcode}', [FoodController::class, 'getFoodByBarcode'])->name('product');
    
    // Remove food from user's profile
    Route::delete('remove/{foodEntryId}', [FoodController::class, 'removeFoodFromProfile'])->name('remove');
    
    // Get suggested foods based on the user's goal
    Route::get('suggested', [FoodController::class, 'getSuggestedFoods'])->name('suggested');
});

// Add food to the user's profile
Route::middleware(['auth'])->group(function () {
    Route::post('/add-food', [FoodController::class, 'store'])->name('add.food');
});

// congratulations page
Route::get('/congratulations', [ProfileController::class, 'showCongratulations'])->name('congratulations');



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