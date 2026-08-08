<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('vip_status')->default('none')->after('is_vip');
            $table->string('vip_payment_proof')->nullable()->after('vip_status');
        });
    }

    
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['vip_status', 'vip_payment_proof']);
        });
    }
};
