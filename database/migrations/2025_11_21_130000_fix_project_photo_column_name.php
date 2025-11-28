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
        // Fix for inconsistent column name in database vs code
        if (Schema::hasColumn('project_photo', 'display_order') && !Schema::hasColumn('project_photo', 'sort_order')) {
            Schema::table('project_photo', function (Blueprint $table) {
                $table->renameColumn('display_order', 'sort_order');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('project_photo', 'sort_order') && !Schema::hasColumn('project_photo', 'display_order')) {
            Schema::table('project_photo', function (Blueprint $table) {
                $table->renameColumn('sort_order', 'display_order');
            });
        }
    }
};
