<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
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
        ]);

        $userId = Auth::id();

        // Save the profile information
        Profile::create([
            'user_id' => $userId,
            'gender' => $validated['gender'],
            'weight' => $validated['weight'],
            'height_inch' => $validated['height'], 
            'activity_level' => $validated['activity_level'],
            'age' => $validated['age'],  
        ]);

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function showProfile(Request $request)
    {
        $profile = Auth::user()->profile;
        return view('user.profile', compact('profile')); 
    }
}
