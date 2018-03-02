<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->insert([
            ['id' => 1, 'full_name' => 'administrator', 'phone_number' => '08217781391235', 'email' => 'admin@admin.com', 'address' => 'Jln. jalan di binaria'],
            ['id' => 2, 'full_name' => 'Robert Downey jr.', 'phone_number' => '082177098763', 'email' => 'robert@gmail.com', 'address' => 'Jln. raya bojongsoang']
        ]);
    }
}
