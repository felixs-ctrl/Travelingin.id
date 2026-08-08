<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->json('whats_included')->nullable()->after('description');
            $table->json('gallery')->nullable()->after('image');
        });
    }

    
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['whats_included', 'gallery']);
        });
    }
};
