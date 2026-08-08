<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->string('type')->default('paket'); 
            $table->string('package_type')->default('general'); 
            $table->integer('quota')->default(0); 
        });
    }

    
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['type', 'package_type', 'quota']);
        });
    }
};
