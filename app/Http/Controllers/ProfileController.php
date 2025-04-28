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
    
        $nutrition = TrackingNutrition::where('user_id', $user->id)->latest()->first();
    
        return view('user.dashboard', compact('user', 'profile', 'nutrition'));
    }

    public function showForm()
    {
        $userId = Auth::id();
    
        $profile = Profile::where('user_id', $userId)->first();
    
        if ($profile) {
            return redirect()->route('profile'); 
        }
    
        return view('user.personal');
    }

    public function showCongratulations()
    {
        $goalType = session('goal_type'); // Store the goal type in session when checking goals
        $progressPercentage = session('progress_percentage'); // Store progress percentage in session
        return view('user.congratulations', compact('goalType', 'progressPercentage'));
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
    
        $this->calculateDailyCalorieNeeds($userId);
    
        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function showProfile(Request $request)
    {
        $profile = Auth::user()->profile;
        return view('user.profile', compact('profile')); 
    }

    public function calculateDailyCalorieNeeds($userId)
    {
        $profile = Profile::where('user_id', $userId)->first();
    
        if (!$profile) {
            return;
        }
    
        $heightInInches = ($profile->height_ft * 12) + $profile->height_inch;
        $weightInLbs = $profile->weight;
        $age = $profile->age;
        $gender = $profile->gender;
    
        if ($weightInLbs <= 0 || $heightInInches <= 0 || $age <= 0) {
            return;
        }
    
        $bmr = $this->calculateBMR($gender, $weightInLbs, $heightInInches, $age);
        $activityMultiplier = $this->getActivityMultiplier($profile->activity_level);
        $tdee = $bmr * $activityMultiplier;
    
        $calories = round($tdee);
        $proteinGoal = round(($calories * 0.3) / 4); 
        $carbsGoal = round(($calories * 0.5) / 4);   
        $fatGoal = round(($calories * 0.2) / 9);    
    
        $currentDate = now()->toDateString();
    
        TrackingNutrition::updateOrCreate(
            [
                'user_id' => $userId,
                'date' => $currentDate,
            ],
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
    }
    

    private function calculateBMR($gender, $weight, $height, $age)
    {
        $gender = strtolower(trim($gender));

    if ($gender === 'male') {
        return 66 + (6.23 * $weight) + (12.7 * $height) - (6.8 * $age);
    } elseif ($gender === 'female') {
        return 655 + (4.35 * $weight) + (4.7 * $height) - (4.7 * $age);
    } else {
        throw new \Exception("Invalid gender provided.");
        }
    }
    private function getActivityMultiplier($activityLevel){
    switch ($activityLevel) {
        case 'light':
            return 1.375; 
        case 'moderate':
            return 1.55; 
        case 'very_active':
            return 1.725; 
        default:
            throw new \Exception("Invalid activity level provided.");
        }
    }   
}