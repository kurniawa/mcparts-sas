<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestImageUploadController extends Controller
{
    public function imageUpload(Request $request)
    {
        $request->validate([
            'image'=>'required|image|mimes:png,jpg,jpeg'
        ]);

        $file=$request->file();
        $file_image=$file['image'];

        dump(getimagesize($file_image));
        dump($file_image);
        dump('Masuk ke imageUpload');
        // dd($file);

        $max_width=1773;$max_height=1773;
        list($width_original,$height_original)=getimagesize($file_image);

        // Get new dimensions

        $ratio_original = $width_original/$height_original;

        if ($max_width/$max_height > $ratio_original) {
            $new_width = $max_height*$ratio_original;
        } else {
            $new_height = $max_width/$ratio_original;
        }

        // Resampling the image
        $image_p = imagecreatetruecolor($new_width, $new_height);
        $image = imagecreatefromjpeg($file_image);

        imagecopyresampled($image_p, $image, 0, 0, 0, 0,$new_width, $new_height, $width_original, $height_original);

        dd($image_p);

        return back();
    }
}
