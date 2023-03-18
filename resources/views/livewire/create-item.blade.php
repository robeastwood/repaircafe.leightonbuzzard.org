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
                    Item Description
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
                        Please describe in as much detail as you can what the problem is
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
                By adding your item, you are must read and agree to the <a href="/repair-disclaimer" target="_blank"
                    rel="noopener noreferrer" class="text-blue-600 dark:text-blue-500 hover:underline">Repair
                    Disclaimer</a> and the <a href="/healt-and-safety" target="_blank" rel="noopener noreferrer"
                    class="text-blue-600 dark:text-blue-500 hover:underline">Health &amp; Safety Policy</a>,
                and understand that your item will only be fixed on a best-efforts basis, subject to assessment and
                availability, and accept the risks involved in any attempted repair process.

            </p>
            @error('disclaimer')
                <span class="text-sm text-red-800">{{ $message }}</span>
            @enderror
            <div class="text-gray-600 mt-2 mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                <input wire:model.defer="disclaimer" value="true"
                    class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-[rgba(0,0,0,0.25)] bg-white outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:bg-white focus:after:content-[''] checked:focus:border-primary checked:focus:bg-primary checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                    type="checkbox" value="" id="disclaimer" />
                <label class="inline-block pl-[0.15rem] hover:cursor-pointer min-w-max" for="disclaimer">
                    I agree
                </label>
            </div>

        </x-form-modal>
    @endif
</div>
