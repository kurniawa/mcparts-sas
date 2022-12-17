<div>
    {{-- Do your work, then step back. --}}
        <h3>Pembelian</h3>
        <div class="container mx-auto">
            <form wire:submit|prevent="" class="p-2 rounded bg-white shadow drop-shadow">
                <div class="flex">
                    <div class="">
                        <label for="nama_barang">Nama Barang :</label>
                        <input class="input" type="text" wire:model="nama_barang">

                    </div>
                    <div class=" ml-3">
                        <label for="jenis_barang">Jenis Barang :</label>
                        <input class="input" type="text" wire:model="jenis_barang">

                    </div>
                    <div class=" ml-3">
                        <label for="jumlah">Jumlah :</label>
                        <input class="input" type="number" wire:model="jumlah">

                    </div>

                    <div class=" ml-3">
                        <label for="harga_pcs">Harga/pcs. :</label>
                        <input class="input" type="number" wire:model="harga_pcs">

                    </div>

                    <div class=" ml-3">
                        <label for="harga_total">Harga Total :</label>
                        <input class="input" type="number" wire:model="harga_total">

                    </div>

                </div>
            </form>

        </div>

</div>
