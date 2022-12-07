<?php

namespace App\Http\Livewire;

use App\Models\Spk;
use Livewire\Component;

class Spks extends Component
{
    // public $spks;

    public function render()
    {
        $spks=Spk::latest()->get();
        // dd($spks);
        $data=[
            'spks'=>$spks
        ];
        return view('livewire.spks', ['spks'=>$spks]);
    }
}
