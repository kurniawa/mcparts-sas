<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $form=[
        "username"=>"",
        "password"=>"",
    ];

    public function render()
    {
        return view('livewire.login',['route'=>'login']);
    }
    public function login()
    {
        $this->validate([
            'form.username'=>'required',
            'form.password'=>'required',
        ]);
        // dd($this->form);
        $login_attempt_status=Auth::attempt($this->form);
        if ($login_attempt_status==true) {
            $user=auth()->user();
            $success_="Berhasil login sebagai $user->name";
            return redirect(route('home'))->with(['success_'=>$success_]);
        }
    }

    public function logout()
    {
        // dd('masuk ke logout');
        Auth::logout();
        return redirect(route('login'))->with(['success_'=>'Anda telah logout dari sistem!']);
    }
}
