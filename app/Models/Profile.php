<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',  // foreign key that links to the users table
        'age',
        'gender',
        'weight',
        'height_inch',
        'activity_level',
    ];


    public function user()
    {
        return $this->belongsTo(User::class); 
    }

}
