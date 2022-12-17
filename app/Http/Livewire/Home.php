<?php

namespace App\Http\Livewire;

use App\Models\Spk;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $spks=Spk::latest()->limit(100)->get();
        // dd($spks);
        $notas=array();

        $data=[
            'spks'=>$spks
        ];
        return view('livewire.home', $data);
    }
}
