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
    Schema::create('prayer_records', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

        $table->enum('prayer_name', [
            'fajr',
            'dhuhr',
            'asr',
            'maghrib',
            'isha'
        ]);

        $table->date('prayer_date');
        $table->dateTime('prayer_time')->nullable();

        $table->enum('status', [
            'on_time',
            'late',
            'qaza',
            'missed'
        ]);

        $table->string('image_path')->nullable();
        $table->timestamps();

        $table->unique(['user_id', 'prayer_name', 'prayer_date']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prayer_records');
    }
};
