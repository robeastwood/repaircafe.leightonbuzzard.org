<x-jet-form-section submit="updateVolunteer">
    <x-slot name="title">
        {{ __('Volunteering') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Offer your skills to help people at Repair Cafe events') }}
    </x-slot>

    <x-slot name="form">

        <!-- Volunteer: -->
        <div class="col-span-12 sm:col-span-12">
            <p class="text-sm text-gray-600">
                We would very much appreciate your help at the Repair Cafe events, even if you're non-technical. Enabling this option will allow you to join events as a volunteer, and to list the skills you can offer.<br />
                Please ensure you read and agree to the <a href="/volunteer-policy" target="_blank"
                    rel="noopener noreferrer" class="text-blue-600 dark:text-blue-500 hover:underline">volunteer
                    policy</a> beforehand:</p>
        </div>
        <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
            <input wire:model="volunteer"
                class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-[rgba(0,0,0,0.25)] bg-white outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:bg-white focus:after:content-[''] checked:focus:border-primary checked:focus:bg-primary checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                type="checkbox" value="" id="checkboxDefault" />
            <label class="inline-block pl-[0.15rem] hover:cursor-pointer min-w-max" for="checkboxDefault">
                Yes, I'd like to volunteer at Repair Cafe events
            </label>
        </div>

        <!-- Skills: -->
        @if ($volunteer)
            <div class="col-span-12 sm:col-span-12">
                <div>
                    <p class="text-sm text-gray-600 mb-2">
                        Great! Please select any skills you can offer:
                    </p>
                    @foreach ($allSkills as $skill)
                        <div class="mb-[0.125rem] block pl-[1.5rem]">
                            <input wire:model.defer="userSkills" value={{ $skill->id }}
                                class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-[rgba(0,0,0,0.25)] bg-white outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:bg-white focus:after:content-[''] checked:focus:border-primary checked:focus:bg-primary checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent"
                                type="checkbox" id="checkboxSkill{{ $skill->id }}" />
                            <label class="inline-block pl-[0.15rem] hover:cursor-pointer min-w-max"
                                for="checkboxSkill{{ $skill->id }}">
                                {{ $skill->name }}
                            </label>
                        </div>
                    @endforeach

                    <div class="col-span-12 sm:col-span-12 mt-4">
                        <p class="text-sm text-gray-600">
                            If you have skills that do not fall under any of the existing categories above, you can add
                            them as new categories. Please enter them below:</p>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <label class="block font-medium text-sm text-gray-700" for="newSkill">
                            New Skill Category
                        </label>
                        <div class="flex items-center">
                            <input id="newSkill" wire:model="newSkill"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full
                                    mr-3 leading-tight focus:outline-none"
                                type="text" placeholder="Other Skill" aria-label="Other Skill">
                            <button wire:click="addSkill()"
                                class="bg-gray-800 border border-transparent hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition text-sm text-white mt-1 p-2 rounded"
                                type="button">
                                Add
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
