<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('addresses')->insert([
            ['customer_id' => 2, 'name' => 'Jln. Sukapura no.1 C223 Bandung', 'main' => true],
            ['customer_id' => 1, 'name' => 'Jln. Sukapura Gedung Karang no.1 C201 Bandung', 'main' => true],
            ['customer_id' => 1, 'name' => 'Jln. Mengger Hilir no.889 Bandung', 'main' => false],
            ['customer_id' => 1, 'name' => 'Jln. Sukabirus Gedung Tokong NanasBandung', 'main' => false],
        ]);
    }
}
