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
        'satuan_rol'=>'',
        'satuan_meter'=>'',
        'jumlah_rol'=>'',
        'jumlah_meter'=>'',
        'harga_meter'=>'',
        'harga_total'=>'',
        'created_at'=>'',
        'created_by'=>'',
    ];
    public $mode = 'new';
    public $sistem_double_satuan="yes";
    public $class_toggle_satuan='right-0.5';
    public $class_bg_toggle_satuan='bg-emerald-400';

    public function mount()
    {
        $this->pembelian['created_at']=date("Y-m-d H:i:s");
        $this->pembelian['satuan_rol']='rol';
        $this->pembelian['satuan_meter']='meter';
        $this->pembelian['created_by']=auth()->user()->username;
    }
    public function render()
    {
        // $tanggal=date("Y-m-d H:i:s");
        $pembelians=ModelsPembelian::latest()->limit(300)->paginate(50);
        $data=[
            'pembelians'=>$pembelians,
            'sistem_double_satuan'=>$this->sistem_double_satuan,
            'satuan_rol'=>$this->pembelian['satuan_rol'],
            'satuan_meter'=>$this->pembelian['satuan_meter'],
        ];
        return view('livewire.pembelian', $data);
    }

    public function addPembelian()
    {
        // dump('masuk ke input pembelian');
        // dd($this->pembelian);
        $this->validate([
            'pembelian.nama_barang'=>'required',
            'pembelian.jumlah_meter'=>'required',
            'pembelian.harga_meter'=>'required',
            'pembelian.harga_total'=>'required',
            'pembelian.created_at'=>'required',
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
            'satuan_rol'=>'rol',
            'satuan_meter'=>'meter',
            'jumlah_rol'=>'',
            'jumlah_meter'=>'',
            'harga_meter'=>'',
            'harga_total'=>'',
            'created_at'=>date('Y-m-d H:i:s'),
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
        if ($this->sistem_double_satuan==='yes') {
            $this->pembelian['harga_total'] = (int)$this->pembelian['jumlah_rol'] * (int)$this->pembelian['jumlah_meter'] * (int)$this->pembelian['harga_meter'];
        } else {
            $this->pembelian['harga_total'] = (int)$this->pembelian['jumlah_meter'] * (int)$this->pembelian['harga_meter'];
        }
    }

    public function toggleSatuan()
    {
        if ($this->sistem_double_satuan==="yes") {
            $this->sistem_double_satuan='no';
            $this->class_toggle_satuan='left-0.5';
            $this->class_bg_toggle_satuan='bg-slate-100';
            $this->pembelian['satuan_rol']=null;
            $this->pembelian['jumlah_rol']=null;
        } elseif ($this->sistem_double_satuan="no") {
            $this->sistem_double_satuan="yes";
            $this->class_toggle_satuan='right-0.5';
            $this->class_bg_toggle_satuan='bg-emerald-400';
            $this->pembelian['satuan_rol']='rol';
        }
    }

    public $show_form_pembelian="no";
    public function toggleFormPembelian()
    {
        if ($this->show_form_pembelian='no') {
            # code...
        }
    }

    public function triggerEdit($pembelian_id)
    {
        // dd("edit trigered for: $pembelian_id");
        $this->mode = "edit";
        $pembelian = ModelsPembelian::find($pembelian_id);
        $this->pembelian['nama_barang'] = $pembelian->nama_barang;
        $this->pembelian['jenis_barang'] = $pembelian->jenis_barang;
        $this->pembelian['supplier'] = $pembelian->supplier;
        $this->pembelian['satuan_rol'] = $pembelian->satuan_rol;
        $this->pembelian['satuan_meter'] = $pembelian->satuan_meter;
        $this->pembelian['jumlah_rol'] = $pembelian->jumlah_rol;
        $this->pembelian['jumlah_meter'] = $pembelian->jumlah_meter;
        $this->pembelian['harga_meter'] = $pembelian->harga_meter;
        $this->pembelian['harga_total'] = $pembelian->harga_total;
    }
}
