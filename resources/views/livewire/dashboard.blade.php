<div class="container mx-auto sm:w-3/4 relative" x-data={open_choose_photo:false}>
    <div class="text-center">
        <span class="text-sm text-slate-500 mt-5 block">"If you look to others for fulfillment, you will never truly be fulfilled."</span>
    </div>

    <div class="flex mt-5">
        {{-- Container Profile Picture --}}
        <div>
            @if ($profile_picture)
            <div class="sm:w-56 sm:h-56 relative">
                <div class="rounded-full overflow-hidden bg-orange-100">
                    <img class="w-full" src="{{ asset("storage/$profile_picture") }}">
                </div>
                <label x-on:click="open_choose_photo=true" class="absolute right-0 bottom-0 hover:cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-slate-500 ml-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </label>
            </div>
            @else
            <div class="sm:w-56 sm:h-56 relative">
                <div class="rounded-full overflow-hidden bg-orange-100">
                    <a href="https://www.flaticon.com/free-icons/superhero" title="superhero icons" target="_blank" rel="noopener noreferrer">
                        <img class="w-full" src="{{ asset('storage/images/icons/superhero.png') }}" alt="">
                    </a>
                </div>
                <label x-on:click="open_choose_photo=true" class="absolute right-0 bottom-0 hover:cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-slate-500 ml-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </label>
            </div>
            @endif
            {{-- <div class="text-xs text-center">
                Superhero icons created by Freepik - Flaticon
            </div> --}}
        </div>

        <div class="grow ml-16">
            {{-- Container Nama --}}
            <form wire:submit.prevent="updateNama" x-data="{open:false}" class="sm:w-full p-5 border rounded border-slate-300 bg-white shadow-xl max-w-sm">
                <h3 class="text-slate-600">Nama</h3>
                <div class="flex items-center">
                    <div class="w-full">
                        <input type="text" name="nama" id="nama" class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;" wire:model="user.nama">
                        @error('user.nama')
                        <div class="w-full px-2 py-1 rounded text-pink-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <svg x-on:click="open=!open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-500 ml-1 hover:cursor-pointer">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </div>
                <div class="mt-2">
                    @if (session()->has('nama_updated'))
                    <div class="font-semibold w-full px-3 py-2 rounded bg-emerald-200 text-emerald-600 opacity-70">
                        {{ session('nama_updated') }}
                    </div>
                    @endif
                </div>
                <div x-show="open" x-transition x-cloak class="text-right mt-5">
                    <button
                    class="rounded px-3 py-2 text-xs font-semibold bg-blue-500 text-white hover:bg-blue-600 active:bg-blue-700 focus:ring focus:ring-blue-300">
                        Confirm
                    </button>
                </div>

            </form>

            {{-- Container Username --}}
            <form wire:submit.prevent="updateUsername" x-data="{open:false}" class="mt-5 sm:w-full p-5 border rounded border-slate-300 bg-white shadow-xl max-w-sm">
                <h3 class="text-slate-600">Username</h3>
                <div class="flex items-center">
                    <input type="text" name="username" id="username" class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;" wire:model="user.username">
                    <svg x-on:click="open=!open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-500 ml-1 hover:cursor-pointer">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </div>
                <div class="mt-2">
                    @if (session()->has('username_updated'))
                    <div class="font-semibold w-full px-3 py-2 rounded bg-emerald-200 text-emerald-600 opacity-70">
                        {{ session('username_updated') }}
                    </div>
                    @endif
                </div>
                <div x-show="open" x-transition x-cloak class="text-right mt-5">
                    <button
                    class="rounded px-3 py-2 text-xs font-semibold bg-blue-500 text-white hover:bg-blue-600 active:bg-blue-700 focus:ring focus:ring-blue-300">
                        Confirm
                    </button>
                </div>
            </form>

            {{-- Container Password --}}
            <form wire:submit.prevent="updatePassword" x-data="{open:false}" class="mt-5 sm:w-full p-5 border rounded border-slate-300 bg-white shadow-xl max-w-sm">
                <h3 class="text-slate-600">Password</h3>
                <label for="current_password" class="text-slate-600">Current Password :</label>
                <input wire:model="current_password" type="password" name="current_password" id="current_password" placeholder="Current Password"
                class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;"
                >
                @error('current_password')
                <div class="w-full px-2 py-1 rounded text-pink-600">{{ $message }}</div>
                @enderror
                <label for="new_password" class="text-slate-600 block mt-2">New Password :</label>
                <input wire:model="new_password" type="password" name="new_password" id="new_password" placeholder="New Password"
                class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;">
                @error('new_password')
                <div class="w-full px-2 py-1 rounded text-pink-600">{{ $message }}</div>
                @enderror
                <label for="confirm_new_password" class="text-slate-600 block mt-2">Confirm New Password :</label>
                <input wire:model="confirm_new_password" type="password" name="confirm_new_password" id="confirm_new_password" placeholder="Confirm New Password"
                class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;">
                @error('confirm_new_password')
                <div class="w-full px-2 py-1 rounded text-pink-600">{{ $message }}</div>
                @enderror

                <div class="mt-2">
                    @if (session()->has('password_updated'))
                    <div class="font-semibold w-full px-3 py-2 rounded bg-emerald-200 text-emerald-600 opacity-70">
                        {{ session('password_updated') }}
                    </div>
                    @endif
                    @if (session()->has('password_errors'))
                    <div class="font-semibold w-full px-3 py-2 rounded bg-red-200 text-red-600 opacity-70">
                        {{ session('password_errors') }}
                    </div>
                    @endif
                </div>

                <div class="text-right mt-2">
                    <button
                    class="rounded px-3 py-2 text-xs font-semibold bg-blue-500 text-white hover:bg-blue-600 active:bg-blue-700 focus:ring focus:ring-blue-300">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Hidden Element At The Beginning: Element For Edit Profile Picture --}}
    <div x-show="open_choose_photo" x-cloak class="absolute bg-white top-5 left-1/2 -translate-x-1/2 sm:w-4/5 p-5 border rounded shadow-xl">
        {{-- Tombol Close --}}
        <div x-on:click="open_choose_photo=false" class="absolute bg-pink-100 w-6 h-6 rounded-full -right-4 -top-4 text-center hover:cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-4 h-4 text-pink-600 inline-block">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>

        <form wire:submit.prevent="savePhoto" class="mt-3 text-center">
            {{-- Bingkai Foto --}}
            @if ($photo)
            <div class="sm:w-80 sm:h-80 rounded-full overflow-hidden mx-auto bg-orange-100">
                <img class="w-full" src="{{ $photo->temporaryUrl() }}">
            </div>
            @elseif ($profile_picture)
            <div class="sm:w-80 sm:h-80 rounded-full overflow-hidden mx-auto bg-orange-100">
                <img class="w-full" src="{{ asset("storage/$profile_picture") }}">
            </div>
            @else
            <div class="sm:w-80 sm:h-80 rounded-full overflow-hidden mx-auto bg-orange-100">
                <a href="https://www.flaticon.com/free-icons/superhero" title="superhero icons" target="_blank" rel="noopener noreferrer">
                    <img class="w-full" src="{{ asset('storage/images/icons/superhero.png') }}" alt="">
                </a>
            </div>
            @endif
            {{-- <div class="text-xs text-center">
                Superhero icons created by Freepik - Flaticon
            </div> --}}
            <div class="mt-5">
                <div
                    x-data="{ isUploading: false, progress: 0 }"
                    x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false"
                    x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                >

                {{-- <div @click="$refs.choose_photo.click()">Upload Image</div> --}}
                <input x-ref="choose_photo" type="file" wire:model="photo" class="">
                <div x-show="isUploading">
                    <progress max="100" x-bind:value="progress"></progress>
                </div>
                <div wire:loading wire:target="photo">Uploading...</div>
                <div wire:loading wire:target="save">Storing to local...</div>
            </div>

            @error('photo') <div class="w-full px-2 py-1 rounded text-pink-600">{{ $message }}</div> @enderror
            <div class="mt-3">
                @if (session()->has('save_photo_logs'))
                <div class="font-semibold w-full px-3 py-2 rounded bg-emerald-200 text-emerald-600 opacity-70">{{ session('save_photo_logs') }}</div>
                @endif
                @if (session()->has('delete_photo_logs'))
                <div class="font-semibold w-full px-3 py-2 rounded bg-red-200 text-red-600 opacity-70">{{ session('delete_photo_logs') }}</div>
                @endif
            </div>
            <div class="mt-3">
                <button class="rounded px-3 py-2 text-xs font-semibold bg-blue-500 text-white hover:bg-blue-600 active:bg-blue-700 focus:ring focus:ring-blue-300" type="submit">Save Photo</button>
            </div>
        </form>
        <button onclick="confirm('Anda yakin ingin menghapus profile picture ini?') || event.stopImmediatePropagation()" wire:click="deletePhoto" class="px-2 py-1 font-semibold text-xs bg-pink-500 text-white hover:bg-pink-600 active:bg-pink-700 focus:ring focus:ring-pink-300 rounded mt-1">Delete</button>
    </div>
    <script>
        // Livewire.on('chooseImage', ()=>{
        //     let input_field=document.getElementById('input-image');
        //     let file=input_field.files[0];
        //     let reader=new FileReader();
        //     reader.readAsDataURL(file);
        //     reader.onloadend=()=>{
        //         Livewire.emit('imagePreview', reader.result);
        //     }
        // })
        // function previewImage(input_id, image_preview_id) {
        //     let input_image = document.getElementById(input_id);
        //     let preview_image=document.getElementById(image_preview_id);
        //     const blob=URL.createObjectURL(input_image.files[0]);
        //     // preview_image.src=blob;
        //     Livewire.emit('imagePreview', blob);
        // }
    </script>

    {{-- <div class="mt-5">
        <button wire:click="cleanupOldTemp" class="btn-danger-sm rounded">Testing Delete Livewire Temp Files</button>
    </div> --}}
</div>

