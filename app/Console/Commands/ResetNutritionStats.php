<?php
use App\Models\Nutrition;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ResetNutritionStats extends Command
{
    protected $signature = 'tracking_nutrition:reset';
    protected $description = 'Reset daily nutrition stats for all users';

    public function handle()
    {
        Nutrition::query()->update([
            'calories_consumed' => 0,
            'carbs_consumed' => 0,
            'fat_consumed' => 0,
            'protein_consumed' => 0,
            'calories_goal' => 0,
            'protein_goal' => 0,
            'carbs_goal' => 0,
            'fat_goal' => 0,
            'last_reset_at' => Carbon::today(),
        ]);

        $this->info('Daily nutrition stats reset successfully.');
    }
}
