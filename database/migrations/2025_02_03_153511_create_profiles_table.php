<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('age');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->float('weight');
            $table->integer('height_ft');  // Feet (0-9 ft)
            $table->integer('height_inch'); // Inches (0-11 in)
            $table->enum('activity_level', ['sedentary', 'light', 'moderate', 'active', 'very_active']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
