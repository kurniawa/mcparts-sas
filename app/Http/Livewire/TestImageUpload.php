<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Intervention\Image\ImageManagerStatic as Image;

class TestImageUpload extends Component
{
    public function render()
    {
        return view('livewire.test-image-upload');
    }

    public $image_to_preview;

    protected $listeners=[
        'imagePreview'=>'handleImagePreview',
    ];
    public function handleImagePreview($image_data)
    {
        $this->image_to_preview=$image_data;
        // dd($image_data);
        // $new_image=Image::make($this->image_to_preview)->encode('jpg');
        // dump($new_image);
    }

    public function uploadImage()
    {
        // dd($this);
        // $this->validate([
        //     'image_to_preview' => 'required|image|file|mimes:jpeg,png,jpg',
        // ]);
        // $user=User::find($this->user['id']);
        $created_image=Image::make($this->image_to_preview)->encode('jpg');
        $image_name="PP-".uniqid().".jpg";
        dump($created_image->filesize());
        if ($created_image->filesize() > 1048576) {
            // resize the image so that the largest side fits within the limit; the smaller
            // side will be scaled to maintain the original aspect ratio

            $created_image=$created_image->resize(1773, 1773, function ($constraint)
            {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }
        dd($created_image->filesize());
        $created_image->save("images/profile_pictures/$image_name");
    }
}
