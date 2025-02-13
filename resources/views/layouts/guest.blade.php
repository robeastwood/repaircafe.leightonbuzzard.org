<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="shortcut icon" href="./img/favicon.ico" />
    <link rel="apple-touch-icon" sizes="76x76" href="./img/apple-icon.png" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <!-- <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"> -->

    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body>
    <div class="text-gray-800 antialiased flex flex-col h-screen justify-between">

        <nav class="top-0 absolute z-50 w-full px-2 py-3">
            <div class="container px-4 mx-auto flex flex-row-reverse">
                <ul class="flex">
                    @auth
                        <li class="flex items-center">
                            <a href="{{ route('dashboard') }}"
                                class="bg-white text-gray-800 active:bg-gray-100 text-xs font-bold uppercase px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-3"
                                type="button" style="transition: all 0.15s ease 0s">
                                <i class="fas fa-wrench"></i>
                                Dashboard
                            </a>
                        </li>
                    @else
                        <li class="flex items-center">
                            <a href="{{ route('login') }}"
                                class="bg-white text-gray-800 active:bg-gray-100 text-xs font-bold uppercase px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-3"
                                type="button" style="transition: all 0.15s ease 0s">
                                <i class="fas fa-key"></i>
                                Log In
                            </a>
                        </li>
                        <li class="flex items-center">
                            <a href="{{ route('register') }}"
                                class="bg-white text-gray-800 active:bg-gray-100 text-xs font-bold uppercase px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-3"
                                type="button" style="transition: all 0.15s ease 0s">
                                <i class="fas fa-pen-to-square"></i>
                                Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>

        <nav class="hidden top-0 absolute z-50 w-full flex flex-wrap items-center justify-between px-2 py-3">
            <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">

                <div class="w-full relative flex justify-between lg:w-auto lg:static lg:block lg:justify-start">
                    <!-- <a
                            class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase text-grey-800"
                            href="/"
                        >
                            Home
                        </a> -->
                    <button
                        class="cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none"
                        type="button" onclick="toggleNavbar('example-collapse-navbar')">
                        <i class="text-white fas fa-bars"></i>
                    </button>
                </div>
                <div class="lg:flex flex-grow items-center bg-white lg:bg-transparent lg:shadow-none hidden"
                    id="example-collapse-navbar">
                    <ul class="flex flex-col lg:flex-row list-none mr-auto">
                        <li class="flex items-center">
                            <a class="hover:text-gray-300 text-gray-500 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold"
                                href="/"><i class="fas fa-house text-lg leading-lg mr-2"></i>
                                Home
                            </a>
                        </li>
                        <li class="flex items-center">
                            <a class="hover:text-gray-300 text-gray-500 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold"
                                href="/"><i class="fas fa-calendar text-lg leading-lg mr-2"></i>
                                Event Diary
                            </a>
                        </li>
                    </ul>
                    <ul class="flex flex-col lg:flex-row list-none lg:ml-auto">
                        @auth
                            <li class="flex items-center">
                                <a href="{{ route('dashboard') }}"
                                    class="bg-white text-gray-800 active:bg-gray-100 text-xs font-bold uppercase px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-3"
                                    type="button" style="transition: all 0.15s ease 0s">
                                    <i class="fas fa-wrench"></i>
                                    Dashboard
                                </a>
                            </li>
                        @else
                            <li class="flex items-center">
                                <a href="{{ route('login') }}"
                                    class="bg-white text-gray-800 active:bg-gray-100 text-xs font-bold uppercase px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-3"
                                    type="button" style="transition: all 0.15s ease 0s">
                                    <i class="fas fa-key"></i>
                                    Log In
                                </a>
                            </li>
                            <li class="flex items-center">
                                <a href="{{ route('register') }}"
                                    class="bg-white text-gray-800 active:bg-gray-100 text-xs font-bold uppercase px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-3"
                                    type="button" style="transition: all 0.15s ease 0s">
                                    <i class="fas fa-pen-to-square"></i>
                                    Register
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
        <main>
            {{ $slot }}
        </main>
        @include('partials.footer')
    </div>

    @livewireScripts
    @vite('resources/js/app.js')
    <script>
        function toggleNavbar(collapseID) {
            document.getElementById(collapseID).classList.toggle("hidden");
            document.getElementById(collapseID).classList.toggle("block");
        }
    </script>
</body>

</html>
