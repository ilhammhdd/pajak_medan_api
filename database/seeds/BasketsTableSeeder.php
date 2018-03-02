<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BasketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('baskets')->insert([
            ['customer_id' => 1, 'total' => 35000, 'description' => 'ini deskripsi untuk basket user id 1', 'status' => false],
            ['customer_id' => 1, 'total' => 76000, 'description' => 'ini deskripsi untuk basket user id 1', 'status' => true],
            ['customer_id' => 2, 'total' => 100000, 'description' => 'ini deskripsi untuk basket user id 2', 'status' => false],
            ['customer_id' => 2, 'total' => 28765, 'description' => 'ini deskripsi untuk basket user id 2', 'status' => true]
        ]);
    }
}
