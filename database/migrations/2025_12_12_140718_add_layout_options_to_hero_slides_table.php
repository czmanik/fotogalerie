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
        Schema::table('hero_slides', function (Blueprint $table) {
            $table->string('layout')->default('overlay')->after('button_url'); // overlay, split_left, split_right
            $table->string('content_style')->default('standard')->after('layout'); // standard, boxed
            $table->string('text_alignment')->default('center')->after('content_style'); // left, center, right
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_slides', function (Blueprint $table) {
            $table->dropColumn(['layout', 'content_style', 'text_alignment']);
        });
    }
};
