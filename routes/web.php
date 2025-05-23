<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\ExerciseController;

// Public homepage
Route::get('/', function () {
    return view('home');
});

// Authentication Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::get('home', [AuthController::class, 'home'])->name('home');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard and Profile
    Route::get('/dashboard', [ProfileController::class, 'showDashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::get('/personal', [ProfileController::class, 'showForm'])->name('personal');
    Route::post('/personal', [ProfileController::class, 'submitForm'])->name('personal');
    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('edit.profile');
    Route::post('/profile/submit', [ProfileController::class, 'submitForm'])->name('profile.submit');

    // Food Routes
    Route::prefix('food')->name('food.')->group(function () {
        Route::get('search', [FoodController::class, 'search'])->name('search');
        Route::get('entries', [FoodController::class, 'index'])->name('entries');
        Route::post('store', [FoodController::class, 'store'])->name('store');
        Route::delete('entries/{id}', [FoodController::class, 'destroy'])->name('remove');
        Route::get('barcode/{barcode}', [FoodController::class, 'getFoodByBarcode'])->name('barcode');
        Route::put('entries/{id}', [FoodController::class, 'update'])->name('update');
    });

    // Add food (separate route if needed)
    Route::post('/add-food', [FoodController::class, 'store'])->name('add.food');

    // Exercise routes
    Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercises.index');
    Route::get('/exercises/create', [ExerciseController::class, 'create'])->name('exercises.create');
    Route::post('/exercises', [ExerciseController::class, 'store'])->name('exercises.store');
    Route::delete('/exercises/{exercise}', [ExerciseController::class, 'destroy'])->name('exercises.destroy');
    Route::get('/exercises/history', [ExerciseController::class, 'getHistory'])->name('exercises.history');
});


// Congratulations page (public or protected as needed)
Route::get('/congratulations', [ProfileController::class, 'showCongratulations'])->name('congratulations');
