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
        Schema::table("event_user", function (Blueprint $table) {
            $table->dropForeign("event_user_user_id_foreign");
            $table
                ->foreign("user_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade");
        });

        Schema::table("skill_user", function (Blueprint $table) {
            $table->dropForeign("skill_user_skill_id_foreign");
            $table
                ->foreign("skill_id")
                ->references("id")
                ->on("skills")
                ->onDelete("cascade");

            $table->dropForeign("skill_user_user_id_foreign");
            $table
                ->foreign("user_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade");
        });

        Schema::table("event_item", function (Blueprint $table) {
            $table->dropForeign("event_item_repairer_id_foreign");
            $table
                ->foreign("repairer_id")
                ->references("id")
                ->on("users")
                ->onDelete("set null");
        });

        Schema::table("items", function (Blueprint $table) {
            $table->SoftDeletes();
            $table->dropForeign("items_user_id_foreign");
            $table
                ->foreign("user_id")
                ->references("id")
                ->on("users")
                ->onDelete("set null");
        });

        Schema::table("events", function (Blueprint $table) {
            $table->SoftDeletes();
        });

        Schema::table("venues", function (Blueprint $table) {
            $table->SoftDeletes();
        });

        Schema::table("categories", function (Blueprint $table) {
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("event_user", function (Blueprint $table) {
            $table->dropForeign("event_user_user_id_foreign");
            $table
                ->foreign("user_id")
                ->references("id")
                ->on("users")
                ->constrained();
        });

        Schema::table("skill_user", function (Blueprint $table) {
            $table->dropForeign("skill_user_skill_id_foreign");
            $table
                ->foreign("skill_id")
                ->references("id")
                ->on("skills")
                ->constrained();

            $table->dropForeign("skill_user_user_id_foreign");
            $table
                ->foreign("user_id")
                ->references("id")
                ->on("users")
                ->constrained();
        });

        Schema::table("items", function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropForeign("items_user_id_foreign");
            $table
                ->foreign("user_id")
                ->references("id")
                ->on("users")
                ->constrained();
        });

        Schema::table("event_item", function (Blueprint $table) {
            $table->dropForeign("event_item_repairer_id_foreign");
            $table
                ->foreign("repairer_id")
                ->references("id")
                ->on("users")
                ->constrained();
        });

        Schema::table("events", function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table("venues", function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table("categories", function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
