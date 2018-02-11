<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['id' => 1, 'file_id' => 1, 'name' => 'Sayur Mayur', 'description' => 'kategori sayur mayur'],
            ['id' => 2, 'file_id' => 2, 'name' => 'Bumbu Masakan', 'description' => 'kategori bumbu masakan'],
            ['id' => 3, 'file_id' => 3, 'name' => 'Lauk Pauk', 'description' => 'kategori lauk pauk'],
            ['id' => 4, 'file_id' => 4, 'name' => 'Sembako', 'description' => 'kategori sembako']
        ]);
    }
}
