<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Dashboard extends Component
{
    use WithFileUploads;
    public $profile_picture;
    public $photo;
    public $photo_to_resize;
    public $user=[
        'id'=>'',
        'nama'=>'',
        'username'=>'',
    ];
    public $current_password;
    public $new_password;
    public $confirm_new_password;

    public function mount()
    {
        $user=auth()->user();
        $this->user['id']=$user->id;
        $this->user['nama']=$user->nama;
        $this->user['username']=$user->username;
        $this->profile_picture=$user->profile_picture;
    }
    public function render()
    {
        return view('livewire.dashboard');
    }

    public function updateNama()
    {
        // dd($this->user['nama']);
        $this->validate([
            'user.nama'=>'required|min:3'
        ]);
        $user=User::find($this->user['id']);
        // dump($this->user['nama']);
        $user->update([
            'nama'=>$this->user['nama']
        ]);
        // dd($user);

        session()->flash('nama_updated','Nama telah berhasil diupdate.');
    }

    public function updateUsername()
    {
        $this->validate([
            'user.username'=>'required|min:3'
        ]);
        $user=User::find($this->user['id']);
        $user->update([
            'username'=>$this->user['username']
        ]);

        session()->flash('username_updated','Username telah berhasil diupdate.');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password'=>['required'],
            'new_password'=>['required','min:8'],
            'confirm_new_password'=>['required','same:new_password'],
        ]);

        // Cek apakah current_password yang diinput sudah benar
        if (!Hash::check($this->current_password, auth()->user()->password)) {
            session()->flash('password_errors','Password yang Anda input tidak sesuai!');
            return false;
        }
        $user=User::find($this->user['id']);
        $user->update([
            'password'=> bcrypt($this->new_password)
        ]);

        // reset kolom input password
        $this->current_password=null;
        $this->new_password=null;
        $this->confirm_new_password=null;

        // send flash message
        session()->flash('password_updated','Password telah berhasil diupdate.');
    }

    public function savePhoto()
    {
        // dd($this);
        // dump($this->photo);
        // dump($this->photo->temporaryUrl());
        // dd($this->photo->getFileName());
        // dd($this->photo->path); ga boleh diakses
        // dd($this->photo['realPath']); error mengakses array pada object
        $this->validate([
            'photo' => 'image|max:3072|mimes:jpeg,jpg', // 3MB Max
        ]);
        // Sebelum mulai save, check terlebih dahulu apakah user ini memiliki PP sebelumnya.
        $user=User::find($this->user['id']);
        $save_photo_logs="";
        if ($user->profile_picture) {
            // dd(Storage::allDirectories());
            if (Storage::exists($user->profile_picture)) {
                Storage::delete($user->profile_picture);
                $save_photo_logs.="Profile-Picture yang lama telah dihapus dari storage!";
            }
        }

        $new_photo_name="PP-". uniqid() . ".jpg";
        $new_photo_path=$this->photo->storeAs('images/profile-pictures',$new_photo_name);
        $user->update([
            'profile_picture'=>$new_photo_path
        ]);
        // dump($new_photo_path);
        // dd($user);
        $save_photo_logs.=" Profile-Picture telah berhasil disimpan dalam data user.";

        $dont_delete_last_temp="livewire-tmp/". $this->photo->getFileName();
        $this->cleanupOldTemp($dont_delete_last_temp);
        $save_photo_logs.=" Data pada livewire-tmp telah dihapus.";

        // reset profile_picture
        $this->profile_picture=$user->profile_picture;

        // send flash message
        session()->flash('save_photo_logs',$save_photo_logs);
    }

    /**
     * Fungsi updatedPhoto udah otomatis diatur dari Livewire nya untuk menjalankan realtime validation
     */
    public function updatedPhoto()
    {
        $this->validate([
            'photo'=>'image|max:3072|mimes:jpeg,jpg',
        ]);
    }

    public function cleanupOldTemp($dont_delete_last_temp)
    {
        $oldFiles=Storage::files('livewire-tmp');
        foreach ($oldFiles as $file) {
            if ($file!==$dont_delete_last_temp) {
                Storage::delete($file);
            }
        }
    }

    public function deletePhoto()
    {
        $user=User::find($this->user['id']);
        $delete_photo_logs="";
        if ($user->profile_picture) {
            // dd(Storage::allDirectories());
            if (Storage::exists($user->profile_picture)) {
                Storage::delete($user->profile_picture);
                $delete_photo_logs.="Profile-Picture yang lama telah dihapus dari storage!";
            }
            $user->update([
                'profile_picture'=>null
            ]);
            $delete_photo_logs.="Profile-Picture telah dihapus dari data User";
        } else {
            $delete_photo_logs.="User ini belum memiliki Profile Picture untuk dihapus!";
        }

        // reset profile_picture
        $this->profile_picture=$user->profile_picture;

        // send flash message
        session()->flash('delete_photo_logs',$delete_photo_logs);
    }
    // protected function cleanupOldUploads()
    // {
    //     if (FileUploadConfiguration::isUsingS3()) return;

    //     $storage = FileUploadConfiguration::storage();

    //     foreach ($storage->allFiles(FileUploadConfiguration::path()) as $filePathname) {
    //         // On busy websites, this cleanup code can run in multiple threads causing part of the output
    //         // of allFiles() to have already been deleted by another thread.
    //         if (! $storage->exists($filePathname)) continue;

    //         $yesterdaysStamp = now()->subDay()->timestamp;
    //         if ($yesterdaysStamp > $storage->lastModified($filePathname)) {
    //             $storage->delete($filePathname);
    //         }
    //     }
    // }
}
