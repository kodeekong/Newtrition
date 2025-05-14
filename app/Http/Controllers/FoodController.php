<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    /**
     * Display food entries page
     */
    public function index()
    {
        $foodEntries = FoodEntry::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($entry) {
                // Ensure date is properly formatted
                $entry->date = $entry->date ?? $entry->created_at;
                return $entry;
            });
        
        return view('food.entries', compact('foodEntries'));
    }

    /**
     * Search for food items based on user input.
     */
    public function search(Request $request)
    { 
        try {
            $query = $request->input('name');
            $barcode = $request->input('barcode');
            $dietary = $request->input('dietary', []);
            
            // Nutrition ranges with default values
            $caloriesMin = $request->input('calories_min', 0);
            $caloriesMax = $request->input('calories_max', 2000);
            $proteinMin = $request->input('protein_min', 0);
            $proteinMax = $request->input('protein_max', 200);
            $carbsMin = $request->input('carbs_min', 0);
            $carbsMax = $request->input('carbs_max', 200);
            $fatMin = $request->input('fat_min', 0);
            $fatMax = $request->input('fat_max', 200);

            // Return empty results if no search criteria
            if (empty($query) && empty($barcode) && empty($dietary)) {
                return view('food.search', ['foods' => []]);
            }

            if ($barcode) {
                return $this->getFoodByBarcode($barcode);
            }

            $apiUrl = 'https://world.openfoodfacts.org/cgi/search.pl';
            $params = [
                'json' => true,
                'search_terms' => $query ?? '',
                'page_size' => 8, // Reduced to 8 results per page
                'page' => $request->input('page', 1),
                'sort_by' => 'popularity_key',
                'fields' => 'product_name,image_url,nutriments,quantity',
                'country' => 'united-states',
                'language' => 'en'
            ];

            // Add dietary filters safely
            if (!empty($dietary)) {
                foreach ($dietary as $index => $diet) {
                    if (in_array($diet, ['vegetarian', 'vegan', 'gluten-free', 'halal', 'meat', 'pescetarian'])) {
                        $params["tagtype_$index"] = 'labels';
                        $params["tag_contains_$index"] = 'contains';
                        $params["tag_$index"] = $diet;
                    }
                }
            }

            // Add nutrition filters with validation
            if (is_numeric($caloriesMin)) $params['nutriment_energy_100g_min'] = max(0, $caloriesMin);
            if (is_numeric($caloriesMax)) $params['nutriment_energy_100g_max'] = min(5000, $caloriesMax);
            if (is_numeric($proteinMin)) $params['nutriment_proteins_100g_min'] = max(0, $proteinMin);
            if (is_numeric($proteinMax)) $params['nutriment_proteins_100g_max'] = min(200, $proteinMax);
            if (is_numeric($carbsMin)) $params['nutriment_carbohydrates_100g_min'] = max(0, $carbsMin);
            if (is_numeric($carbsMax)) $params['nutriment_carbohydrates_100g_max'] = min(200, $carbsMax);
            if (is_numeric($fatMin)) $params['nutriment_fat_100g_min'] = max(0, $fatMin);
            if (is_numeric($fatMax)) $params['nutriment_fat_100g_max'] = min(200, $fatMax);

            $response = Http::timeout(10)->get($apiUrl, $params);

            if ($response->successful()) {
                $data = $response->json();
                $foods = $data['products'] ?? [];
                
                // Filter out products with missing essential data
                $foods = array_filter($foods, function($food) {
                    return !empty($food['product_name']) && 
                           isset($food['nutriments']['energy-kcal_100g']) &&
                           isset($food['nutriments']['proteins_100g']) &&
                           isset($food['nutriments']['carbohydrates_100g']) &&
                           isset($food['nutriments']['fat_100g']);
                });

                if ($request->ajax()) {
                    return response()->json([
                        'foods' => $foods,
                        'current_page' => $request->input('page', 1),
                        'last_page' => ceil(($data['count'] ?? 0) / 8)
                    ]);
                }

                return view('food.search', compact('foods'));
            }

            Log::error('Food API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return view('food.search', [
                'foods' => []
            ])->with('error', 'Failed to fetch food data. Please try again.');

        } catch (\Exception $e) {
            Log::error('Food Search Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return view('food.search', [
                'foods' => []
            ])->with('error', 'An error occurred while searching. Please try again.');
        }
    }

    /**
     * Search food by barcode.
     */
    public function getFoodByBarcode($barcode)
    {
        try {
            $apiUrl = 'https://world.openfoodfacts.org/api/v0/product/' . $barcode . '.json';
            $response = Http::get($apiUrl);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['product'])) {
                    return view('food.search', [
                        'foods' => [$data['product']]
                    ]);
                }
            }

            return redirect()->route('food.search')
                ->with('error', 'Product not found for barcode.');

        } catch (\Exception $e) {
            Log::error('Barcode Search Error', [
                'barcode' => $barcode,
                'message' => $e->getMessage()
            ]);

            return redirect()->route('food.search')
                ->with('error', 'Error searching by barcode. Please try again.');
        }
    }

    /**
     * Store a new food entry for the logged-in user.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'food_name' => 'required|string|max:255',
                'calories' => 'required|numeric|min:0',
                'carbs' => 'required|numeric|min:0',
                'fat' => 'required|numeric|min:0',
                'protein' => 'required|numeric|min:0',
                'quantity' => 'required|numeric|min:1',
                'portion_size' => 'nullable|string|max:255',
                'meal_category' => 'required|in:breakfast,lunch,dinner,snack',
                'date' => 'required|date'
            ]);

            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors' => $validator->errors()
                    ], 422);
                }
                return redirect()->route('food.entries')
                    ->withErrors($validator)
                    ->withInput();
            }

            $foodEntry = new FoodEntry();
            $foodEntry->user_id = Auth::id();
            $foodEntry->food_name = $request->food_name;
            $foodEntry->calories = $request->calories * $request->quantity;
            $foodEntry->carbs = $request->carbs * $request->quantity;
            $foodEntry->fat = $request->fat * $request->quantity;
            $foodEntry->protein = $request->protein * $request->quantity;
            $foodEntry->quantity = $request->quantity;
            $foodEntry->portion_size = $request->portion_size;
            $foodEntry->meal_category = $request->meal_category;
            $foodEntry->date = $request->date;
            $foodEntry->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Food entry added successfully!'
                ]);
            }

            return redirect()->route('food.entries')
                ->with('success', 'Food entry added successfully!');

        } catch (\Exception $e) {
            Log::error('Food Entry Store Error', [
                'message' => $e->getMessage(),
                'data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'Error adding food entry: ' . $e->getMessage();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }

            return redirect()->route('food.entries')
                ->with('error', $errorMessage)
                ->withInput();
        }
    }

    /**
     * Remove a food entry.
     */
    public function destroy($id)
    {
        try {
            $entry = FoodEntry::where('user_id', Auth::id())
                ->where('id', $id)
                ->firstOrFail();
                
            $entry->delete();

            return redirect()->back()->with('success', 'Food entry deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Food Entry Delete Error', [
                'id' => $id,
                'message' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Error deleting food entry. Please try again.');
        }
    }

    /**
     * Update a food entry.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'calories' => 'required|numeric|min:0',
                'carbs' => 'required|numeric|min:0',
                'fat' => 'required|numeric|min:0',
                'protein' => 'required|numeric|min:0',
                'quantity' => 'required|numeric|min:1',
                'portion_size' => 'nullable|string|max:255',
                'meal_category' => 'required|in:breakfast,lunch,dinner,snack',
                'date' => 'required|date'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $entry = FoodEntry::where('user_id', Auth::id())
                ->where('id', $id)
                ->firstOrFail();

            $entry->calories = $request->calories;
            $entry->carbs = $request->carbs;
            $entry->fat = $request->fat;
            $entry->protein = $request->protein;
            $entry->quantity = $request->quantity;
            $entry->portion_size = $request->portion_size;
            $entry->meal_category = $request->meal_category;
            $entry->date = $request->date;
            $entry->save();

            return redirect()->back()->with('success', 'Food entry updated successfully!');

        } catch (\Exception $e) {
            Log::error('Food Entry Update Error', [
                'id' => $id,
                'message' => $e->getMessage(),
                'data' => $request->all()

            ]);

            return redirect()->back()
                ->with('error', 'Error updating food entry. Please try again.')
                ->withInput();
        }
    }
}
