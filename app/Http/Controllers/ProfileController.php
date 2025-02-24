<?php


namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    // Show the form to fill in profile information
    public function showProfileForm()
    {
        return view('profile.form'); // Blade view for the profile form
    }

    // Handle the profile form submission
    public function submitProfile(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'gender' => 'required|string',
            'weight' => 'required|numeric|min:20|max:300',
            'height' => 'required|numeric|min:12|max:250',
            'activity' => 'required|string',
            'age' => 'required|integer',
        ]);

        // Assuming the user is authenticated, get the authenticated user's ID
        $userId = Auth::id();

        // Save the profile information
        Profile::create([
            'user_id' => $userId, // Attach the current authenticated user's ID
            'gender' => $validated['gender'],
            'weight' => $validated['weight'],
            'height_inch' => $validated['height'], // Get the remaining inches
            'activity_level' => $validated['activity'],
            'age' => $request->age,  
        ]);

        // Redirect the user to a confirmation page or another view
        return redirect()->route('profile.complete');
    }

    // Show profile completion page
    public function showProfileCompletion()
    {
        return view('profile.complete');
    }

    // Calculate daily calorie needs based on the user's profile
    public function calculateDailyCalorieNeeds($userId)
    {
        $userId = Auth::id();
        $profile = Profile::where('user_id', $userId)->first();

        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        // Directly use the feet/inches and pounds (no conversion to cm or kg)
        $heightInInches = ($profile->height_ft * 12) + $profile->height_inch;
        $weightInLbs = $profile->weight;
        $age = $profile->age;
        $gender = $profile->gender;

        if ($weightInLbs <= 0 || $heightInInches <= 0 || $age <= 0) {
            return response()->json(['error' => 'Invalid profile data'], 400);
        }

        // Calculate BMR using the Harris-Benedict equation
        $bmr = $this->calculateBMR($gender, $weightInLbs, $heightInInches, $age);
        $activityMultiplier = $this->getActivityMultiplier($profile->activity_level);
        $tdee = $bmr * $activityMultiplier;

        return response()->json(['tdee' => $tdee]);
    }

    // Helper method to calculate BMR (No need to convert weight or height)
    private function calculateBMR($gender, $weightInLbs, $heightInInches, $age)
    {
        // Harris-Benedict equation
        if ($gender == 'male') {
            return 66 + (6.23 * $weightInLbs) + (12.7 * $heightInInches) - (6.8 * $age);
        } else {
            return 655 + (4.35 * $weightInLbs) + (4.7 * $heightInInches) - (4.7 * $age);
        }
    }

    // Helper method to get the activity multiplier based on activity level
    private function getActivityMultiplier($activityLevel)
    {
        $activityMultipliers = [
            'very_active' => 1.9,
            'moderately_active' => 1.55,
            'lightly_active' => 1.375,
            'sedentary' => 1.2,
        ];

        return $activityMultipliers[$activityLevel] ?? 1.2; // Default to sedentary if no match
    }
}