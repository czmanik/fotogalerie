<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photo_slots', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_at'); // Začátek focení
            $table->boolean('is_booked')->default(false); // Je už obsazeno?
            $table->timestamps();
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_slots');
    }
};
