<?php
namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TrackingNutrition;

class ProfileController extends Controller
{

    public function showDashboard()
    {
        $user = Auth::user();
        $profile = $user->profile; 

        if (!$profile) {
            return redirect()->route('profile')->with('error', 'Please complete your profile before accessing the dashboard.');
        }

        return view('user.dashboard', compact('user', 'profile')); 
    }

    public function showForm()
    {
        // Get the logged-in user's ID
        $userId = Auth::id();
    
        // Check if the user already has a profile
        $profile = Profile::where('user_id', $userId)->first();
    
        // If the user already has a profile, redirect them to the profile page
        if ($profile) {
            return redirect()->route('user.profile'); // Redirect to the profile page
        }
    
        // If the user does not have a profile, show the personal form to complete their profile
        return view('user.personal'); // Redirect to the personal page to complete the profile
    }
    
    

    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'age' => 'required|integer|min:14|max:100',
            'gender' => 'required|in:male,female',
            'weight' => 'required|numeric|min:3|max:1000',
            'height' => 'required|integer|min:0|max:120',
            'activity_level' => 'required|in:light,moderate,very_active',
            'goal' => 'required|in:gain_weight,maintain_weight,lose_weight', 
        ]);
    
        $userId = Auth::id();
        if (!$userId) {
            return back()->withErrors(['error' => 'You must be logged in to submit your profile.']);
        }
    
        $profile = Profile::updateOrCreate(
            ['user_id' => $userId], 
            [
            'gender' => $validated['gender'],
            'weight' => $validated['weight'],
            'height_inch' => $validated['height'],
            'activity_level' => $validated['activity_level'],
            'age' => $validated['age'],
            'goal' => $validated['goal'],
            ]
        );

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
        }

    public function showProfile(Request $request)
    {
        $profile = Auth::user()->profile;
        return view('user.profile', compact('profile')); 

        if (!$profile) {
         return redirect()->route('personal')->withErrors(['error' => 'Please complete your profile first.']);
    }

    return view('user.profile', compact('profile'));
    }
    
    public function createNutritionTracking()
    {
        $userId = Auth::id(); // Get the current logged-in user's ID
        $profile = Profile::where('user_id', $userId)->first(); // Get the user's profile
    
        dd($profile);
        // Check if profile exists
        if (!$profile) {
            return redirect()->route('personal'); // Handle case where profile doesn't exist
        }
    
        // Extract profile data
        $age = $profile->age;
        $height_cm = $profile->height_inch * 2.54; // Convert inches to cm
        $weight_kg = $profile->weight * 0.453592; // Convert pounds to kg
        $gender = $profile->gender;
        $activity_level = $profile->activity_level;
    
        // Calculate BMR and TDEE
        $bmr = $this->calculateBMR($age, $height_cm, $weight_kg, $gender);
        $tdee = $this->calculateTDEE($bmr, $activity_level);
    
        // Set nutritional goals based on TDEE
        $calories_goal = $tdee; // Default to TDEE for maintenance
        $protein_goal = $weight_kg * 1.6; // Example: 1.6g of protein per kg of body weight
        $carbs_goal = $tdee * 0.45 / 4; // Assuming 45% of calories from carbs (4 calories per gram)
        $fat_goal = $tdee * 0.3 / 9; // Assuming 30% of calories from fats (9 calories per gram)
    
        // Create a new tracking record in the tracking_nutrition table
        TrackingNutrition::create([
            'user_id' => $userId,
            'date' => now(), // Current date
            'calories_consumed' => 0, // Default to 0, will update later
            'protein_consumed' => 0, // Default to 0, will update later
            'carbs_consumed' => 0, // Default to 0, will update later
            'fat_consumed' => 0, // Default to 0, will update later
            'calories_goal' => $calories_goal,
            'protein_goal' => $protein_goal,
            'carbs_goal' => $carbs_goal,
            'fat_goal' => $fat_goal,
        ]);
    
        // Redirect to the profile page after tracking creation
        return redirect()->route('profile');
    }
    
    public function calculateBMR($age, $height_cm, $weight_kg, $gender)
    {
        // Calculate BMR based on gender and other inputs
        if ($gender === 'male') {
            return 66.5 + (13.75 * $weight_kg) + (5.003 * $height_cm) - (6.755 * $age);
        } elseif ($gender === 'female') {
            return 655.1 + (9.563 * $weight_kg) + (1.850 * $height_cm) - (4.676 * $age);
        }
        return null; // Invalid gender
    }
    
    public function calculateTDEE($bmr, $activity_level)
    {
        // Set default activity multiplier
        $activity_multiplier = 1.2; // Sedentary (if activity level is not set correctly)
    
        // Adjust activity multiplier based on user activity level
        switch ($activity_level) {
            case 'light':
                $activity_multiplier = 1.375;
                break;
            case 'moderate':
                $activity_multiplier = 1.55;
                break;
            case 'very_active':
                $activity_multiplier = 1.725;
                break;
            // Add other activity levels if needed
        }
    
        // Return TDEE (Total Daily Energy Expenditure)
        return $bmr * $activity_multiplier;
    }
}    