<div class="container mx-auto">
    {{-- Do your work, then step back. --}}
    <div class="px-2 mx-auto lg:w-3/12 md:w-4/12 mt-7">
        {{-- <x-server-feedback /> --}}
        "The Master doesn't talk, he acts."
        <form wire:submit.prevent='login()' class="p-5 border rounded border-slate-300">
            <div class="flex justify-center border-b pb-7">
                <h3 class="text-slate-700">Login</h3>
            </div>

            <div class="mt-3">
                <label for="username">Username</label>
                <input type="text" id="username" wire:model='form.username' class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;">
                @error('form.username')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-3">
                <label for="password">Password</label>
                <input type="password" id="password" wire:model='form.password' class="border border-slate-400 text-slate-700 shadow rounded w-full px-3 py-2 block placeholder:text-slate-400 focus:outline-none focus:border-none focus:ring-1 focus:ring-blue-500 invalid:text-pink-700 invalid:focus:ring-pink-700;">
                @error('form.password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-3 text-center">
                <button type="submit" class="rounded px-3 py-2 text-xs font-semibold bg-blue-500 text-white hover:bg-blue-600 active:bg-blue-700 focus:ring focus:ring-blue-300">Login</button>
            </div>
        </form>
    </div>
</div>
