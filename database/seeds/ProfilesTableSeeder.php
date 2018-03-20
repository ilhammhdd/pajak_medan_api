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
            ['id' => 1, 'full_name' => 'administrator', 'phone_number' => '08217781391235', 'email' => 'admin@admin.com'],
            ['id' => 2, 'full_name' => 'Robert Downey jr.', 'phone_number' => '082177098763', 'email' => 'robert@gmail.com'],
            ['id' => 3, 'full_name' => 'Khania PKD', 'phone_number' => '082177431234', 'email' => 'khania@gmail.com'],
            ['id' => 4, 'full_name' => 'Aulia Noor', 'phone_number' => '0821774224211', 'email' => 'aulia@gmail.com'],
            ['id' => 5, 'full_name' => 'Nur Cahyadi Perdana', 'phone_number' => '081333222154', 'email' => 'yadi@gmail.com']
        ]);
    }
}
