<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="text-2xl">
                        Welcome to Repair Cafe Leighton Buzzard!
                    </div>
                    <div class="mt-6 text-gray-500">
                        Everything you need to know about how to join in with our upcoming events, either to get help with your broken items or to join in and help.
                    </div>
                </div>

                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">

                    <div class="p-6">
                        <div class="flex items-center">
                            <i class="text-gray-500 text-3xl far fa-calendar-days"></i>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a
                                    href="{{ route('events') }}">Events</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                Get all the details of upcoming Repair Cafe events
                            </div>

                            <a href="{{ route('events') }}">
                                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                    <div>View the diary</div>
                                    <div class="ml-1 text-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            <i class="text-gray-500 text-3xl fas fa-heart-crack"></i>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="#">My
                                    Items</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                Register the details of a broken item that you'd like to bring to a Repair Cafe event
                            </div>

                            <a href="#">
                                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                    <div>Manage Items</div>
                                    <div class="ml-1 text-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200">
                        <div class="flex items-center">
                            <i class="text-gray-500 text-3xl fas fa-stopwatch"></i>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="#">Repair
                                    Stats</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                You'll be able to find out how we're doing in our effort to reduce waste
                                and help the community
                            </div>
                            <div class="mt-2 font-light text-gray-400">Coming soon!</div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-l">
                        <div class="flex items-center">
                            <i class="text-gray-500 text-3xl fas fa-wrench"></i>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="#">Become a
                                    Volunteer</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-sm text-gray-500">
                                <p>If you can spare some time to help out, we need volunteers to help out at Repair Cafe
                                    events, and if you have any repair skills, please do consider becoming one of our
                                    invaluable fixers!</a>
                            </div>
                            <a href="/user/profile">
                                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                    <div>Volunteer</div>
                                    <div class="ml-1 text-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
