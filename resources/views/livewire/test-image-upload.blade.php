<div class="container mx-auto border p-7 mt-5 rounded shadow-xl">
    {{-- Do your work, then step back. --}}
    <p>Dibawah ini metode menggunakan classic php. Ga jalan kalo di Laravel, createimagetruecolor nya ga di ambil dari php.</p>
    <form action="{{ route('imageUploadDB') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image">
        <button type="submit" class="btn-indigo-sm rounded">Submit</button>
    </form>

    <div class="mt-5">
    <p>Di bawah ini menggunakan methode nya dari intervention image</p>
    <p>Ga bisa jalan karena dibilang Gd extension not supported for this php</p>
    <div>
        <img src="{{ $image_to_preview }}" id="image-preview" class="sm:w-56">
        {{-- <input type="file" name="image" id="input-image" accept="image/png, image/jpeg" onchange="previewImage(this.id,'image-preview')"> --}}
        <input type="file" wire:change="$emit('chooseImage')" name="image_to_preview" id="input-image" accept="image/png, image/jpeg">
        @error('image_to_preview')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <button wire:click="uploadImage" class="btn-indigo-sm rounded">Submit</button>
    </div>

    <script>
        Livewire.on('chooseImage', ()=>{
            let input_field=document.getElementById('input-image');
            let file=input_field.files[0];
            let reader=new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend=()=>{
                Livewire.emit('imagePreview', reader.result);
            }
        })
    </script>

    </div>
</div>
