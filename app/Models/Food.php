<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\TextUI\Configuration\Php;

class Food extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'calories',
        'protein',
        'carbohydrates',
        'fat',
        'sodium',
        'fiber',
        'sugar',
        'ingredients',
        'image_url',
    ];

    // Relationship to FoodEntry
    public function foodEntries()
    {
        return $this->hasMany(FoodEntry::class);
    }
}
