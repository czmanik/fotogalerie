<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('slug')->nullable(); // Pro hezké URL na webu
            
            $table->date('birth_date')->nullable();
            $table->date('death_date')->nullable();
            
            $table->text('bio')->nullable(); // Životopis
            
            // Kategorie: uložíme jako pole ["herec", "zpěvák"]
            $table->json('categories')->nullable(); 
            
            // Odkaz na profilovou fotku (z naší galerie)
            $table->foreignId('avatar_photo_id')->nullable()->constrained('photos')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });

        // PIVOT TABULKA (Vazba Fotka <-> Osoba)
        Schema::create('photo_person', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_id')->constrained()->cascadeOnDelete();
            $table->foreignId('person_id')->constrained()->cascadeOnDelete();
            
            // Zabraňuje duplicitám (aby jedna osoba nebyla na fotce 2x)
            $table->unique(['photo_id', 'person_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
