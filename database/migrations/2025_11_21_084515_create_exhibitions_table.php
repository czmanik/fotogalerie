<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exhibitions', function (Blueprint $table) {
            $table->id();
            $table->string('title');       // Název výstavy
            $table->string('location');    // Místo konání (Galerie Mánes...)
            $table->text('description')->nullable();
            
            $table->date('start_date');    // Od
            $table->date('end_date')->nullable(); // Do (nullable, pokud je to stálá expozice)
            
            $table->boolean('is_visible')->default(true);
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exhibitions');
    }
};
