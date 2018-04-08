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
            ['customer_id' => 1, 'total' => 35000, 'total_items' => 4, 'description' => 'ini deskripsi untuk basket user id 1', 'status_id' => 6],
            ['customer_id' => 1, 'total' => 76000, 'total_items' => 3, 'description' => 'ini deskripsi untuk basket user id 1', 'status_id' => 5],
            ['customer_id' => 2, 'total' => 100000, 'total_items' => 6, 'description' => 'ini deskripsi untuk basket user id 2', 'status_id' => 6],
            ['customer_id' => 2, 'total' => 28765, 'total_items' => 10, 'description' => 'ini deskripsi untuk basket user id 2', 'status_id' => 5]
        ]);
    }
}
