<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\TrackingNutrition;
use Carbon\Carbon;

class CheckNutritionReset
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $nutrition = TrackingNutrition::where('user_id', auth()->id())
                ->where('date', Carbon::today())
                ->first();

            if (!$nutrition || !$nutrition->last_reset_at || $nutrition->last_reset_at->lt(Carbon::today())) {
                TrackingNutrition::updateOrCreate(
                    [
                        'user_id' => auth()->id(),
                        'date' => Carbon::today(),
                    ],
                    [
                        'calories_consumed' => 0,
                        'carbs_consumed' => 0,
                        'fat_consumed' => 0,
                        'protein_consumed' => 0,
                        'last_reset_at' => Carbon::today(),
                    ]
                );
            }
        }

        return $next($request);
    }
} 