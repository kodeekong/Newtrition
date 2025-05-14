<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exercise_name',
        'duration_minutes',
        'calories_burned',
        'intensity',
        'date'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Calculate calories burned based on exercise type and duration
    public static function calculateCaloriesBurned($exerciseName, $durationMinutes, $userWeight, $intensity = 'moderate')
    {
        // Basic MET (Metabolic Equivalent of Task) values for common exercises
        $metValues = [
            'walking' => ['light' => 2.5, 'moderate' => 3.5, 'intense' => 4.5],
            'running' => ['light' => 6.0, 'moderate' => 8.0, 'intense' => 10.0],
            'cycling' => ['light' => 4.0, 'moderate' => 6.0, 'intense' => 8.0],
            'swimming' => ['light' => 5.0, 'moderate' => 7.0, 'intense' => 9.0],
            'weightlifting' => ['light' => 3.0, 'moderate' => 5.0, 'intense' => 7.0],
        ];

        // Default to moderate intensity if exercise not found
        $met = $metValues[strtolower($exerciseName)]['moderate'] ?? 5.0;
        
        // Calculate calories burned using the formula: Calories = MET * weight in kg * duration in hours
        $weightInKg = $userWeight * 0.453592; // Convert pounds to kg
        $durationInHours = $durationMinutes / 60;
        
        return round($met * $weightInKg * $durationInHours);
    }
} 