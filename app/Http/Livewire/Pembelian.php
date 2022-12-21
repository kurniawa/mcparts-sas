<?php

namespace App\Http\Livewire;

use App\Models\Pembelian as ModelsPembelian;
use Livewire\Component;

class Pembelian extends Component
{
    public $nama_barang="";
    public $jenis_barang="";
    public $supplier="";
    public $jumlah=0;
    public $harga_pcs=0;
    public $harga_total=0;
    public $tanggal="";

    public function mount()
    {
        $this->tanggal=date("Y-m-d H:i:s");
    }
    public function render()
    {
        // $tanggal=date("Y-m-d H:i:s");
        $pembelians=ModelsPembelian::latest()->limit(100)->paginate(50);
        $data=[
            'pembelians'=>$pembelians
        ];
        return view('livewire.pembelian', $data);
    }

    public function inputPembelian()
    {
        // dump('masuk ke input pembelian');
        $this->validate([
            'nama_barang'=>'required'
        ]);
        dd('lolos validate!');
    }
}
