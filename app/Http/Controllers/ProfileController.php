<?php
namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\TrackingNutrition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
    
        $bmr = $this->calculateBMR($gender, $weightInLbs, $heightInInches, $age);
        $activityMultiplier = $this->getActivityMultiplier($profile->activity_level);
        $tdee = $bmr * $activityMultiplier;
    
        $calories = round($tdee);
        $proteinGoal = round(($calories * 0.3) / 4); 
        $carbsGoal = round(($calories * 0.5) / 4);   
        $fatGoal = round(($calories * 0.2) / 9);     
    
        $currentDate = now()->toDateString();
    
        $nutrition = TrackingNutrition::updateOrCreate(
            ['user_id' => $userId, 'date' => $currentDate], 
            [
                'calories_goal' => $calories,
                'protein_goal' => $proteinGoal,
                'carbs_goal' => $carbsGoal,
                'fat_goal' => $fatGoal,
                'calories_consumed' => 0,
                'protein_consumed' => 0,
                'carbs_consumed' => 0,
                'fat_consumed' => 0,
            ]
        );
    
        return response()->json(['message' => 'Nutrition tracking updated', 'data' => $nutrition]);
    }
    
}