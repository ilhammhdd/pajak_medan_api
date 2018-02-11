<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 12/27/2017
 * Time: 8:53 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'id', 'file_path', 'file_name'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'file_id', 'id');
    }

    public function category()
    {
        return $this->hasOne('App\Category', 'file_id', 'id');
    }

    public function good()
    {
        return $this->hasOne('App\Good', 'file_id', 'id');
    }

//======================================================================================================================

    public static function uploadFile(Request $request)
    {
        if (isset($request->json("data")["file"])) {

//        if ($request->get("file") !== null) {
            $encodedString = $request->json("data")["file"];
            $fileName = $request->json("data")["image_name"];

//            $encodedString = $request->get("file");
//            $fileName = $request->get("image_name");

            $decodeString = base64_decode($encodedString);

            $path = storage_path('app\\images\\') . $fileName;

            $file = fopen($path, 'wb');

            $isWritten = fwrite($file, $decodeString);

            fclose($file);

            if ($isWritten > 0) {
                $theFile = new File();
                $theFile->file_path = $path;
                $theFile->file_name = $fileName;
                $theFile->save();
            }
        }
    }
}