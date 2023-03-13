<div x-data>

    <x-jet-button type="button" wire:click="$set('showModal',true)">Add Item</x-jet-button>

    @if ($showModal)
        <x-form-modal wire:model.defer="showModal" title="Create Item" handler="createItem">

            <div class="mt-3">
                <label class="block font-medium text-sm text-gray-700" for="category">
                    What sort of item is this?
                    @error('category')
                        <span class="text-sm text-red-800">{{ $message }}</span>
                    @enderror
                </label>

                <select id="category" wire:model="category"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="null" disabled selected>Select a category</option>
                    @foreach ($categories as $category)
                        <option value={{ $category->id }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-3">
                <label class="block font-medium text-sm text-gray-700" for="description">
                    Device Description
                    <p class="text-xs text-gray-500">
                        What is this item? Can you provide the make/model/year?
                    </p>
                    @error('description')
                        <span class="text-sm text-red-800">{{ $message }}</span>
                    @enderror
                </label>
                <input id="description" type="text" wire:model.defer="description"
                    placeholder="Kenwood Food mixer. 1995 KM200 - Chef"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" />
            </div>

            <div class="mt-3">
                <label class="block font-medium text-sm text-gray-700" for="issue">
                    Issue / Symptoms
                    <p class="text-xs text-gray-500">
                        Please describe in as much detal as you can what the problem is
                    </p>
                    @error('issue')
                        <span class="text-sm text-red-800">{{ $message }}</span>
                    @enderror
                </label>
                <textarea id="issue" wire:model.defer="issue" rows="4"
                    placeholder="When powered up and turned on, there is a buzzing sound but the mixer doesn't rotate"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"></textarea>
            </div>

            <div class="mt-3">
                <label class="block font-medium text-sm text-gray-700" for="powered">
                    Does this item use a power source?
                    @error('powered')
                        <span class="text-sm text-red-800">{{ $message }}</span>
                    @enderror
                </label>

                <select id="powered" wire:model="powered"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                    <option value="null" disabled selected>Select an option</option>
                    @foreach ($powerOptions as $powerOption)
                        <option value={{ $powerOption }}>{{ ucfirst($powerOption) }}</option>
                    @endforeach
                </select>
            </div>

            <p class="text-sm text-gray-600 mt-6">
                By adding your device, you are agreeing to our <a href="/repair-policy" target="_blank"
                    rel="noopener noreferrer" class="text-blue-600 dark:text-blue-500 hover:underline">Repair Policy</a>
                and understand that your item will only be fixed on a best-efforts basis, subject to assessment and
                availablity, and accept the risks involved in any agreed repair process.
            </p>

        </x-form-modal>
    @endif
</div>
