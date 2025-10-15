<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="bg-[#FDFDFC] text-[#1b1b18]">

        <!-- Header -->
        <header class="w-full absolute top-0 left-0 z-10 p-4 flex justify-end">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 bg-white border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                        @if (Auth::user()->can('access-admin-panel'))
                            <a
                                href="{{ url('/admin') }}"
                                class="inline-block px-5 py-1.5 bg-white border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                            >
                                Admin
                            </a>
                        @endif
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 bg-white text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 bg-white border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <!-- Main Content -->
        {{ $slot }}

        <!-- Footer -->
        <footer class="relative bg-gray-300 mt-12 pt-8 pb-6">
            <div class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20"
                style="height: 80px;">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg"
                    preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="text-gray-300 fill-current" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap">
                    <div class="w-full md:w-6/12 px-4">
                        <h4 class="text-3xl font-semibold">Let's keep in touch!</h4>
                        <h5 class="text-lg mt-0 mb-2 text-gray-700">
                            Find us on social media.
                        </h5>
                        <div class="mt-6 flex">
                            <a href="https://www.facebook.com/groups/repaircafelb"
                                class="bg-white text-blue-600 shadow-lg font-normal h-10 w-10 flex items-center justify-center rounded-full outline-none focus:outline-none mr-2"
                                type="button">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </div>
                    </div>
                    <div class="w-full md:w-6/12 px-4">
                        <div class="flex flex-wrap items-top mb-6">
                            <div class="w-full md:w-6/12 px-4 ml-auto">
                                <span class="block uppercase text-gray-600 text-sm font-semibold mb-2">Find out more</span>
                                <ul class="list-unstyled [&>li>a]:text-gray-700 [&>li>a]:hover:text-gray-900 [&>li>a]:font-semibold [&>li>a]:block [&>li>a]:pb-2 [&>li>a]:text-sm">
                                    <li><a href="{{ route('policies') }}">Policies</a></li>
                                    <li><a href="{{ route('repair-disclaimer') }}">Repair Disclaimer</a></li>
                                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                    <li><a href="{{ route('more-information') }}">More Information</a></li>
                                </ul>
                            </div>
                            <div class="w-full md:w-6/12 px-4">
                                <span class="block uppercase text-gray-600 text-sm font-semibold mb-2">Helpful Links</span>
                                <ul class="list-unstyled [&>li>a]:text-gray-700 [&>li>a]:hover:text-gray-900 [&>li>a]:font-semibold [&>li>a]:block [&>li>a]:pb-2 [&>li>a]:text-sm">
                                    <li><a href="https://totallylb.wordpress.com">Totally Leighton Buzzard</a></li>
                                    <li><a href="https://www.repaircafe.org/en/">Repair Cafe movement</a></li>
                                    <li><a href="https://restarters.net/group/view/821">Restarters group</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </body>
</html>
