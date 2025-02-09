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
        Schema::table("users", function (Blueprint $table) {
            $table
                ->boolean("fixer")
                ->after("volunteer")
                ->nullable();
        });
        Schema::table("event_user", function (Blueprint $table) {
            $table
                ->boolean("fixer")
                ->after("volunteer")
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("users", function (Blueprint $table) {
            $table->dropColumn("fixer");
        });
        Schema::table("event_user", function (Blueprint $table) {
            $table
                ->dropColumn("fixer");
        });
    }
};
