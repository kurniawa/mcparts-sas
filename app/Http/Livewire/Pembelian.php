<?php

namespace App\Http\Livewire;

use App\Models\Pembelian as ModelsPembelian;
use Livewire\Component;

class Pembelian extends Component
{
    public $nama_barang="";
    public $jenis_barang="";
    public $jumlah=0;
    public $harga_pcs=0;
    public $harga_total=0;
    
    public function render()
    {
        $pembelians=ModelsPembelian::latest()->limit(100)->paginate(50);
        $data=[
            'pembelians'=>$pembelians
        ];
        return view('livewire.pembelian', $data);
    }
}
