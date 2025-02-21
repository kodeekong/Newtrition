<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showProfileForm()
    {
        $profile = Auth::user()->profile;

        return view('user.profile', compact('profile'));
    }

    public function updateProfile(Request $request)
{
    $request->validate([
        'age' => 'required|integer|min:14|max:100',
        'gender' => 'required|in:male,female,other',
        'weight' => 'required|numeric|min:3|max:1000',
        'height_ft' => 'required|integer|min:0|max:10',
        'height_inch' => 'required|integer|min:0|max:11',
        'activity_level' => 'required|in:light,moderate,very_active',
    ]);

    $profile = Auth::user()->profile;

    $profile->update([
        'age' => $request->age,
        'gender' => $request->gender,
        'weight' => $request->weight,
        'height_ft' => $request->height_ft,
        'height_inch' => $request->height_inch,
        'activity_level' => $request->activity_level,
    ]);

    return redirect()->route('profile')->with('success', 'Profile updated successfully!');
}

}
