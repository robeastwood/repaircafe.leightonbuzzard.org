<div x-data="{ show: @entangle($attributes->wire('model')) }" x-show="show" @keydown.escape.window="show=false" style="display: none">
    <div class="fixed inset-0 bg-gray-900 opacity-90" @click="show=false"></div>
    <div
        {{ $attributes->merge(['class' => 'bg-white shadow-md p-4 h-full max-w-lg max-h-fit m-auto sm:rounded-md fixed inset-0 overflow-auto']) }}>
        <form class="flex flex-col justify-between text-left">
            <header>
                <h1 class="font-bold text-lg">{{ $title }}</h1>
            </header>
            <main>
                {{ $slot }}
            </main>
            <footer class="flex items-center flex-row-reverse gap-2 mt-3">
                <x-jet-button type="button" wire:loading.attr="disabled" wire:click="{{ $handler }}">
                    {{ __('Save') }}
                </x-jet-button>
                <x-jet-button type="button" class="bg-gray-400 hover:bg-gray-500"
                    wire:click="$set('showModal',false)">Cancel</x-jet-button>
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Saved.') }}
                </x-jet-action-message>
            </footer>
        </form>
    </div>
</div>
