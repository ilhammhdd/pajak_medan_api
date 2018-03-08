<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('files')->insert([
            ['id' => 890, 'file_path' => 'https://upload.wikimedia.org/wikipedia/en/thumb/2/27/BankNegaraIndonesia46-logo.svg/1200px-BankNegaraIndonesia46-logo.svg.png', 'file_name' => 'logo_bni'],
            ['id' => 891, 'file_path' => 'http://1.bp.blogspot.com/-R8ydKl3BVYI/UNk717mw6lI/AAAAAAAAEWM/gHvtTSsGNW4/w1200-h630-p-k-no-nu/Logo+Bank+CIMB+Niaga.jpg', 'file_name' => 'logo_cimb'],
            ['id' => 892, 'file_path' => 'https://logos-download.com/wp-content/uploads/2016/06/Bank_BRI_logo_Bank_Rakyat_Indonesia.png', 'file_name' => 'logo_bri'],
            ['id' => 893, 'file_path' => 'https://upload.wikimedia.org/wikipedia/en/thumb/f/fa/Bank_Mandiri_logo.svg/1280px-Bank_Mandiri_logo.svg.png', 'file_name' => 'logo_mandiri'],
            ['id' => 894, 'file_path' => 'http://www.pvhc.net/img146/zndhxhozwdfokhpjhkxm.png', 'file_name' => 'cod']
        ]);

        DB::table('payments')->insert([
            ['file_id' => 890, 'name' => 'BNI','detail'=>'03881288592'],
            ['file_id' => 891, 'name' => 'CIMB NIAGA','detail'=>'8772003719'],
            ['file_id' => 892, 'name' => 'BRI','detail'=>'983761930'],
            ['file_id' => 893, 'name' => 'MANDIRI','detail'=>'2221345394'],
            ['file_id' => 894, 'name' => 'COD','detail'=>'655674028345'],
        ]);
    }
}
