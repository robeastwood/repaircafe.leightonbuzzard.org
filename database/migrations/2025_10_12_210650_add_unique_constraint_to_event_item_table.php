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
        Schema::table('event_item', function (Blueprint $table) {
            $table->unique(['event_id', 'item_id'], 'event_item_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot safely drop the unique constraint due to foreign key dependencies
        // Dropping this constraint would allow duplicate data which could cause issues
        // If rollback is truly needed, manually drop and recreate the foreign keys first
    }
};
