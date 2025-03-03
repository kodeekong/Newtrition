<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FoodController extends Controller
{
    // Show food search form and list all foods
    public function search()
    {
        $foods = Food::paginate(10); // Paginate with 10 results per page
        return view('food.search', compact('foods'));
    }

    // Handle food search functionality
    public function searchFood(Request $request)
    {
        $query = Food::query();
        
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $foods = $query->paginate(10); // Paginate results based on search query
        return view('food.search', compact('foods'));
    }

    // Add food to the user's food entries
    public function addFood(Request $request)
    {
        $request->validate([
            'food_id' => 'required|exists:foods,id',
            'quantity' => 'required|numeric|min:0',
            'portion_size' => 'required|in:small,medium,large',
            'date' => 'required|date',
        ]);

        FoodEntry::create([
            'user_id' => Auth::id(),
            'food_id' => $request->food_id,
            'quantity' => $request->quantity,
            'portion_size' => $request->portion_size,
            'date' => $request->date,
        ]);

        return redirect()->route('food.search')->with('success', 'Food added successfully!');
    }

    // Search food via Open Food Facts API
    public function searchOpenFoodFacts(Request $request)
    {
        $response = Http::get("https://world.openfoodfacts.org/cgi/search.pl", [
            'search_terms' => $request->name,
            'json' => true,
            'page_size' => 10,
        ]);

        $foods = $response->json()['products'] ?? [];
        return view('food.search', compact('foods'));
    }

    // Add food from Open Food Facts to the database
    public function addOpenFoodToDatabase($id)
    {
        $response = Http::get("https://world.openfoodfacts.org/api/v0/product/{$id}.json");
        $data = $response->json();

        $product = $data['product'];

        // Save the food to your database
        $food = Food::create([
            'name' => $product['product_name'] ?? 'Unknown',
            'calories' => $product['nutriments']['energy-kcal'] ?? 0,
            'protein' => $product['nutriments']['proteins'] ?? 0,
            'carbohydrates' => $product['nutriments']['carbohydrates'] ?? 0,
            'fat' => $product['nutriments']['fat'] ?? 0,
            'sodium' => $product['nutriments']['sodium'] ?? 0,
            'fiber' => $product['nutriments']['fiber'] ?? 0,
            'sugar' => $product['nutriments']['sugars'] ?? 0,
            'ingredients' => $product['ingredients_text'] ?? 'No ingredients listed',
            'image_url' => $product['image_url'] ?? null,
        ]);

        return redirect()->route('food.search')->with('success', 'Food added successfully from Open Food Facts!');
    }
}
