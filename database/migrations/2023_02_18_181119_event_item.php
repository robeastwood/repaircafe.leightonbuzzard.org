<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_item', function (Blueprint $table) {
            $table->foreignId('event_id')->constrained();
            $table->foreignId('item_id')->constrained();
            $table->foreignId('repairer_id')->nullable()->constrained('users');
            $table->string('outcome')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_item');
    }
};
