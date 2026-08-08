<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->integer('loyalty_points')->default(0)->after('quota');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('points_earned')->default(0)->after('dp_amount');
        });
    }

    
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn('loyalty_points');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('points_earned');
        });
    }
};
