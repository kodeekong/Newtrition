<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',  
        'age',
        'gender',
        'weight',
        'height_inch',
        'activity_level',
        'goal',
    ];

    public function trackingNutrition()
    {
        return $this->hasMany(TrackingNutrition::class, 'user_id', 'id'); 
    }

    public function user()
    {
        return $this->belongsTo(User::class); 
    }
}