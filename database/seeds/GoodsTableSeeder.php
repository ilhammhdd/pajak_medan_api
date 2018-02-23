<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('files')->insert([
            ['id' => 100, 'file_path' => "https://www.organicfacts.net/wp-content/uploads/2013/05/Cabbage11.jpg", "file_name" => "kol"],
            ['id' => 101, 'file_path' => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTs6dnOyLlkdJiIxmsWTytTdIa2WScNjNrq1tT5rM4CjF0R-9uJHg", "file_name" => "bayam"],
            ['id' => 102, 'file_path' => "https://cdn0.woolworths.media/content/wowproductimages/large/144329.jpg", "file_name" => "bawang"],
            ['id' => 103, 'file_path' => "http://manfaatsehat.id/wp-content/uploads/2016/10/Manfaat-wortel.jpg", "file_name" => "wortel"],
            ['id' => 104, 'file_path' => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSs8li_1OA-WxgbEED14O-pebLhi21X7olmTDBpg1N4KpBBrOHOjic882o", "file_name" => "buncis"],
            ['id' => 105, 'file_path' => "https://i2.wp.com/www.obatmaagterbaik.com/wp-content/uploads/2016/07/sayur-kangkung.jpg?resize=351%2C227", "file_name" => "kangkung"],
            ['id' => 106, 'file_path' => "http://kesehatan.blogekstra.com/files/2014/05/labu-siam_f-70085-117220.jpg", "file_name" => "labu_jipang"],
            ['id' => 107, 'file_path' => "https://asset.kompas.com/crop/0x0:1000x667/750x500/data/photo/2017/07/30/727506057.jpg", "file_name" => "brokoli"],
            ['id' => 108, 'file_path' => "https://storage.googleapis.com/stateless-dietsehat-co-id/2017/11/8051584d-daun-pepaya-300x213.jpg", "file_name" => "daun_pepaya"],
            ['id' => 109, 'file_path' => "http://4.bp.blogspot.com/-F7l4KkCXi4Y/T0c0kBdhVcI/AAAAAAAABWU/3cTN4fIyDPc/s400/melinjox.JPG", "file_name" => "melinjo"],
            ['id' => 110, 'file_path' => "https://storage.googleapis.com/manfaat/2015/04/manfaat-jagung-muda.jpg", "file_name" => "jagung"],
            ['id' => 111, 'file_path' => "http://2.bp.blogspot.com/-GFlSyamyzaw/UE_19HagqgI/AAAAAAAAMzw/vZ9irosFZwU/s1600/sayur%2Bterung.jpg", "file_name" => "terung"],
        ]);

        DB::table('goods')->insert([
            ['file_id' => 100, 'category_id' => 1, "name" => "Kol", "price" => 150000, "description" => "Deskripsi Kol", "available" => true, "unit" => "Tungkul kul"],
            ['file_id' => 101, 'category_id' => 2, "name" => "Bayam", "price" => 20000, "description" => "Deskripsi Bayam", "available" => false, "unit" => "Ikat"],
            ['file_id' => 102, 'category_id' => 3, "name" => "Bawang", "price" => 10000, "description" => "Deskripsi Bawang", "available" => true, "unit" => "Ons"],
            ['file_id' => 103, 'category_id' => 4, "name" => "Wortel", "price" => 8000, "description" => "Deskripsi Wortel", "available" => true, "unit" => "Kilo"],
            ['file_id' => 104, 'category_id' => 1, "name" => "Buncis", "price" => 7500, "description" => "Deskripsi Buncis", "available" => false, "unit" => "Kilo"],
            ['file_id' => 105, 'category_id' => 1, "name" => "Kangkung", "price" => 4500, "description" => "Deskripsi Kangkung", "available" => true, "unit" => "Ikat"],
            ['file_id' => 106, 'category_id' => 1, "name" => "Labu Jipang", "price" => 11000, "description" => "Deskripsi Labu Jipang", "available" => false, "unit" => "Kilo"],
            ['file_id' => 107, 'category_id' => 1, "name" => "Brokoli", "price" => 7400, "description" => "Deskripsi Brokoli", "available" => true, "unit" => "Tungkul"],
            ['file_id' => 108, 'category_id' => 1, "name" => "Daun Pepaya", "price" => 9600, "description" => "Deskripsi Daun Pepaya", "available" => false, "unit" => "Ikat"],
            ['file_id' => 109, 'category_id' => 1, "name" => "Melinjo", "price" => 5300, "description" => "Deskripsi Melinjo", "available" => true, "unit" => "Ons"],
            ['file_id' => 110, 'category_id' => 1, "name" => "Jagung", "price" => 13200, "description" => "Deskripsi Jagung", "available" => true, "unit" => "Kilo"],
            ['file_id' => 111, 'category_id' => 1, "name" => "Terung", "price" => 16000, "description" => "Deskripsi Terung", "available" => true, "unit" => "Ons"],
        ]);
    }
}
