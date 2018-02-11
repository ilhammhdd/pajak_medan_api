<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('files')->insert([
            ['file_path' => storage_path("app\\images\\"), 'file_name' => 'sayuran.jpg'],
            ['file_path' => storage_path("app\\images\\"), 'file_name' => 'bumbu_masakan.jpg'],
            ['file_path' => storage_path("app\\images\\"), 'file_name' => 'lauk_pauk.jpg'],
            ['file_path' => storage_path("app\\images\\"), 'file_name' => 'sembako.jpg']
        ]);
    }
}
