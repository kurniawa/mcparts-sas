<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>MC-Parts SAS</title>
    <style>
        [x-cloak] {
            display: none;
        }
    </style>
    @livewireStyles()
    @livewireScripts()
</head>
<body class="text-slate-600 text-sm">
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
                    <li><a class="py-2 pl-2 pr-8 block hover:bg-indigo-50" href="{{ route('pembelian') }}">Pembelian</a></li>
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
    <div class="flex">
        @auth
            <div>
                <div class="h-28 bg-indigo-100"></div>
                <nav class="w-44 h-screen bg-indigo-100">
                    <ul class="font-semibold">
                        <li>
                            <a class="block py-4 pl-2 pr-8 hover:bg-indigo-50 border-b border-t border-indigo-200 flex items-center" href="">


                                <span>
                                    SPK

                                </span>
                            </a>
                        </li>
                        <li><a class="block py-4 pl-2 pr-8 hover:bg-indigo-50 border-b border-indigo-200" href="">Nota</a></li>
                        <li><a class="block py-4 pl-2 pr-8 hover:bg-indigo-50 border-b border-indigo-200" href="">Sr.Jalan</a></li>
                        <li><a class="block py-4 pl-2 pr-8 hover:bg-indigo-50 border-b border-indigo-200" href="">Penjualan</a></li>
                        <li>
                            <a class="block py-4 pl-2 pr-8 hover:bg-indigo-50 border-b border-indigo-200 flex items-center" href="{{ route('pembelian') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                  </svg>
                                <span class="ml-2">
                                    Pembelian

                                </span>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>
        @endauth
        <main class="w-full">
            {{ $slot }}

        </main>
        <div class="h-56"></div>

    </div>
    @php
        // dump(Request::is('login'));
        // dump(Auth::user());
    @endphp
</body>
</html>
