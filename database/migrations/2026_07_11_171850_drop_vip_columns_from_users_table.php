<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_vip', 'vip_status', 'vip_payment_proof']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_vip')->default(false)->after('is_admin');
            $table->string('vip_status')->default('none')->after('is_vip');
            $table->string('vip_payment_proof')->nullable()->after('vip_status');
        });
    }
};
