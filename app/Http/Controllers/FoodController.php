<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FoodController extends Controller
{
    /**
     * Display food entries page
     */
    public function index()
    {
        $foodEntries = FoodEntry::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
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
            $goals = $request->input('goals', []);
            
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
            if (empty($query) && empty($barcode) && empty($dietary) && empty($goals)) {
                return view('food.search', ['foods' => []]);
            }

            if ($barcode) {
                return $this->getFoodByBarcode($barcode);
            }

            $apiUrl = 'https://world.openfoodfacts.org/cgi/search.pl';
            $params = [
                'json' => true,
                'search_terms' => $query ?? '',
                'page_size' => 24,
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

            $response = Http::get($apiUrl, $params);

            if ($response->successful()) {
                $foods = $response->json()['products'] ?? [];
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
            $request->validate([
                'food_name' => 'required|string|max:255',
                'calories' => 'required|numeric|min:0',
                'carbs' => 'required|numeric|min:0',
                'fat' => 'required|numeric|min:0',
                'protein' => 'required|numeric|min:0',
                'quantity' => 'required|numeric|min:1'
            ]);

            $foodEntry = new FoodEntry();
            $foodEntry->user_id = Auth::id();
            $foodEntry->food_name = $request->food_name;
            $foodEntry->calories = $request->calories * $request->quantity;
            $foodEntry->carbs = $request->carbs * $request->quantity;
            $foodEntry->fat = $request->fat * $request->quantity;
            $foodEntry->protein = $request->protein * $request->quantity;
            $foodEntry->quantity = $request->quantity;
            $foodEntry->save();

            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }

            return redirect()->back()->with('success', 'Food entry added successfully!');

        } catch (\Exception $e) {
            Log::error('Food Entry Store Error', [
                'message' => $e->getMessage(),
                'data' => $request->all()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error adding food entry. Please try again.'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Error adding food entry. Please try again.')
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
            $request->validate([
                'calories' => 'required|numeric|min:0',
                'carbs' => 'required|numeric|min:0',
                'fat' => 'required|numeric|min:0',
                'protein' => 'required|numeric|min:0',
                'quantity' => 'required|numeric|min:1',
                'date' => 'required|date'
            ]);

            $entry = FoodEntry::where('user_id', Auth::id())
                ->where('id', $id)
                ->firstOrFail();

            $entry->calories = $request->calories;
            $entry->carbs = $request->carbs;
            $entry->fat = $request->fat;
            $entry->protein = $request->protein;
            $entry->quantity = $request->quantity;
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
