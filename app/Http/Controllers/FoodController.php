<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodEntry;
use App\Models\TrackingNutrition;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FoodController extends Controller
{
    // Show food search form and list all foods
    public function search()
    {
        $user = Auth::user();
        $profile = $user->profile;

        $foodEntries = FoodEntry::where('user_id', $user->id)->get();
        
        return view('food.search', compact('profile', 'foodEntries'));
    }

    // Handle food search functionality
    public function searchFood(Request $request)
    {
        $apiUrl = 'https://world.openfoodfacts.org/cgi/search.pl';
        $query = $request->input('name');
        $category = $request->input('category'); 
        $barcode = $request->input('barcode');

        $filters = [];
        if ($category) {
            $filters['category'] = $category;
        }
        if ($barcode) {
            $filters['barcode'] = $barcode;
        }

        if (empty($query) && empty($filters)) {
            return redirect()->route('food.search')->with('error', 'Please enter a food name or use filters to search.');
        }

        // Make API request to Open Food Facts
        $response = Http::get($apiUrl, array_merge([
            'search_terms' => $query,
            'json' => true,
            'page_size' => 10,
        ], $filters));

        if ($response->successful()) {
            $foods = $response->json()['products'] ?? [];
            return view('food.search', compact('foods'));
        } else {
            return redirect()->route('food.search')->with('error', 'Failed to fetch data from Open Food Facts.');
        }
    }

    // Barcode scanner route
    public function getFoodByBarcode($barcode)
    {
        $apiUrl = 'https://world.openfoodfacts.org/api/v0/product/'.$barcode.'.json';
        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $food = $response->json();
            return view('food.food-detail', compact('food'));
        } else {
            return redirect()->route('food.search')->with('error', 'Product not found by barcode.');
        }
    }

    // Add food to user's profile
    public function addFoodToProfile(Request $request, $foodId)
    {
        $food = Food::findOrFail($foodId);
        
        $foodEntry = new FoodEntry();
        $foodEntry->user_id = Auth::id();
        $foodEntry->food_id = $food->id;
        $foodEntry->quantity = 1;
        $foodEntry->portion_size = 'medium';
        $foodEntry->date = now();
        $foodEntry->save();

        return redirect()->route('food.search')->with('success', 'Food added to your profile.');
    }

    // Remove food from user's profile
    public function removeFoodFromProfile($foodEntryId)
    {
        $foodEntry = FoodEntry::findOrFail($foodEntryId);

        if ($foodEntry->user_id == Auth::id()) {
            $foodEntry->delete();
            return redirect()->route('food.search')->with('success', 'Food removed from your profile.');
        }

        return redirect()->route('food.search')->with('error', 'You can only remove foods from your own profile.');
    }

    // Get suggested foods based on user's profile goal
    public function getSuggestedFoods()
    {
        $goal = Auth::user()->profile->goal;

        $suggestedFoods = [];

        if ($goal == 'gain_weight') {
            $suggestedFoods = [
                ['name' => 'Chicken Breast', 'description' => 'High protein to support muscle growth.'],
                ['name' => 'Pasta', 'description' => 'Carbs to fuel energy for weight gain.'],
                ['name' => 'Avocados', 'description' => 'Healthy fats to add extra calories.'],
            ];
        } elseif ($goal == 'lose_weight') {
            $suggestedFoods = [
                ['name' => 'Grilled Chicken', 'description' => 'Low-fat, high-protein for weight loss.'],
                ['name' => 'Spinach', 'description' => 'Low-calorie vegetable for fiber.'],
                ['name' => 'Olive Oil', 'description' => 'Healthy fats, in moderation.'],
            ];
        } else {
            $suggestedFoods = [
                ['name' => 'Salmon', 'description' => 'High in healthy fats and protein.'],
                ['name' => 'Quinoa', 'description' => 'Complex carbs for balanced energy.'],
                ['name' => 'Sweet Potatoes', 'description' => 'A balanced carb source.'],
            ];
        }

        return response()->json($suggestedFoods);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'food_name' => 'required|string|max:255',
            'calories' => 'required|integer|min:0',
            'carbs' => 'required|integer|min:0',
            'fat' => 'required|integer|min:0',
            'protein' => 'required|integer|min:0',
        ]);
    
        $user = auth()->user();
        $currentDate = now()->toDateString();
    
        // Save the food entry
        $foodEntry = new FoodEntry();
        $foodEntry->user_id = $user->id;
        $foodEntry->food_name = $validated['food_name'];
        $foodEntry->calories = $validated['calories'];
        $foodEntry->carbs = $validated['carbs'];
        $foodEntry->fat = $validated['fat'];
        $foodEntry->protein = $validated['protein'];
        $foodEntry->save();
    
        // Update tracking nutrition
        $tracking = TrackingNutrition::where('user_id', $user->id)
                                      ->where('date', $currentDate)
                                      ->first();
    
        if ($tracking) {
            $tracking->calories_consumed += $validated['calories'];
            $tracking->carbs_consumed += $validated['carbs'];
            $tracking->fat_consumed += $validated['fat'];
            $tracking->protein_consumed += $validated['protein'];
            $tracking->save();
        }
    
        // Check if user reached their goals
        $congratulations = false;
        $message = '';
    
        if ($tracking) {
            if ($tracking->calories_consumed >= $tracking->calories_goal) {
                $congratulations = true;
                $message = 'Congratulations! You reached your calorie goal!';
            }
            if ($tracking->protein_consumed >= $tracking->protein_goal) {
                $congratulations = true;
                $message = 'Congratulations! You reached your protein goal!';
            }
        }
    
        return response()->json([
            'success' => true,
            'calories_consumed' => $tracking->calories_consumed ?? 0,
            'carbs_consumed' => $tracking->carbs_consumed ?? 0,
            'fat_consumed' => $tracking->fat_consumed ?? 0,
            'protein_consumed' => $tracking->protein_consumed ?? 0,
            'congratulations' => $congratulations,
            'message' => $message,
        ]);
    }    

}