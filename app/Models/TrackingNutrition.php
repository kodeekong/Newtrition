<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingNutrition extends Model
{
    use HasFactory;

    protected $table = 'tracking_nutrition';

    protected $fillable = [
        'user_id', 
        'date', 
        'calories_consumed', 
        'protein_consumed', 
        'carbs_consumed', 
        'fat_consumed',
        'calories_goal',
        'protein_goal', 
        'carbs_goal', 
        'fat_goal'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'user_id', 'id');
    }
}
