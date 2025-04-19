<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntriesTable extends Migration
{
    public function up()
    {
        Schema::create('food_entries', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('food_name');
            $table->float('calories');
            $table->float('carbs');
            $table->float('fat');
            $table->float('protein');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_entries');
    }
}
