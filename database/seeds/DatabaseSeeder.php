<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('RolesTableSeeder');
        $this->call('LoginTypeTableSeeder');
        $this->call('UsersTableSeeder');
        $this->call('FilesTableSeeder');
        $this->call('CategoriesTableSeeder');
        $this->call('EventsTableSeeder');
    }
}
