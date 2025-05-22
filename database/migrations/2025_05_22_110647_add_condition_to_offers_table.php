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
        Schema::table('offers', function ($table) {
            $table->string('condition')->after('device_id');
            // Add composite unique index
            $table->unique(['vendor_id', 'device_id', 'condition', 'network'], 'unique_offer_per_variant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('condition');
            // Drop the composite unique index
            $table->dropUnique('unique_offer_per_variant');
        });
    }
};
