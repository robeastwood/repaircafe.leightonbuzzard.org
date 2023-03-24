<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("event_item", function (Blueprint $table) {
            $table->dropColumn("outcome");
            $table->dropColumn("notes");
            $table->boolean("checkedin")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("event_item", function (Blueprint $table) {
            $table->dropColumn("checkedin");
            $table->string("outcome")->nullable();
            $table->text("notes")->nullable();
        });
    }
};
