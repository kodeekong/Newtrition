<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('food_entries', function (Blueprint $table) {
            if (!Schema::hasColumn('food_entries', 'food_name')) {
                $table->string('food_name')->after('user_id');
            }
            if (!Schema::hasColumn('food_entries', 'quantity')) {
                $table->integer('quantity')->default(1)->after('protein');
            }
        });
    }

    public function down()
    {
        Schema::table('food_entries', function (Blueprint $table) {
            $table->dropColumn(['food_name', 'quantity']);
        });
    }
};