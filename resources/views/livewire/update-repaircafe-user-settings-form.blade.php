<x-jet-form-section submit="updateRepaircafeUserSettings">
    <x-slot name="title">
        {{ __('Repair Cafe Settings') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your Repair Cafe preferences') }}
    </x-slot>

    <x-slot name="form">

        <!-- Volunteer: -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="volunteer" value="{{ __('Can you volunteer to help at Repair Cafe meetings?') }}" />
            <x-jet-input id="volunteer" type="checkbox" value="true" wire:model.defer="volunteer" />
            <x-jet-input-error for="volunteer" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
