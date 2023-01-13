<div class="p-5">
    {{-- Do your work, then step back. --}}
    <div>
        <button class="border border-emerald-500 rounded p-2 hover:bg-emerald-400 hover:text-white @if($show_form_pembelian==="no") text-emerald-500 @elseif($show_form_pembelian==="yes") text-white bg-emerald-400 @endif" wire:click="toggleFormPembelian">+Input Pembelian</button>
        <button class="border border-indigo-400 rounded p-2 hover:bg-indigo-400 hover:text-white @if($show_filter==="no") text-indigo-400 @elseif($show_filter==="yes") text-white bg-indigo-300 @endif" wire:click="toggleFilter">Filter</button>
        <button class="border border-orange-400 rounded p-2 hover:bg-orange-400 hover:text-white @if($show_form_edit==="no") text-orange-400 @elseif($show_form_edit==="yes") text-white bg-orange-300 @endif">Edit</button>
    </div>
    <div id="form-pembelian" class="mt-3 @if($show_form_pembelian==="no") hidden @endif">
        <form wire:submit.prevent="addPembelian" class="p-2 rounded bg-white shadow drop-shadow">
            <div class="grid grid-cols-3 gap-1">
                <div class="">
                    <label for="supplier">Supplier :</label>
                    <input class="input" type="text" wire:model="pembelian.supplier">
                </div>
                <div class="">
                    <label for="nama_barang">Nama Barang :</label>
                    <input class="input" type="text" wire:model="pembelian.nama_barang">
                    @error('pembelian.nama_barang')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="keterangan">Keterangan :</label>
                    <input class="input" type="text" wire:model="pembelian.keterangan">
                </div>
            </div>
            <div class="flex items-center mt-2">
                <label for="">Double Satuan:</label>
                <div>
                    <div class="border-2 ml-2 border-slate-200 rounded-full relative w-7 h-4 {{ $class_bg_toggle_satuan }} hover:cursor-pointer" wire:click="toggleSatuan">
                        <div class="absolute rounded-full w-2 h-2 bg-white shadow drop-shadow top-0.5 {{ $class_toggle_satuan }}"></div>
                    </div>

                </div>
                @if ($sistem_double_satuan==="yes")
                <div class="flex ml-2 items-center">
                    <label for="" class="ml-2 min-w-fit">Satuan 1:</label>
                    <input type="text" class="ml-2 input" wire:model.lazy="pembelian.satuan_rol">
                    <label for="" class="ml-2 min-w-fit">Satuan 2:</label>
                    <input type="text" class="ml-2 input" wire:model.lazy="pembelian.satuan_meter">
                </div>
                @else
                <div class="flex ml-2 items-center">
                    <label for="" class="ml-2 min-w-fit">Satuan:</label>
                    <input type="text" class="ml-2 input" wire:model.lazy="pembelian.satuan_meter">
                </div>
                @endif
            </div>
            {{-- <input type="radio" name="satuan" wire:model="sistem_double_satuan" id="" value="yes">
            <input type="radio" name="satuan" wire:model="sistem_double_satuan" id="" value="no"> --}}
            <div class="grid grid-cols-3 gap-1 mt-2">
                @if ($sistem_double_satuan==="yes")
                <div class="grid grid-cols-3">
                    <div class="">
                        <label>Jumlah {{ $pembelian['satuan_rol'] }}:</label>
                        <input class="input" type="number" step=.01 wire:model="pembelian.jumlah_rol" wire:change="calculateHargaTotal">
                        @error('pembelian.jumlah_rol')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="">
                        <label>Jumlah {{ $pembelian['satuan_meter'] }}:</label>
                        <input class="input" type="number" step=.01 wire:model="pembelian.jumlah_meter" wire:change="calculateHargaTotal">
                        @error('pembelian.jumlah_meter')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="">
                        <label>Harga/{{ $pembelian['satuan_meter'] }} :</label>
                        <input class="input" type="number" step=.01 wire:model="pembelian.harga_meter" wire:change="calculateHargaTotal">
                        @error('pembelian.harga_meter')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @elseif($sistem_double_satuan==="no")
                <div class="grid grid-cols-2">
                    <div>
                        <label>Jumlah {{ $pembelian['satuan_meter'] }}:</label>
                        <input class="input" type="number" step=.01 wire:model="pembelian.jumlah_meter" wire:change="calculateHargaTotal">
                        @error('pembelian.jumlah_meter')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="">
                        <label>Harga/{{ $pembelian['satuan_meter'] }} :</label>
                        <input class="input" type="number" step=.01 wire:model="pembelian.harga_meter" wire:change="calculateHargaTotal">
                        @error('pembelian.harga_meter')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @endif
                <div class="">
                    <label for="harga_total">Harga Total :</label>
                    <input id="harga_total" class="input" type="number" step=.01 wire:model="pembelian.harga_total">
                    @error('pembelian.harga_total')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="tanggal">Tanggal :</label>
                    <input class="input" type="datetime-local" wire:model="pembelian.created_at" step="any">
                    @error('pembelian.created_at')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-2 text-right">
                <button type="submit" class="btn-indigo rounded">Input Pembelian</button>
            </div>
        </form>
    </div>

    {{-- FILTER --}}
    <div class="rounded p-2 bg-white shadow drop-shadow mt-2 @if($show_filter==="no") hidden @endif">
        <form wire:submit.prevent="filterPembelians">
            <div class="grid grid-cols-3">
                <div class="ml-2">
                    <label>Supplier:</label>
                    <div class="flex mt-1">
                        <input type="text" class="input" placeholder="Supplier" wire:model="filter.supplier">
                    </div>
                </div>
                <div>
                    <label>Nama Barang:</label>
                    <div class="flex mt-1">
                        <input type="text" class="input" placeholder="Nama Barang" wire:model="filter.nama_barang">
                    </div>
                </div>
                <div class="ml-2">
                    <label>Keterangan:</label>
                    <div class="flex mt-1">
                        <input type="text" class="input" placeholder="Keterangan" wire:model="filter.keterangan">
                    </div>
                </div>
            </div>
            <div class="flex mt-1 ml-2">
                <div>
                    <label>Tanggal:</label>
                    <div class="flex items-center mt-1">
                        <input type="datetime-local" class="input" wire:model="filter.tanggal_dari" step="any">
                        <span class="mx-1">-</span>
                        <input type="datetime-local" class="input" wire:model="filter.tanggal_sampai" step="any">
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn-indigo mt-2 rounded">Filter</button>
            </div>
        </form>
    </div>

    {{-- EDIT PEMBELIAN --}}
    <div class="mt-3 @if($show_form_edit==="no") hidden @endif">
        <form wire:submit.prevent="editPembelian" class="p-2 rounded bg-white shadow drop-shadow">
            <div class="grid grid-cols-3 gap-1">
                <div class="">
                    <label for="supplier">Supplier :</label>
                    <input class="input" type="text" wire:model="edit_pembelian.supplier">
                </div>
                <div class="">
                    <label for="nama_barang">Nama Barang :</label>
                    <input class="input" type="text" wire:model="edit_pembelian.nama_barang">
                    @error('edit_pembelian.nama_barang')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="keterangan">Keterangan :</label>
                    <input class="input" type="text" wire:model="edit_pembelian.keterangan">
                </div>
            </div>
            <div class="flex items-center mt-2">
                <label for="">Double Satuan:</label>
                <div>
                    <div class="border-2 ml-2 border-slate-200 rounded-full relative w-7 h-4 {{ $class_bg_toggle_satuan_edit }} hover:cursor-pointer" wire:click="toggleSatuanEdit">
                        <div class="absolute rounded-full w-2 h-2 bg-white shadow drop-shadow top-0.5 {{ $class_toggle_satuan_edit }}"></div>
                    </div>

                </div>
                @if ($sistem_double_satuan_edit==="yes")
                <div class="flex ml-2 items-center">
                    <label for="" class="ml-2 min-w-fit">Satuan 1:</label>
                    <input type="text" class="ml-2 input" wire:model.lazy="edit_pembelian.satuan_rol">
                    <label for="" class="ml-2 min-w-fit">Satuan 2:</label>
                    <input type="text" class="ml-2 input" wire:model.lazy="edit_pembelian.satuan_meter">
                </div>
                @else
                <div class="flex ml-2 items-center">
                    <label for="" class="ml-2 min-w-fit">Satuan:</label>
                    <input type="text" class="ml-2 input" wire:model.lazy="edit_pembelian.satuan_meter">
                </div>
                @endif
            </div>
            {{-- <input type="radio" name="satuan" wire:model="sistem_double_satuan" id="" value="yes">
            <input type="radio" name="satuan" wire:model="sistem_double_satuan" id="" value="no"> --}}
            <div class="grid grid-cols-3 gap-1 mt-2">
                @if ($sistem_double_satuan_edit==="yes")
                <div class="grid grid-cols-3">
                    <div class="">
                        <label>Jumlah {{ $edit_pembelian['satuan_rol'] }}:</label>
                        <input class="input" type="number" step=.01 wire:model="edit_pembelian.jumlah_rol" wire:change="calculateHargaTotalEdit">
                        @error('edit_pembelian.jumlah_rol')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="">
                        <label>Jumlah {{ $edit_pembelian['satuan_meter'] }}:</label>
                        <input class="input" type="number" step=.01 wire:model="edit_pembelian.jumlah_meter" wire:change="calculateHargaTotalEdit">
                        @error('edit_pembelian.jumlah_meter')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="">
                        <label>Harga/{{ $edit_pembelian['satuan_meter'] }} :</label>
                        <input class="input" type="number" step=.01 wire:model="edit_pembelian.harga_meter" wire:change="calculateHargaTotalEdit">
                        @error('edit_pembelian.harga_meter')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @else
                <div class="grid grid-cols-2">
                    <div>
                        <label>Jumlah {{ $edit_pembelian['satuan_meter'] }}:</label>
                        <input class="input" type="number" step=.01 wire:model="edit_pembelian.jumlah_meter" wire:change="calculateHargaTotalEdit">
                        @error('edit_pembelian.jumlah_meter')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="">
                        <label>Harga/{{ $edit_pembelian['satuan_meter'] }} :</label>
                        <input class="input" type="number" step=.01 wire:model="edit_pembelian.harga_meter" wire:change="calculateHargaTotalEdit">
                        @error('edit_pembelian.harga_meter')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @endif
                <div class="">
                    <label for="harga_total">Harga Total :</label>
                    <input id="harga_total" class="input" type="number" step=.01 wire:model="edit_pembelian.harga_total">
                    @error('edit_pembelian.harga_total')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="tanggal">Tanggal :</label>
                    <input class="input" type="datetime-local" step="any" wire:model="edit_pembelian.created_at">
                    @error('edit_pembelian.created_at')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-2 text-right">
                <button type="button" class="btn-danger rounded" wire:click="cancelEdit">Batal</button>
                <button type="submit" class="btn-indigo rounded">Konfirm Edit</button>
            </div>
        </form>
    </div>

    {{-- Session Feedback --}}
    @if (session()->has('success_logs'))
    <div class="mt-3 font-semibold w-full px-3 py-2 rounded bg-emerald-200 text-emerald-600 opacity-70">
        {{ session('success_logs') }}
    </div>
    @endif
    @if (session()->has('warning_logs'))
    <div class="mt-3 font-semibold w-full px-3 py-2 rounded bg-orange-200 text-orange-600 opacity-70">
        {{ session('warning_logs') }}
    </div>
    @endif

    {{-- Table Pembelian --}}
    <button class="btn-emerald rounded mt-2" onclick="downloadExcel('table_pembelian_for_download')">Download Excel</button>
    <table class="table-nice w-full mt-1">
        <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th colspan="2"></th>
                <th>Grand Total</th>
                <th><div class="flex justify-between"><span>Rp</span><span>{{ number_format($grand_total,0,',','.') }},-</span></div></th>
                <th></th>
            </tr>
            <tr>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>Nama Barang</th>
                <th>Keterangan</th>
                <th colspan="2">Jumlah</th>
                <th>Harga/satuan</th>
                <th>Harga Total</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembelians as $item)
                <tr>
                    <td>{{ date('d-m-Y',strtotime($item->created_at)) }}</td>
                    <td>{{ $item->supplier }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td><div class="w-full flex items-center">{{ $item->jumlah_rol }} {{ $item->satuan_rol }}</div></td>
                    {{-- &#64;{{ $item->jumlah_meter }}{{ $item->satuan_meter }} --}}
                    <td><div class="w-full flex items-center">{{ $item->jumlah_meter }} {{ $item->satuan_meter }}</div></td>
                    <td><div class="flex justify-between"><span>Rp</span><span>{{ number_format($item->harga_meter, 2, ',','.') }}</span></div></td>
                    <td><div class="flex justify-between"><span>Rp</span><span>{{ number_format($item->harga_total, 2, ',','.') }}</span></div></td>
                    <td>
                        <div class="flex">
                            <button id="deleteButton-{{ $item->id }}" class="bg-pink-500 text-white rounded p-1 hover:bg-pink-600" onclick="showConfirmDelete('deleteButton-{{ $item->id }}','confirmDelete-{{ $item->id }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                            <div id="confirmDelete-{{ $item->id }}" class="hidden">
                                <button class="bg-pink-500 text-white rounded p-1 hover:bg-pink-600" wire:click="deletePembelian({{ $item->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                    </svg>
                                </button>
                                <button class="bg-yellow-400 text-white rounded p-1 hover:bg-yellow-500 ml-1" onclick="hideConfirmDelete('deleteButton-{{ $item->id }}','confirmDelete-{{ $item->id }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <button id="editButton-{{ $item->id }}" class="bg-yellow-500 text-white rounded p-1 hover:bg-yellow-600 ml-1" wire:click="triggerEdit({{ $item->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Table untuk PrintOut --}}
        <table id="table_pembelian_for_download" class="hidden">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Nama Barang</th>
                    <th>Keterangan</th>
                    <th colspan="2">Jumlah</th>
                    <th>Harga/satuan</th>
                    <th>Harga Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembelians_raw as $item)
                <tr>
                    <td>{{ date('d-m-Y',strtotime($item->created_at)) }}</td>
                    <td>{{ $item->supplier }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ $item->jumlah_rol }} {{ $item->satuan_rol }}</td>
                    <td>{{ $item->jumlah_meter }} {{ $item->satuan_meter }}</td>
                    <td>{{ $item->harga_meter }}</td>
                    <td>{{ $item->harga_total }}</td>
                </tr>
                @endforeach
                <tr>
                    <td></td><td></td><td></td><td></td><td></td><td></td>
                    <td>Grand Total</td>
                    <td>{{ $grand_total }}</td>
                </tr>
            </tbody>
        </table>
    <script>
        function toFormatCurrencyRp() {
            var toFormatRp=document.querySelectorAll('.toFormatCurrencyRp');
            toFormatRp.forEach(element => {
                // console.log('toFormatRp');
                formatCurrencyRp(parseInt(element.textContent), element);
            });

        }

        function formatCurrencyRp(number, element) {
            // console.log(element);
            var formatted_number = formatHarga(number.toString());
            if (element == null) {
                return formatted_number;
            } else {
                element.innerHTML = `<div><div class="flex justify-between"><span>Rp</span><span>${formatted_number},-</span></div></div>`;
                // console.log(element);
                return true;
            }
        }

        function formatHarga(harga) {
            // console.log(harga);
            let harga_ohne_titik = harga.replace(".", "");
            if (harga_ohne_titik.length < 4) {
                return harga;
            }
            let hargaRP = "";
            let akhir = harga_ohne_titik.length;
            let posisi = akhir - 3;
            let jmlTitik = Math.ceil(harga_ohne_titik.length / 3 - 1);
            // console.log(jmlTitik);
            for (let i = 0; i < jmlTitik; i++) {
                hargaRP = "." + harga_ohne_titik.slice(posisi, akhir) + hargaRP;
                // console.log(hargaRP);
                akhir = posisi;
                posisi = akhir - 3;
            }
            hargaRP = harga_ohne_titik.slice(0, akhir) + hargaRP;
            return hargaRP;
        }

        function showConfirmDelete(button_id,element_id) {
            var deleteButton = document.getElementById(button_id);
            var confirmDelete = document.getElementById(element_id);

            deleteButton.classList.add('hidden');
            confirmDelete.classList.remove('hidden');
            confirmDelete.classList.add('flex');
        }

        function hideConfirmDelete(button_id,element_id) {
            var deleteButton = document.getElementById(button_id);
            var confirmDelete = document.getElementById(element_id);

            deleteButton.classList.remove('hidden');
            confirmDelete.classList.add('hidden');
            confirmDelete.classList.remove('flex');
        }

        function toggleFormPembelian() {
            var form_pembelian=document.getElementById('form-pembelian');
            var btn_input_pembelian=document.getElementById('btn-input-pembelian');
            if (form_pembelian.classList.contains('hidden')) {
                form_pembelian.classList.remove('hidden');
                btn_input_pembelian.classList.remove('text-emerald-500');
                btn_input_pembelian.classList.add('text-white');
                btn_input_pembelian.classList.add('bg-emerald-400');
            } else {
                form_pembelian.classList.add('hidden');
                btn_input_pembelian.classList.remove('bg-emerald-400');
                btn_input_pembelian.classList.remove('text-white');
                btn_input_pembelian.classList.add('text-emerald-500');
            }
        }
        // document.addEventListener('livewire:load', function () {
        //     // Your JS here.
        //     // toFormatCurrencyRp();
        // })
        function downloadExcel(id_table) {
            $(`#${id_table}`).table2excel({
                filename:`${id_table}.xls`
            });
        }
    </script>
    {{-- @push('scripts')
@endpush --}}
</div>
