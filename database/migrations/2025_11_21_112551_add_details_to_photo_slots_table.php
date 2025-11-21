<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('photo_slots', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id'); // Název (např. Mini focení)
            $table->text('description')->nullable()->after('title'); // Popis
            $table->decimal('price', 10, 2)->nullable()->after('status'); // Cena
        });
    }

    public function down(): void
    {
        Schema::table('photo_slots', function (Blueprint $table) {
            $table->dropColumn(['title', 'description', 'price']);
        });
    }
};
