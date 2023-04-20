<div>
    <x-jet-form-section submit="search" class='mt-4'>
        <x-slot name="title">
            {{ __('Search for Visitor') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Search for a visitor who is registered on the website already') }}
        </x-slot>

        <x-slot name="form">
            <!-- Search -->
            <div class="col-span-12 sm:col-span-12">
                <div>
                    <div class="col-span-6 sm:col-span-4">
                        <label class="block font-medium text-sm text-gray-700" for="search">
                            Search <x-jet-input-error for="search" class="mt-2 inline" />
                        </label>

                        <div class="flex items-center">
                            <input id="search" wire:model="search"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full
                                        mr-3 leading-tight focus:outline-none"
                                type="text" placeholder="Email, Name or Item ID" aria-label="search">
                            <button wire:click="$set('search', '')"
                                class="bg-gray-800 border border-transparent hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition text-sm text-white mt-1 p-2 rounded"
                                type="button">
                                Clear
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Search Results -->
            <div class="col-span-12 sm:col-span-12">
                @foreach ($searchResults as $result)
                    <button wire:click="selectUser({{ $result->id }})"
                        class="bg-gray-800 border border-transparent hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition text-sm text-white mt-1 p-2 rounded"
                        type="button">
                        {{ $result->name }} ({{ $result->email }})
                    </button>
                @endforeach
            </div>
        </x-slot>
    </x-jet-form-section>

    @if (!$user)
        <x-jet-form-section submit="userDetails" class='mt-4'>
            <x-slot name="title">
                {{ __('Register New User') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Register the details of a new visitor') }}
            </x-slot>

            <x-slot name="form">
                <!-- Email -->
                <div class="col-span-12 sm:col-span-12">
                    <div>
                        <div class="col-span-6 sm:col-span-4">
                            <label class="block font-medium text-sm text-gray-700" for="email">
                                Email address <x-jet-input-error for="email" class="mt-2 inline" />
                            </label>

                            <div class="flex items-center">
                                <input id="email" wire:model="email"
                                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full
                                        mr-3 leading-tight focus:outline-none"
                                    type="text" placeholder="Email address" aria-label="Email address">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Name -->
                <div class="col-span-12 sm:col-span-12">
                    <label class="block font-medium text-sm text-gray-700" for="name">
                        {{ $user ? __('Found Existing User') : __('Name (Visible to registered users)') }}
                        <x-jet-input-error for="name" class="mt-2 inline" />
                    </label>
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="name"
                        :disabled="$user" autocomplete="name" placeholder="Name" />
                </div>
            </x-slot>
        </x-jet-form-section>
    @endif

    @if ($user)
        <div class='md:grid md:grid-cols-3 md:gap-6 mt-4'>
            <x-jet-section-title>
                <x-slot name="title">{{ $user->name . __('\'s Items') }}</x-slot>
                <x-slot name="description">{{ __('Check in the items they have brought') }}</x-slot>
            </x-jet-section-title>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="py-1 bg-white shadow">
                    @foreach ($user->items as $item)
                        <div class="rounded bg-gray-100 shadow-md p-2 m-4">
                            <div class='flex justify-between content-center'>
                                <div>
                                    <h1 class="font-medium">
                                        <a href="{{ route('item', $item->id) }}" class="hover:underline">Item ID:
                                            {{ $item->id }}</a>
                                    </h1>
                                    <p class="text-sm">{{ $item->description }}</p>
                                </div>
                                <div>
                                    @if ($item->checkedin->contains($event->id))
                                        <x-jet-button class="bg-green-600 hover:bg-green-400"
                                            wire:click="checkin({{ $item }},0)">Checked In</x-jet-button>
                                    @else
                                        <x-jet-button class="" wire:click="checkin({{ $item }},1)">Check
                                            In</x-jet-button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <x-jet-form-section submit="createItem" class="mt-4">
        <x-slot name="title">
            {{ __('Check-In a new Item') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Use this section if the visitor has brought an item that they have not yet registered on the website') }}
        </x-slot>

        <x-slot name="form">
            <!-- Category -->
            <div class="col-span-12 sm:col-span-12">
                <div>
                    <div class="col-span-6 sm:col-span-4">
                        <label class="block font-medium text-sm text-gray-700" for="newItem-category">
                            Category
                        </label>
                        <select id="newItem-category" wire:model.lazy="newItem.category"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                            <option value="null" selected>Select a category</option>
                            @foreach (\App\Models\Category::all() as $category)
                                <option value={{ $category->id }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="newItem.category" class="mt-2" />
                    </div>
                </div>
            </div>
            <!-- Description -->
            <div class="col-span-12 sm:col-span-12">
                <x-jet-label for="newItem-description" value="{{ __('Description') }}" />
                <x-jet-input id="newItem-description" type="text" class="mt-1 block w-full"
                    wire:model="newItem.description" placeholder="Description" />
                <x-jet-input-error for="newItem.description" class="mt-2" />
            </div>
            <!-- Issue -->
            <div class="col-span-12 sm:col-span-12">
                <x-jet-label for="newItem-issue" value="{{ __('Issue') }}" />
                <textarea id="newItem-issue" wire:model.defer="newItem.issue" rows="4" placeholder="Issue description"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"></textarea>
                <x-jet-input-error for="newItem.issue" class="mt-2" />
            </div>

            <!-- Powered -->
            <div class="col-span-12 sm:col-span-12">
                <div>
                    <div class="col-span-6 sm:col-span-4">
                        <label class="block font-medium text-sm text-gray-700" for="newItem-powered">
                            Powered
                        </label>
                        <select id="newItem-powered" wire:model.defer="newItem.powered"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                            <option value="null" selected>Select an option</option>
                            @foreach (\App\Models\Item::powerOptions() as $powerOption)
                                <option value={{ $powerOption }}>{{ ucfirst($powerOption) }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="newItem.powered" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="col-span-12 sm:col-span-12">
                <div>
                    <div class="col-span-6 sm:col-span-4">
                        <label class="block font-medium text-sm text-gray-700" for="newItem-status">
                            Status
                        </label>
                        <select id="newItem-status" wire:model.defer="newItem.status"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                            @foreach (\App\Models\Item::statusOptions() as $option => $details)
                                <option value={{ $option }}>{{ $details['display'] }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="newItem.status" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Disclaimer -->
            <div class="col-span-12 sm:col-span-12">
                <p class="text-sm text-gray-600 mt-6">
                    Please confirm that the visitor has read and agrees to the <a href="/repair-disclaimer"
                        target="_blank" rel="noopener noreferrer"
                        class="text-blue-600 dark:text-blue-500 hover:underline">Repair
                        Disclaimer</a> and the <a href="/healt-and-safety" target="_blank" rel="noopener noreferrer"
                        class="text-blue-600 dark:text-blue-500 hover:underline">Health &amp; Safety Policy</a>,
                    and understands that the item will only be fixed on a best-efforts basis, subject to assessment and
                    availability, and they accept the risks involved in any attempted repair process.
                </p>
                <div class="text-gray-600 mt-2 mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                    <input wire:model.defer="newItem.disclaimer" value="true"
                        class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-[rgba(0,0,0,0.25)] bg-white outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:bg-white focus:after:content-[''] checked:focus:border-primary checked:focus:bg-primary checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                        type="checkbox" value="" id="newItem-disclaimer" />
                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer min-w-max" for="newItem-disclaimer">
                        Visitor has read &amp; agreed
                    </label>
                </div>
                <x-jet-input-error for="newItem.disclaimer" class="mt-2" />
            </div>

        </x-slot>
        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="itemAdded">
                {{ __('Checked in new Item.') }}
            </x-jet-action-message>

            <x-jet-button wire:loading.attr="disabled">
                {{ __('Add Item') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

</div>
