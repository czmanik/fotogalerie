<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            
            // Kdo píše
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            
            // Typ zprávy (objednavka, dotaz, spoluprace...)
            $table->string('type')->default('general'); 
            
            // Text zprávy
            $table->text('body')->nullable();
            
            // Pokud je to objednávka, váže se na termín
            $table->foreignId('photo_slot_id')->nullable()->constrained()->nullOnDelete();
            
            // Odpověď Martina (abychom viděli historii)
            $table->text('admin_note')->nullable(); // Poznámka pro Martina
            $table->text('reply_text')->nullable(); // Co Martin odepsal
            $table->timestamp('replied_at')->nullable(); // Kdy odepsal
            
            $table->boolean('is_read')->default(false); // Přečteno?

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
