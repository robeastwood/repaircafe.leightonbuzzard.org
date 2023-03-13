<?php

use App\Models\Item;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("categories", function (Blueprint $table) {
            $table->text("powered")->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement(
            "ALTER TABLE `categories` MODIFY COLUMN `powered` ENUM('" .
                implode("','", Item::powerOptions()) .
                "') DEFAULT 'unknown'"
        );
    }
};
