<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('photo_slots', function (Blueprint $table) {
            $table->dropColumn('is_booked'); // Smažeme starý sloupec
            // Přidáme nový: free (volno), pending (předobjednáno), confirmed (zarezervováno)
            $table->string('status')->default('free')->after('start_at');
        });
    }

    public function down(): void
    {
        Schema::table('photo_slots', function (Blueprint $table) {
            $table->boolean('is_booked')->default(false);
            $table->dropColumn('status');
        });
    }
};
