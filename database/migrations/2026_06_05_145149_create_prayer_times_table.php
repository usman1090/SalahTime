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
    Schema::create('prayer_times', function (Blueprint $table) {
        $table->id();

        $table->string('city');
        $table->string('country');
        $table->date('prayer_date');

        $table->time('fajr');
        $table->time('dhuhr');
        $table->time('asr');
        $table->time('maghrib');
        $table->time('isha');

        $table->timestamps();

        $table->unique(['city', 'country', 'prayer_date']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prayer_times');
    }
};
