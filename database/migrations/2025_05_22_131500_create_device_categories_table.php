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
        Schema::create('device_categories', function ($table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('label');
            $table->timestamps();
        });

        Schema::table('devices', function ($table) {
            $table->foreignId('device_category_id')->nullable()->constrained()->nullOnDelete();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_categories');
        Schema::table('devices', function (Blueprint $table) {
            $table->dropForeign(['device_category_id']);
            $table->dropColumn('device_category_id');
        });
    }
};
