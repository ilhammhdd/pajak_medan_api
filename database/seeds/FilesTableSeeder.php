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
            ['file_path' => "http://digitalspyuk.cdnds.net/13/38/768x1033/gallery_showbiz-arnold-schwarzenegger-1.jpg", 'file_name' => 'sayuran.jpg'],
            ['file_path' => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQkBZoq-bfEgzseFVam5oAtCtijiELdhpisItb_G5aumQAspVijZQ", 'file_name' => 'bumbu_masakan.jpg'],
            ['file_path' => "http://www2.pictures.zimbio.com/gi/Chuck+Norris+Premiere+Lionsgate+Films+Expendables+aQHZUbxpjS6l.jpg", 'file_name' => 'lauk_pauk.jpg'],
            ['file_path' => "http://highlighthollywood.com/wp-content/uploads/2015/05/Sam-L-Jackson.jpg", 'file_name' => 'sembako.jpg'],
            ['file_path' => 'http://is1.mzstatic.com/image/thumb/Video1/v4/5d/4d/37/5d4d371b-5136-4123-deee-d720241d93ec/source/1200x630bb.jpg', 'file_name' => 'tropic_thunder.jpg'],
            ['file_path' => 'https://images-na.ssl-images-amazon.com/images/M/MV5BMTQ1OTU0ODcxMV5BMl5BanBnXkFtZTcwOTMxNTUwOA@@._V1_SY1000_CR0,0,631,1000_AL_.jpg', 'file_name' => 'TED.jpg'],
            ['file_path' => 'https://vignette.wikia.nocookie.net/doblaje/images/1/1a/Ted_2_Official_Poster_Final_JPosters.jpg/revision/latest?cb=20150524195355&path-prefix=es', 'file_name' => 'TED2.jpg'],
        ]);
    }
}
