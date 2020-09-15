<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;
use DB;
use File;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->delete();
        $json = File::get("database/data/mock_events.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            $datetime = Carbon::parse($obj->date . ' ' . $obj->time);
            Event::create(array(
                'datetime' => $datetime,
                'title' => $obj->title,
                'full_text' => $obj->full_text,
                'type' => $obj->type,
                'lead_image' => $obj->lead_image,
            ));
        }
    }
}
