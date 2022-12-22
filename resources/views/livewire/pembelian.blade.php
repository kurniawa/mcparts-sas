<div class="p-5">
    {{-- Do your work, then step back. --}}
    <div>
        <button class="border border-emerald-500 text-emerald-500 rounded p-2 hover:bg-emerald-400 hover:text-white">+Input Pembelian</button>
        <button class="border border-indigo-400 text-indigo-400 rounded p-2 hover:bg-indigo-400 hover:text-white">Filter</button>
    </div>
    <div class="mt-3">
        <form wire:submit.prevent="addPembelian" class="p-2 rounded bg-white shadow drop-shadow">
            <div class="grid grid-cols-3 gap-1">
                <div class="">
                    <label for="nama_barang">Nama Barang :</label>
                    <input class="input" type="text" wire:model="pembelian.nama_barang">
                    @error('pembelian.nama_barang')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="jenis_barang">Jenis Barang :</label>
                    <input class="input" type="text" wire:model="pembelian.jenis_barang">
                </div>
                <div class="">
                    <label for="supplier">Supplier :</label>
                    <input class="input" type="text" wire:model="pembelian.supplier">
                </div>
            </div>
            <div class="grid grid-cols-4 gap-1 mt-2">
                <div class="">
                    <label for="jumlah">Jumlah :</label>
                    <input class="input" type="number" wire:model="pembelian.jumlah">
                    @error('pembelian.jumlah')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="harga_pcs">Harga/pcs. :</label>
                    <input class="input" type="number" wire:model="pembelian.harga_pcs">
                    @error('pembelian.harga_pcs')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="harga_total">Harga Total :</label>
                    <input class="input" type="number" wire:model="pembelian.harga_total">
                    @error('pembelian.harga_total')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="tanggal">Tanggal :</label>
                    <input class="input" type="datetime-local" step="any" wire:model="pembelian.tanggal">
                    @error('pembelian.tanggal')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-2 text-right">
                <button type="submit" class="btn-indigo rounded">Input Pembelian</button>
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
    <table class="table-nice w-full mt-3">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Barang</th>
                <th>Jenis Barang</th>
                <th>Supplier</th>
                <th>Jumlah</th>
                <th>Harga/pcs</th>
                <th>Harga Total</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembelians as $item)
                <tr>
                    <td>{{ date('d-m-Y',strtotime($item->created_at)) }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->jenis_barang }}</td>
                    <td>{{ $item->supplier }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td class="toFormatCurrencyRp">{{ $item->harga_pcs }}</td>
                    <td class="toFormatCurrencyRp">{{ $item->harga_total }}</td>
                    <td>
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
                            <button class="bg-yellow-400 text-white rounded p-1 hover:bg-yellow-500" onclick="hideConfirmDelete('deleteButton-{{ $item->id }}','confirmDelete-{{ $item->id }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        var toFormatCurrencyRp=document.querySelectorAll('.toFormatCurrencyRp');
        toFormatCurrencyRp.forEach(element => {
            // console.log('toFormatCurrencyRp');
            formatCurrencyRp(parseInt(element.textContent), element);
        });
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

        function formatHarga(harga) {
        // console.log(harga);
        harga_ohne_titik = harga.replace(".", "");
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
    }

    function showConfirmDelete(button_id,element_id) {
        var deleteButton = document.getElementById(button_id);
        var confirmDelete = document.getElementById(element_id);

        deleteButton.classList.add('hidden');
        confirmDelete.classList.remove('hidden')
    }

    function hideConfirmDelete(button_id,element_id) {
        var deleteButton = document.getElementById(button_id);
        var confirmDelete = document.getElementById(element_id);

        deleteButton.classList.remove('hidden');
        confirmDelete.classList.add('hidden')
    }
    </script>
</div>

