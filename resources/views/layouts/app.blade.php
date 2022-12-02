<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title></title>
    <style>
        [x-cloak] {
            display: none;
        }
    </style>
    @livewireStyles()
    @livewireScripts()
</head>
<body>
    <nav class="w-full px-8 text-sm text-slate-500 bg-slate-100">
        <ul class="sm:flex sm:justify-between">
            <li class="">
                <a class="h-full flex items-center px-3 hover:bg-slate-200" href="{{ route('home') }}">
                    <span>Home</span>
                </a>
            </li>
            @auth
            <li class="py-3 px-3 hover:bg-slate-200 flex items-center relative" x-data="{open:false}" x-on:mouseover="open=true" x-on:mouseover.away="open=false">
                <span class="hover:cursor-pointer">Links</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-1 w-3 h-3 hover:cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
                <ul x-show="open" x-cloak class="absolute left-1/2 -translate-x-1/2 border rounded bg-white top-12 z-50">
                    <li><a class="py-2 pl-2 pr-8 block hover:bg-indigo-50" href="">SPK</a></li>
                    <li><a class="py-2 pl-2 pr-8 block hover:bg-indigo-50" href="">Nota</a></li>
                    <li><a class="py-2 pl-2 pr-8 block hover:bg-indigo-50" href="">Sr.Jalan</a></li>
                    <li><a class="py-2 pl-2 pr-8 block hover:bg-indigo-50" href="">Penjualan</a></li>
                    <li><a class="py-2 pl-2 pr-8 block hover:bg-indigo-50" href="">Pembelian</a></li>
                </ul>
            </li>
            @endauth
            @guest
            <div class="flex">
                <li class="py-3"><a class="p-3 hover:bg-slate-200" href="{{ route('login') }}">Login</a></li>
                <li class="py-3"><a class="p-3 hover:bg-slate-200" href="{{ route('register') }}">Register</a></li>
            </div>
            @endguest
            @auth
            <div class="flex">
                <li class="py-3 px-3 hover:bg-slate-200 flex items-center relative" x-data="{open:false}" x-on:mouseover="open=true" x-on:mouseover.away="open=false">
                    <div class="w-8 h-8 rounded-full bg-orange-300 overflow-hidden">
                        @if (Auth::user()->profile_picture)
                        <img src="{{ asset("storage/" . Auth::user()->profile_picture) }}" alt="">
                        @else
                        <img class="w-full" src="{{ asset("storage/images/icons/superhero.png") }}" alt="">
                        @endif
                    </div>
                    <span class="hover:cursor-pointer ml-1">{{ Auth::user()->username }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-1 w-3 h-3 hover:cursor-pointer">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                    <ul x-show="open" x-cloak class="absolute left-1/2 -translate-x-1/2 border rounded bg-white top-12 z-50">
                        <li><a class="py-2 pl-2 pr-9 block hover:bg-indigo-50" href="{{ route('dashboard') }}">Profile</a></li>
                        <li><a class="py-2 pl-2 pr-9 block hover:bg-indigo-50" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </li>
            </div>
            @endauth
        </ul>
    </nav>
    {{-- @yield('content') --}}
    <main>
        {{ $slot }}

    </main>
    <div class="h-56"></div>
    @php
        // dump(Request::is('login'));
        // dump(Auth::user());
    @endphp
</body>
</html>