<?php

use App\Models\Event;
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
        // store checked in items
        $checkedIn = DB::table("event_item")
            ->selectRaw("item_id, event_id")
            ->where("checkedin", "=", 1)
            ->get();

        // make null
        DB::table("event_item")->update(["checkedin" => null]);

        // change table structure
        Schema::table("event_item", function (Blueprint $table) {
            $table
                ->dateTime("checkedin")
                ->nullable()
                ->change();
        });

        // restore checked in items (at event start date)
        foreach ($checkedIn as $checkin) {
            DB::table("event_item")
                ->where("item_id", $checkin->item_id)
                ->where("event_id", $checkin->event_id)
                ->update([
                    "checkedin" => Event::find($checkin->event_id)->starts_at,
                ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // store checked in items
        $checkedIn = DB::table("event_item")
            ->selectRaw("item_id, event_id")
            ->where("checkedin", "<>", null)
            ->get();

        // make null
        DB::table("event_item")->update(["checkedin" => null]);

        Schema::table("event_item", function (Blueprint $table) {
            $table
                ->boolean("checkedin")
                ->nullable()
                ->change();
        });

        // restore checked in items (at event start date)
        foreach ($checkedIn as $checkin) {
            DB::table("event_item")
                ->where("item_id", $checkin->item_id)
                ->where("event_id", $checkin->event_id)
                ->update([
                    "checkedin" => true,
                ]);
        }
    }
};
