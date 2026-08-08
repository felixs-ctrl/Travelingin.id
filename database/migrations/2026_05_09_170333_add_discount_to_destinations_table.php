<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->decimal('discount_price', 15, 2)->nullable();
            $table->boolean('is_special_offer')->default(false);
        });
    }

    
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['discount_price', 'is_special_offer']);
        });
    }
};
