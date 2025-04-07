<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\FoodEntry;

class FoodController extends Controller
{
    // Show food search form and list all foods (optional)
    public function search()
    {
        return view('food.search');
    }

    // Handle food search functionality
    public function searchFood(Request $request)
    {
        // Define Open Food Facts API URL
        $apiUrl = 'https://world.openfoodfacts.org/cgi/search.pl';
        
        // Make sure the name parameter is present in the request
        $query = $request->input('name');

        // If no query is provided, redirect back with an error message
        if (empty($query)) {
            return redirect()->route('food.search')->with('error', 'Please enter a food name to search.');
        }

        // Make API request to Open Food Facts
        $response = Http::get($apiUrl, [
            'search_terms' => $query,
            'json' => true,
            'page_size' => 10, // Limit the number of results
        ]);

        // Check if the response was successful
        if ($response->successful()) {
            $foods = $response->json()['products'] ?? [];

            // Pass the data to the view
            return view('food.search', compact('foods'));
        } else {
            // Handle API failure (in case the request fails)
            return redirect()->route('food.search')->with('error', 'Failed to fetch data from Open Food Facts.');
        }
    }

    
    public function getProductByBarcode($barcode)
    {
        // API request to Open Food Facts using the barcode
        $response = Http::get("https://world.openfoodfacts.org/api/v0/product/{$barcode}.json");

        if ($response->successful()) {
            $product = $response->json()['product'];

            // You can return the product data as JSON to the frontend
            return response()->json($product);
        } else {
            return response()->json(['error' => 'Product not found.'], 404);
        }
    }


    public function getSuggestedFoods()
    {
        // This could be based on user preferences, random selection, or any algorithm.
        // For demonstration, we're returning mock data.
        $suggestedFoods = [
            ['name' => 'Smoothie A', 'description' => 'A healthy smoothie with spinach and banana.'],
            ['name' => 'Protein Bar', 'description' => 'High-protein bar with peanut butter.'],
            ['name' => 'Green Juice', 'description' => 'A detoxifying juice made with kale and apple.'],
        ];

        return response()->json($suggestedFoods);
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'food_name' => 'required|string|max:255',
            'calories' => 'required|numeric',
            'carbs' => 'required|numeric',
            'fat' => 'required|numeric',
            'protein' => 'required|numeric',
            'quantity' => 'required|numeric',
            'date' => 'required|date',
        ]);

        // Insert into the database
        $foodEntry = new FoodEntry();
        $foodEntry->user_id = auth()->id(); // Get the authenticated user's ID
        $foodEntry->food_name = $request->food_name;
        $foodEntry->calories = $request->calories;
        $foodEntry->carbs = $request->carbs;
        $foodEntry->fat = $request->fat;
        $foodEntry->protein = $request->protein;
        $foodEntry->quantity = $request->quantity;
        $foodEntry->date = $request->date;
        $foodEntry->save();

        return response()->json(['success' => 'Food entry added successfully.']);
    }
}
