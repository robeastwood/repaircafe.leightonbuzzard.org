<div x-data>

    <x-jet-button type="button" wire:click="$set('showModal',true)">Add Event</x-jet-button>

    @if ($showModal)
        <x-form-modal wire:model.defer="showModal" title="Create Event" handler="createEvent">

            {{-- <p class="text-sm text-gray-600">
                Placeholder text block. With a <a href="/volunteer-policy" target="_blank" rel="noopener noreferrer"
                    class="text-blue-600 dark:text-blue-500 hover:underline">link</a> here.
            </p> --}}

            <div class="mt-3">
                <label class="block font-medium text-sm text-gray-700" for="venue">
                    Venue
                    @error('venue')
                        <span class="text-sm text-red-800">{{ $message }}</span>
                    @enderror
                </label>

                <select id="venue" wire:model="venue"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="null" disabled selected>Select a venue</option>
                    @foreach ($venues as $venue)
                        <option value={{ $venue->id }}>{{ $venue->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-3">
                <label class="block font-medium text-sm text-gray-700" for="date">
                    Date
                    @error('date')
                        <span class="text-sm text-red-800">{{ $message }}</span>
                    @enderror
                </label>
                <input id="date" type="date" wire:model="date"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" />
            </div>

            <div class="mt-3">
                <label class="block font-medium text-sm text-gray-700" for="startTime">
                    Start Time
                    @error('startTime')
                        <span class="text-sm text-red-800">{{ $message }}</span>
                    @enderror
                </label>
                <input id="startTime" type="time" wire:model="startTime"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" />
            </div>

            <div class="mt-3">
                <label class="block font-medium text-sm text-gray-700" for="endTime">
                    End Time
                    @error('endTime')
                        <span class="text-sm text-red-800">{{ $message }}</span>
                    @enderror
                </label>
                <input id="endTime" type="time" wire:model="endTime"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" />
            </div>

        </x-form-modal>
    @endif
</div>
