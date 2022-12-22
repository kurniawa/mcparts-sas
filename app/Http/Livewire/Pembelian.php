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
        'created_by'=>'',
    ];
    public $mode = 'new';

    public function mount()
    {
        $this->pembelian['tanggal']=date("Y-m-d H:i:s");
        $this->pembelian['created_by']=auth()->user()->username;
    }
    public function render()
    {
        // $tanggal=date("Y-m-d H:i:s");
        $pembelians=ModelsPembelian::latest()->limit(300)->paginate(50);
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
            'created_by'=>auth()->user()->username,
        ];
    }

    public function deletePembelian($pembelian_id)
    {
        // dd($pembelian_id);
        $pembelian=ModelsPembelian::find($pembelian_id);
        $pembelian->delete();
        session()->flash('warning_logs',"Pembelian $pembelian->nama_barang telah dihapus dari database!");
    }

    public function calculateHargaTotal()
    {
        $this->pembelian['harga_total'] = (int)$this->pembelian['jumlah'] * (int)$this->pembelian['harga_pcs'];
    }

    public function triggerEdit($pembelian_id)
    {
        // dd("edit trigered for: $pembelian_id");
        $this->mode = "edit";
        $pembelian = ModelsPembelian::find($pembelian_id);
        $this->pembelian['nama_barang'] = $pembelian->nama_barang;
        $this->pembelian['jenis_barang'] = $pembelian->jenis_barang;
        $this->pembelian['supplier'] = $pembelian->supplier;
        $this->pembelian['jumlah_1'] = $pembelian->jumlah;
        $this->pembelian['satuan_1'] = $pembelian->satuan;
        $this->pembelian['harga_1'] = $pembelian->satuan;
        $this->pembelian['satuan_2'] = $pembelian->harga_satuan;
        $this->pembelian['harga_per_satuan'] = $pembelian->harga_total_satuan;
        $this->pembelian['harga_total_satuan'] = $pembelian->harga_total_satuan;
    }
}
