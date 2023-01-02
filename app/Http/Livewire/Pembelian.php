<?php

namespace App\Http\Livewire;

use App\Models\Pembelian as ModelsPembelian;
use Livewire\Component;

class Pembelian extends Component
{
    public $pembelian=[
        'nama_barang'=>'',
        'keterangan'=>'',
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
    // public $mode = 'new';
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
        if ($this->hasil_filter!=="") {
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
            'keterangan'=>'',
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
        'keterangan'=>'',
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
            if ($this->filter['keterangan']!=='') {
                if ($this->filter['supplier']!=='') {
                    if ($this->filter['tanggal_dari']!=='' && $this->filter['tanggal_sampai']!=='') {
                        $pembelians=ModelsPembelian::where('nama_barang','like',"%".$this->filter['nama_barang']."%")
                        ->where('keterangan','like',"%".$this->filter['keterangan']."%")
                        ->where('supplier','like',"%".$this->filter['supplier']."%")
                        ->whereBetween('created_at',[$this->filter['tanggal_dari'],$this->filter['tanggal_sampai']])
                        ->limit(300)->orderByDesc('created_at')->get();
                    } else {
                        $pembelians=ModelsPembelian::where('nama_barang','like',"%".$this->filter['nama_barang']."%")
                        ->where('keterangan','like',"%".$this->filter['keterangan']."%")
                        ->where('supplier','like',"%".$this->filter['supplier']."%")
                        ->latest()->limit(300)->get();
                    }
                } else {
                    if ($this->filter['tanggal_dari']!=='' && $this->filter['tanggal_sampai']!=='') {
                        $pembelians=ModelsPembelian::where('nama_barang','like',"%".$this->filter['nama_barang']."%")
                        ->where('keterangan','like',"%".$this->filter['keterangan']."%")
                        ->whereBetween('created_at',[$this->filter['tanggal_dari'],$this->filter['tanggal_sampai']])
                        ->limit(300)->orderByDesc('created_at')->get();
                    } else {
                        $pembelians=ModelsPembelian::where('nama_barang','like',"%".$this->filter['nama_barang']."%")
                        ->where('keterangan','like',"%".$this->filter['keterangan']."%")
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
                        ->where('keterangan','like',"%".$this->filter['keterangan']."%")
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
        } elseif ($this->filter['keterangan']!=='') {
            if ($this->filter['supplier']!=='') {
                if ($this->filter['tanggal_dari']!=='' && $this->filter['tanggal_sampai']!=='') {
                    $pembelians=ModelsPembelian::where('keterangan','like',"%".$this->filter['keterangan']."%")
                    ->where('supplier','like',"%".$this->filter['supplier']."%")
                    ->whereBetween('created_at',[$this->filter['tanggal_dari'],$this->filter['tanggal_sampai']])
                    ->limit(300)->orderByDesc('created_at')->get();
                } else {
                    $pembelians=ModelsPembelian::where('keterangan','like',"%".$this->filter['keterangan']."%")
                    ->where('supplier','like',"%".$this->filter['supplier']."%")
                    ->latest()->limit(300)->get();
                }
            } else {
                if ($this->filter['tanggal_dari']!=='' && $this->filter['tanggal_sampai']!=='') {
                    $pembelians=ModelsPembelian::where('keterangan','like',"%".$this->filter['keterangan']."%")
                    ->whereBetween('created_at',[$this->filter['tanggal_dari'],$this->filter['tanggal_sampai']])
                    ->limit(300)->orderByDesc('created_at')->get();
                } else {
                    $pembelians=ModelsPembelian::where('keterangan','like',"%".$this->filter['keterangan']."%")
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

    // EDIT PEMBELIAN
    public $edit_pembelian=[
        'id'=>'',
        'nama_barang'=>'',
        'keterangan'=>'',
        'supplier'=>'',
        'satuan_rol'=>'',
        'satuan_meter'=>'',
        'jumlah_rol'=>'',
        'jumlah_meter'=>'',
        'harga_meter'=>'',
        'harga_total'=>'',
        'created_at'=>'',
        'updated_at'=>'',
        'updated_by'=>'',
    ];
    public $show_form_edit="no";
    public $sistem_double_satuan_edit="yes";
    public $class_toggle_satuan_edit='right-0.5';
    public $class_bg_toggle_satuan_edit='bg-emerald-400';
    public function triggerEdit($pembelian_id)
    {
        // dd("edit trigered for: $pembelian_id");
        // $this->mode = "edit";
        $pembelian = ModelsPembelian::find($pembelian_id);
        $this->edit_pembelian['id'] = $pembelian->id;
        $this->edit_pembelian['nama_barang'] = $pembelian->nama_barang;
        $this->edit_pembelian['keterangan'] = $pembelian->keterangan;
        $this->edit_pembelian['supplier'] = $pembelian->supplier;
        $this->edit_pembelian['satuan_rol'] = $pembelian->satuan_rol;
        $this->edit_pembelian['satuan_meter'] = $pembelian->satuan_meter;
        $this->edit_pembelian['jumlah_rol'] = $pembelian->jumlah_rol;
        $this->edit_pembelian['jumlah_meter'] = $pembelian->jumlah_meter;
        $this->edit_pembelian['harga_meter'] = $pembelian->harga_meter;
        $this->edit_pembelian['harga_total'] = $pembelian->harga_total;
        $this->edit_pembelian['created_at'] = date('Y-m-d H:i:s', strtotime($pembelian->created_at));
        $this->edit_pembelian['updated_by'] = auth()->user()->username;
        // dd($this->pembelian);
        if ($pembelian->satuan_rol===null || $pembelian->satuan_rol==="") {
            $this->sistem_double_satuan_edit="no";
            $this->class_toggle_satuan_edit='left-0.5';
            $this->class_bg_toggle_satuan_edit='bg-slate-100';
        } else {
            $this->sistem_double_satuan_edit="yes";
            $this->class_toggle_satuan_edit='right-0.5';
            $this->class_bg_toggle_satuan_edit='bg-emerald-400';
        }
        $this->show_form_edit="yes";
    }

    public function toggleSatuanEdit()
    {
        if ($this->sistem_double_satuan_edit==="yes") {
            $this->sistem_double_satuan_edit='no';
            $this->class_toggle_satuan_edit='left-0.5';
            $this->class_bg_toggle_satuan_edit='bg-slate-100';
        } elseif ($this->sistem_double_satuan_edit="no") {
            $this->sistem_double_satuan_edit="yes";
            $this->class_toggle_satuan_edit='right-0.5';
            $this->class_bg_toggle_satuan_edit='bg-emerald-400';
        }
    }

    public function cancelEdit()
    {
        $this->show_form_edit="no";
        $this->resetEdit();
    }

    public function editPembelian()
    {
        $pembelian = ModelsPembelian::find($this->edit_pembelian['id']);
        $pembelian->update([
            'nama_barang'=>$this->edit_pembelian['nama_barang'],
            'keterangan'=>$this->edit_pembelian['keterangan'],
            'supplier'=>$this->edit_pembelian['supplier'],
            'satuan_rol'=>$this->edit_pembelian['satuan_rol'],
            'satuan_meter'=>$this->edit_pembelian['satuan_meter'],
            'jumlah_rol'=>$this->edit_pembelian['jumlah_rol'],
            'jumlah_meter'=>$this->edit_pembelian['jumlah_meter'],
            'harga_meter'=>$this->edit_pembelian['harga_meter'],
            'harga_total'=>$this->edit_pembelian['harga_total'],
            'created_at'=>$this->edit_pembelian['created_at'],
            'updated_at'=>date('Y-m-d H:i:s'),
            'updated_by'=>$this->edit_pembelian['updated_by'],
        ]);
        session()->flash('success_logs',"Pembelian $pembelian->nama_barang berhasil diedit!");
    }

    public function resetEdit()
    {
        $this->edit_pembelian=[
            'id'=>'',
            'nama_barang'=>'',
            'keterangan'=>'',
            'supplier'=>'',
            'satuan_rol'=>'',
            'satuan_meter'=>'',
            'jumlah_rol'=>'',
            'jumlah_meter'=>'',
            'harga_meter'=>'',
            'harga_total'=>'',
            'created_at'=>'',
            'updated_at'=>'',
            'updated_by'=>'',
        ];
    }

    public function calculateHargaTotalEdit()
    {
        if ($this->sistem_double_satuan_edit==='yes') {
            $this->edit_pembelian['harga_total'] = (int)$this->edit_pembelian['jumlah_rol'] * (int)$this->edit_pembelian['jumlah_meter'] * (int)$this->edit_pembelian['harga_meter'];
        } else {
            $this->edit_pembelian['harga_total'] = (int)$this->edit_pembelian['jumlah_meter'] * (int)$this->edit_pembelian['harga_meter'];
        }
    }
}
