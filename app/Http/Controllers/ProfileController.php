<?php


namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{

    public function showDashboard()
    {
        // Get the authenticated user's profile
        $user = Auth::user();
        $profile = $user->profile; // Assuming the user has one profile associated with them

        // Check if the profile exists, if not you can return a message or redirect
        if (!$profile) {
            return redirect()->route('profile')->with('error', 'Please complete your profile before accessing the dashboard.');
        }

        return view('user.dashboard', compact('user', 'profile')); 
    }

    public function showForm(Request $request)
    {
        return view('user.personal'); 
    }

    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'age' => 'required|integer|min:14|max:100',
            'gender' => 'required|in:male,female',
            'weight' => 'required|numeric|min:3|max:1000',
            'height' => 'required|integer|min:0|max:120',
            'activity_level' => 'required|in:light,moderate,very_active',
            'goal' => 'required|in:gain_weight,maintain_weight,lose_weight',  // Add goal validation
        ]);
    
        $userId = Auth::id();
        if (!$userId) {
            return back()->withErrors(['error' => 'You must be logged in to submit your profile.']);
        }
    
        Profile::create([
            'user_id' => $userId,
            'gender' => $validated['gender'],
            'weight' => $validated['weight'],
            'height_inch' => $validated['height'],
            'activity_level' => $validated['activity_level'],
            'age' => $validated['age'],
            'goal' => $validated['goal'], // Add goal to database insert
        ]);
    
        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
    

    

    public function showProfile(Request $request)
    {
        $profile = Auth::user()->profile;
        return view('user.profile', compact('profile')); 
    }

    public function calculateDailyCalorieNeeds($userId)
    {
        $userId = Auth::id();
        $profile = Profile::where('user_id', $userId)->first();

        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

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
