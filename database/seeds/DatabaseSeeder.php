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
//        $this->call('CheckoutUniquesTableSeeder');
        $this->call('StatusTableSeeder');
        $this->call('RolesTableSeeder');
        $this->call('LoginTypeTableSeeder');
        $this->call('UsersTableSeeder');
        $this->call('FilesTableSeeder');
        $this->call('CategoriesTableSeeder');
        $this->call('EventsTableSeeder');
        $this->call('GoodsTableSeeder');
        $this->call('ProfilesTableSeeder');
        $this->call('CustomersTableSeeder');
        $this->call('BasketsTableSeeder');
        $this->call('BasketsGoodsTableSeeder');
        $this->call('PaymentTableSeeder');
        $this->call('AddressesTableSeeder');
        $this->call('ReceiversTableSeeder');
    }
}
