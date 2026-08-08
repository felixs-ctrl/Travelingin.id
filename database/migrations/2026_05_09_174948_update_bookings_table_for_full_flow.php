<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('email')->nullable()->after('no_hp');
            $table->decimal('total_price', 15, 2)->nullable()->after('jumlah_orang');
            $table->decimal('dp_amount', 15, 2)->nullable()->after('total_price');
            $table->string('payment_proof')->nullable()->after('status');
            $table->string('status')->default('pending')->change(); 
        });
    }

    
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['email', 'total_price', 'dp_amount', 'payment_proof']);
        });
    }
};
