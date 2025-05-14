<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the exercises.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $exercises = Exercise::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->paginate(10);
            
        return view('exercises.index', compact('exercises'));
    }

    /**
     * Show the form for creating a new exercise.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('exercises.create');
    }

    /**
     * Store a newly created exercise in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exercise_name' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
            'calories_burned' => 'required|integer|min:1',
            'intensity' => 'required|in:light,moderate,intense',
            'date' => 'required|date',
        ]);

        $exercise = new Exercise($validated);
        $exercise->user_id = Auth::id();
        $exercise->save();

        return redirect()->route('exercises.index')
            ->with('success', 'Exercise recorded successfully!');
    }

    /**
     * Remove the specified exercise from storage.
     *
     * @param  \App\Models\Exercise  $exercise
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Exercise $exercise)
    {
        if ($exercise->user_id !== Auth::id()) {
            abort(403);
        }

        $exercise->delete();

        return redirect()->route('exercises.index')
            ->with('success', 'Exercise deleted successfully!');
    }

    /**
     * Get exercise history for a specific date.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
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