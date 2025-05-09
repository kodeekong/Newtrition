<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExerciseController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exercise_name' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
            'intensity' => 'required|in:light,moderate,intense',
        ]);

        $user = auth()->user();
        $caloriesBurned = Exercise::calculateCaloriesBurned(
            $validated['exercise_name'],
            $validated['duration_minutes'],
            $user->profile->weight,
            $validated['intensity']
        );

        $exercise = Exercise::create([
            'user_id' => $user->id,
            'exercise_name' => $validated['exercise_name'],
            'duration_minutes' => $validated['duration_minutes'],
            'calories_burned' => $caloriesBurned,
            'intensity' => $validated['intensity'],
            'date' => Carbon::today(),
        ]);

        return response()->json([
            'success' => true,
            'exercise' => $exercise,
            'calories_burned' => $caloriesBurned
        ]);
    }

    public function getHistory(Request $request)
    {
        $user = auth()->user();
        $date = $request->input('date', Carbon::today());
        
        $exercises = Exercise::where('user_id', $user->id)
            ->where('date', $date)
            ->get();

        $totalCaloriesBurned = $exercises->sum('calories_burned');
        $totalDuration = $exercises->sum('duration_minutes');

        return response()->json([
            'exercises' => $exercises,
            'total_calories_burned' => $totalCaloriesBurned,
            'total_duration' => $totalDuration
        ]);
    }
} 