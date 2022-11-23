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
                <input type="text" id="username" class="input" wire:model='form.username'>
                @error('form.username')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-3">
                <label for="password">Password</label>
                <input type="password" id="password" class="input" wire:model='form.password'>
                @error('form.password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-3 text-center">
                <button class="rounded btn-primary" type="submit">Login</button>
            </div>
        </form>
    </div>
</div>
