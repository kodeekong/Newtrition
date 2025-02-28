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
            $table->integer('height_inch'); 
            $table->enum('activity_level', ['light', 'moderate', 'very_active']);
            $table->enum('goal', ['gain_weight', 'maintain_weight', 'lose_weight'])
                ->change();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
