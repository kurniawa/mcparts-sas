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

        $this->filter['tanggal_dari']=date("Y-m-d H:i:s");
        $this->filter['tanggal_sampai']=date("Y-m-d H:i:s");
    }
    public function render()
    {
        // $tanggal=date("Y-m-d H:i:s");
        if ($this->hasil_filter!=='') {
            $pembelians=$this->hasil_filter;
        } else {
            $pembelians=ModelsPembelian::latest()->limit(300)->paginate(50);
        }
        $data=[
            'pembelians'=>$pembelians,
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
    public $class_btn_input_pembelian="";
    public function toggleFormPembelian()
    {
        if ($this->show_form_pembelian==="no") {
            $this->show_form_pembelian="yes";
        } elseif ($this->show_form_pembelian==="yes") {
            $this->show_form_pembelian="no";
        }
    }

    public $filter=[
        'nama_barang'=>'',
        'jenis_barang'=>'',
        'supplier'=>'',
        'tanggal_dari'=> '',
        'tanggal_sampai'=> '',
    ];

    public $show_filter="no";
    public function toggleFilter()
    {
        if ($this->show_filter==="no") {
            $this->show_filter="yes";
        } elseif ($this->show_filter==="yes") {
            $this->show_filter="no";
        }
    }
    public $hasil_filter='';
    public function filterPembelians()
    {
        // dd("filter:",$this->filter);
        if ($this->filter['nama_barang']!=='') {
            if ($this->filter['jenis_barang']!=='') {
                if ($this->filter['supplier']!=='') {
                    if ($this->filter['tanggal_dari']!=='' && $this->filter['tanggal_sampai']!=='') {
                        $pembelians=ModelsPembelian::where('nama_barang','like',"%".$this->filter['nama_barang']."%")
                        ->where('jenis_barang','like',"%".$this->filter['jenis_barang']."%")
                        ->where('supplier','like',"%".$this->filter['supplier']."%")
                        ->whereBetween('created_at',[$this->filter['tanggal_dari'],$this->filter['tanggal_sampai']])
                        ->limit(300)->orderByDesc('created_at')->get();
                    } else {
                        $pembelians=ModelsPembelian::where('nama_barang','like',"%".$this->filter['nama_barang']."%")
                        ->where('jenis_barang','like',"%".$this->filter['jenis_barang']."%")
                        ->where('supplier','like',"%".$this->filter['supplier']."%")
                        ->latest()->limit(300)->get();
                    }
                } else {
                    if ($this->filter['tanggal_dari']!=='' && $this->filter['tanggal_sampai']!=='') {
                        $pembelians=ModelsPembelian::where('nama_barang','like',"%".$this->filter['nama_barang']."%")
                        ->where('jenis_barang','like',"%".$this->filter['jenis_barang']."%")
                        ->whereBetween('created_at',[$this->filter['tanggal_dari'],$this->filter['tanggal_sampai']])
                        ->limit(300)->orderByDesc('created_at')->get();
                    } else {
                        $pembelians=ModelsPembelian::where('nama_barang','like',"%".$this->filter['nama_barang']."%")
                        ->where('jenis_barang','like',"%".$this->filter['jenis_barang']."%")
                        ->latest()->limit(300)->get();
                    }
                }
            } else {
                if ($this->filter['supplier']!=='') {
                    if ($this->filter['tanggal_dari']!=='' && $this->filter['tanggal_sampai']!=='') {
                        $pembelians=ModelsPembelian::where('nama_barang','like',"%".$this->filter['nama_barang']."%")
                        ->where('supplier','like',"%".$this->filter['supplier']."%")
                        ->whereBetween('created_at',[$this->filter['tanggal_dari'],$this->filter['tanggal_sampai']])
                        ->limit(300)->orderByDesc('created_at')->get();
                    } else {
                        $pembelians=ModelsPembelian::where('nama_barang','like',"%".$this->filter['nama_barang']."%")
                        ->where('jenis_barang','like',"%".$this->filter['jenis_barang']."%")
                        ->where('supplier','like',"%".$this->filter['supplier']."%")
                        ->latest()->limit(300)->get();
                    }
                } else {
                    if ($this->filter['tanggal_dari']!=='' && $this->filter['tanggal_sampai']!=='') {
                        $pembelians=ModelsPembelian::where('nama_barang','like',"%".$this->filter['nama_barang']."%")
                        ->whereBetween('created_at',[$this->filter['tanggal_dari'],$this->filter['tanggal_sampai']])
                        ->limit(300)->orderByDesc('created_at')->get();
                    } else {
                        $pembelians=ModelsPembelian::where('nama_barang','like',"%".$this->filter['nama_barang']."%")
                        ->latest()->limit(300)->get();
                    }
                }
            }
        } elseif ($this->filter['jenis_barang']!=='') {
            if ($this->filter['supplier']!=='') {
                if ($this->filter['tanggal_dari']!=='' && $this->filter['tanggal_sampai']!=='') {
                    $pembelians=ModelsPembelian::where('jenis_barang','like',"%".$this->filter['jenis_barang']."%")
                    ->where('supplier','like',"%".$this->filter['supplier']."%")
                    ->whereBetween('created_at',[$this->filter['tanggal_dari'],$this->filter['tanggal_sampai']])
                    ->limit(300)->orderByDesc('created_at')->get();
                } else {
                    $pembelians=ModelsPembelian::where('jenis_barang','like',"%".$this->filter['jenis_barang']."%")
                    ->where('supplier','like',"%".$this->filter['supplier']."%")
                    ->latest()->limit(300)->get();
                }
            } else {
                if ($this->filter['tanggal_dari']!=='' && $this->filter['tanggal_sampai']!=='') {
                    $pembelians=ModelsPembelian::where('jenis_barang','like',"%".$this->filter['jenis_barang']."%")
                    ->whereBetween('created_at',[$this->filter['tanggal_dari'],$this->filter['tanggal_sampai']])
                    ->limit(300)->orderByDesc('created_at')->get();
                } else {
                    $pembelians=ModelsPembelian::where('jenis_barang','like',"%".$this->filter['jenis_barang']."%")
                    ->latest()->limit(300)->get();
                }
            }
        } elseif ($this->filter['supplier']!=='') {
            if ($this->filter['tanggal_dari']!=='' && $this->filter['tanggal_sampai']!=='') {
                $pembelians=ModelsPembelian::where('supplier','like',"%".$this->filter['supplier']."%")
                ->whereBetween('created_at',[$this->filter['tanggal_dari'],$this->filter['tanggal_sampai']])
                ->limit(300)->orderByDesc('created_at')->get();
            } else {
                $pembelians=ModelsPembelian::where('supplier','like',"%".$this->filter['supplier']."%")
                ->latest()->limit(300)->get();
            }
        } elseif ($this->filter['tanggal_dari']!=='' && $this->filter['tanggal_sampai']!=='') {
            $pembelians=ModelsPembelian::whereBetween('created_at',[$this->filter['tanggal_dari'],$this->filter['tanggal_sampai']])
                ->limit(300)->orderByDesc('created_at')->get();
        } else {
            $pembelians="";
        }

        $this->hasil_filter = $pembelians;
        // dd($pembelians);
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
        $this->pembelian['created_at'] = date('Y-m-d H:i:s', strtotime($pembelian->created_at));
        // dd($this->pembelian);
    }
}
