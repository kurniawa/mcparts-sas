<?php

namespace App\Http\Livewire;

use App\Models\Pembelian as ModelsPembelian;
use Livewire\Component;

class Pembelian extends Component
{
    public $pembelian=[
        'nama_barang'=>'',
        'jenis_barang'=>'',
        'supplier'=>'',
        'jumlah'=>'',
        'harga_pcs'=>'',
        'harga_total'=>'',
        'tanggal'=>'',
    ];

    public function mount()
    {
        $this->pembelian['tanggal']=date("Y-m-d H:i:s");
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

    public function addPembelian()
    {
        // dump('masuk ke input pembelian');
        // dd($this->pembelian);
        $this->validate([
            'pembelian.nama_barang'=>'required',
            'pembelian.jumlah'=>'required',
            'pembelian.harga_pcs'=>'required',
            'pembelian.harga_total'=>'required',
            'pembelian.tanggal'=>'required',
        ]);
        // dd($this->pembelian);
        ModelsPembelian::create($this->pembelian);
        // dd('lolos validate!');
        $this->resetFormPembelian();
        session()->flash('success_logs',"Pembelian baru telah diinput ke database!");
    }

    public function resetFormPembelian()
    {
        $this->pembelian=[
            'nama_barang'=>'',
            'jenis_barang'=>'',
            'supplier'=>'',
            'jumlah'=>'',
            'harga_pcs'=>'',
            'harga_total'=>'',
            'tanggal'=>date('Y-m-d H:i:s'),
        ];
    }

    public function deletePembelian($pembelian_id)
    {
        // dd($pembelian_id);
        $pembelian=ModelsPembelian::find($pembelian_id);
        $pembelian->delete();
        session()->flash('warning_logs',"Pembelian $pembelian->nama_barang telah dihapus dari database!");
    }
}
