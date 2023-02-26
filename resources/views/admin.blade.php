<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Control Panel') }}
        </h2>
    </x-slot>
    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 md:px-8">
            <section class="px-4 mx-auto">
                <h2 class="text-lg font-medium text-gray-800">Categories</h2>
                <div class="flex flex-col mt-6">
                    <div class="-mx-4 -my-2 sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="border border-gray-200 dark:border-gray-700">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                Category
                                            </th>

                                            <th scope="col"
                                                class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                Description
                                            </th>

                                            <th scope="col" class="px-1 relative py-3.5 ">
                                                <span class="sr-only">Manage</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                                    <div>
                                                        <h2 class="font-medium text-gray-800 dark:text-white ">
                                                            {{ $category->name }}</h2>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-sm font-medium">
                                                    <div>
                                                        <h2 class="font-medium text-gray-800 dark:text-white ">
                                                            {{ $category->description }}</h2>
                                                    </div>
                                                </td>
                                                <td class="px-1 py-4 text-sm whitespace-nowrap text-right">
                                                    <div x-data="{ isOpen: false }" class="relative inline-block">
                                                        <!-- Dropdown toggle button -->
                                                        <button @click="isOpen = !isOpen"
                                                            class="px-1 py-1 text-gray-500 transition-colors duration-200 rounded-lg dark:text-gray-300 hover:bg-gray-100">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                            </svg>
                                                        </button>

                                                        <!-- Dropdown menu -->
                                                        <div x-show="isOpen" @click.away="isOpen = false"
                                                            x-transition:enter="transition ease-out duration-100"
                                                            x-transition:enter-start="opacity-0 scale-90"
                                                            x-transition:enter-end="opacity-100 scale-100"
                                                            x-transition:leave="transition ease-in duration-100"
                                                            x-transition:leave-start="opacity-100 scale-100"
                                                            x-transition:leave-end="opacity-0 scale-90"
                                                            class="absolute right-0 z-20 w-48 py-2 mt-2 origin-top-right bg-white rounded-md shadow-xl dark:bg-gray-800">
                                                            <a href="#"
                                                                class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                                                Edit</a>
                                                            <a href="#"
                                                                class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                                                Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>


        <div class="max-w-7xl mx-auto sm:px-6 md:px-8 mt-4">
            <section class="px-4 mx-auto">
                <h2 class="text-lg font-medium text-gray-800">Skills</h2>
                <div class="flex flex-col mt-6">
                    <div class="-mx-4 -my-2 sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="border border-gray-200 dark:border-gray-700">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                Skill
                                            </th>

                                            <th scope="col"
                                                class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                Description
                                            </th>

                                            <th scope="col" class="px-1 relative py-3.5 ">
                                                <span class="sr-only">Manage</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                        @foreach ($skills as $skill)
                                            <tr>
                                                <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                                    <div>
                                                        <h2 class="font-medium text-gray-800 dark:text-white ">
                                                            {{ $skill->name }}</h2>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-sm font-medium">
                                                    <div>
                                                        <h2 class="font-medium text-gray-800 dark:text-white ">
                                                            {{ $skill->description }}</h2>
                                                    </div>
                                                </td>
                                                <td class="px-1 py-4 text-sm whitespace-nowrap text-right">
                                                    <div x-data="{ isOpen: false }" class="relative inline-block">
                                                        <!-- Dropdown toggle button -->
                                                        <button @click="isOpen = !isOpen"
                                                            class="px-1 py-1 text-gray-500 transition-colors duration-200 rounded-lg dark:text-gray-300 hover:bg-gray-100">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                            </svg>
                                                        </button>

                                                        <!-- Dropdown menu -->
                                                        <div x-show="isOpen" @click.away="isOpen = false"
                                                            x-transition:enter="transition ease-out duration-100"
                                                            x-transition:enter-start="opacity-0 scale-90"
                                                            x-transition:enter-end="opacity-100 scale-100"
                                                            x-transition:leave="transition ease-in duration-100"
                                                            x-transition:leave-start="opacity-100 scale-100"
                                                            x-transition:leave-end="opacity-0 scale-90"
                                                            class="absolute right-0 z-20 w-48 py-2 mt-2 origin-top-right bg-white rounded-md shadow-xl dark:bg-gray-800">
                                                            <a href="#"
                                                                class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                                                Edit</a>
                                                            <a href="#"
                                                                class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                                                Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 md:px-8 mt-4">
            <section class="px-4 mx-auto">
                <h2 class="text-lg font-medium text-gray-800">Users</h2>
                <p class="mt-1 text-sm text-gray-500">Registered Users</p>
                <div class="flex flex-col mt-6">
                    <div class="-mx-4 -my-2 sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="border border-gray-200 dark:border-gray-700">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                Name & Email
                                            </th>

                                            <th scope="col"
                                                class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                Status
                                            </th>

                                            <th scope="col"
                                                class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                Activity
                                            </th>

                                            <th scope="col" class="relative py-3.5 px-4">
                                                <span class="sr-only">Manage</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                        @foreach ($users as $user)
                                            <tr>
                                                <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                                    <div>
                                                        <h2 class="font-medium text-gray-800 dark:text-white ">
                                                            {{ $user->name }}</h2>
                                                        <p class="text-sm font-normal text-gray-600 dark:text-gray-400">
                                                            {{ $user->email }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                                                    @if ($user->is_admin)
                                                        <div
                                                            class="inline px-3 py-1 text-sm font-normal rounded-full text-blue-500 gap-x-2 bg-blue-100/60 dark:bg-blue-800">
                                                            Admin
                                                        </div>
                                                    @endif
                                                    @if ($user->volunteer)
                                                        <div
                                                            class="inline px-3 py-1 text-sm font-normal rounded-full text-green-500 gap-x-2 bg-green-100/60 dark:bg-green-800">
                                                            Volunteer
                                                        </div>
                                                    @else
                                                        <div
                                                            class="inline px-3 py-1 text-sm font-normal rounded-full text-gray-500 gap-x-2 bg-gray-100/60 dark:bg-gray-800">
                                                            Guest
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                                    <div>
                                                        <p class="text-gray-500 dark:text-gray-400">Items: ?</p>
                                                        <h4 class="text-gray-700 dark:text-gray-200">Fixes: ?</h4>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-sm whitespace-nowrap text-right">
                                                    <button
                                                        class="px-1 py-1 text-gray-500 transition-colors duration-200 rounded-lg dark:text-gray-300 hover:bg-gray-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>

    </div>
</x-app-layout>
