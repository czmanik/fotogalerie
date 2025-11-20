<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            
            // 1. AUTOR
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 2. VARIANTY
            $table->foreignId('parent_id')->nullable()->constrained('photos')->nullOnDelete();

            // 3. TEXTY (Jednojazyčné)
            // Změněno z JSON na klasické sloupce
            $table->string('title')->nullable();       // Název (krátký text)
            $table->text('description')->nullable();   // Popis (dlouhý text)
            $table->string('slug')->nullable();        // URL adresa

            // 4. STAVY A VIDITELNOST
            $table->boolean('is_visible')->default(false); 
            $table->timestamp('published_at')->nullable();

            // 5. TECHNICKÉ ÚDAJE (EXIF)
            $table->json('exif_data')->nullable(); // Toto zůstává JSON (technická data)
            $table->dateTime('captured_at')->nullable(); 
            
            // Řazení
            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};