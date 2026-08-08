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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('pelunasan_proof')->nullable()->after('payment_proof');
        });

        Schema::table('destinations', function (Blueprint $table) {
            $table->string('whatsapp_link')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('pelunasan_proof');
        });

        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn('whatsapp_link');
        });
    }
};
