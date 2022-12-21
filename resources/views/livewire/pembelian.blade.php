<div class="p-5">
    {{-- Do your work, then step back. --}}
        <h3 class="">Pembelian</h3>
        <div class="mt-3">
            <form wire:submit.prevent="inputPembelian" class="p-2 rounded bg-white shadow drop-shadow">
                <div class="grid grid-cols-3 gap-1">
                    <div class="">
                        <label for="nama_barang">Nama Barang :</label>
                        <input class="input" type="text" wire:model="nama_barang">
                        @error('nama_barang')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="">
                        <label for="jenis_barang">Jenis Barang :</label>
                        <input class="input" type="text" wire:model="jenis_barang">
                    </div>
                    <div class="">
                        <label for="supplier">Supplier :</label>
                        <input class="input" type="text" wire:model="supplier">
                    </div>
                </div>
                <div class="grid grid-cols-4 gap-1 mt-2">
                    <div class="">
                        <label for="jumlah">Jumlah :</label>
                        <input class="input" type="number" wire:model="jumlah">
                    </div>
                    <div class="">
                        <label for="harga_pcs">Harga/pcs. :</label>
                        <input class="input" type="number" wire:model="harga_pcs">
                    </div>
                    <div class="">
                        <label for="harga_total">Harga Total :</label>
                        <input class="input" type="number" wire:model="harga_total">
                    </div>
                    <div class="">
                        <label for="tanggal">Tanggal :</label>
                        <input class="input" type="datetime-local" step="any" wire:model="tanggal">
                    </div>
                </div>
                <div class="mt-2 text-right">
                    <button type="submit" class="btn-indigo rounded">Input Pembelian</button>
                </div>
            </form>
        </div>
</div>
