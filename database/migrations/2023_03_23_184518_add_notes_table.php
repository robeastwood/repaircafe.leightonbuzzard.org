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
        Schema::create("notes", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId("item_id")->onDelete("cascade");
            $table
                ->foreignId("user_id")
                ->nullable()
                ->onDelete("set null");
            $table->string("status_orig");
            $table->string("status_new");
            $table->text("note");
        });

        // remove orig notes field on item
        Schema::table("items", function (Blueprint $table) {
            $table->dropColumn("notes");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("notes");

        // restore notes field
        Schema::table("items", function (Blueprint $table) {
            $table->text("notes");
        });
    }
};
