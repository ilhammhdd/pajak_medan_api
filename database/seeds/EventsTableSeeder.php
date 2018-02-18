<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            ['file_id' => 5, 'name' => 'Tropic Thunder'],
            ['file_id' => 6, 'name' => 'TED'],
            ['file_id' => 7, 'name' => 'TED2'],
        ]);
    }
}
