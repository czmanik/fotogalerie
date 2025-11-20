<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // Viditelnost: public, private, password
            $table->string('visibility')->default('public'); 
            $table->string('password')->nullable(); // Heslo (pokud je visibility=password)
            
            $table->integer('sort_order')->default(0); // Pořadí projektů na webu
            
            // Hlavní fotka projektu (Cover) - odkazuje na tabulku photos
            $table->foreignId('cover_photo_id')->nullable()->constrained('photos')->nullOnDelete();
            
            $table->timestamps();
        });

        // PIVOT TABULKA (Vazba Projekt <-> Fotky)
        Schema::create('project_photo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('photo_id')->constrained()->cascadeOnDelete();
            
            // Pořadí fotky v rámci KONKRÉTNÍHO projektu
            $table->integer('sort_order')->default(0);
            
            // Zabraňuje duplicitám (aby jedna fotka nebyla v projektu 2x)
            $table->unique(['project_id', 'photo_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
