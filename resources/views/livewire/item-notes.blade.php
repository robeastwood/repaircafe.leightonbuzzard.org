<div>
    <ol class="relative ml-6 text-gray-600 border-l-4 border-gray-200">
        <li class="mb-10 ml-8">
            <span
                class="absolute flex items-center justify-center mt-1 w-11 h-11 rounded-full -left-6 ring-4 ring-white bg-gray-200 text-gray-800">
                <i class="fas fa-heart-crack fa-xl"></i>
            </span>
            <p class="text-sm">{{ Carbon\Carbon::parse($item->created_at)->format('l jS \\of F, g:ia') }} |
                @if ($item->user)
                    {{ $item->user->name }}
                @else
                    <span class="italic">Unregistered User</span>
                @endif
            </p>
            <h3 class="font-medium text-xl leading-tight">Added Item</h3>
            <p class="text-gray-800">Issue description: <br />{!! nl2br(e($item->issue)) !!}</p>
        </li>

        @foreach ($item->notes as $note)
            <li class="mb-10 ml-8">
                <span
                    class="absolute flex items-center justify-center mt-3 w-11 h-11 rounded-full -left-6 ring-4 ring-white {{ \App\Models\Item::statusOptions()[$note->status_new]['colour'] }}">
                    <i class="{{ \App\Models\Item::statusOptions()[$note->status_new]['icon'] }} fa-xl"></i>
                </span>
                <p class="text-sm">{{ Carbon\Carbon::parse($note->created_at)->format('l jS \\of F, g:ia') }} |
                    @if ($note->user)
                        {{ $note->user->name }}
                    @else
                        <span class="italic">Unregistered User</span>
                    @endif
                </p>
                <h3 class="font-medium text-xl leading-tight">
                    {{ \App\Models\Item::statusOptions()[$note->status_new]['display'] }}</h3>
                <p class="text-gray-800">{!! nl2br(e($note->note)) !!}</p>
            </li>
        @endforeach

        @if (Auth::user()->volunteer || Auth::user()->is_admin || ($item->user && $item->user->id == Auth::id()))
            <li class="mb-10 ml-8">
                <span
                    class="absolute flex items-center justify-center w-11 h-11 rounded-full -left-6 ring-4 ring-white bg-gray-200 text-gray-800">
                    <i class="far fa-pen-to-square fa-xl"></i>
                </span>
                <form>
                    <div>
                        <label class="block font-medium text-sm text-gray-700" for="newNote">
                            Add an update on this item:
                            @error('newNote')
                                <span class="text-sm text-red-800">{{ $message }}</span>
                            @enderror
                        </label>
                        <textarea id="newNote" wire:model.defer="newNote" rows="4" placeholder="Enter your note here"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"></textarea>
                    </div>

                    <div class="mt-3">
                        <label class="block font-medium text-sm text-gray-700" for="newStatus">
                            Current status of the item:
                            @error('newStatus')
                                <span class="text-sm text-red-800">{{ $message }}</span>
                            @enderror
                        </label>
                        <select id="newStatus" wire:model.defer="newStatus"
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                            @foreach (\App\Models\Item::statusOptions() as $k => $v)
                                <option value="{{ $k }}">{{ $v['display'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <footer class="flex items-center flex-row-reverse gap-2 mt-3">
                        <x-jet-button type="button" wire:loading.attr="disabled" wire:click="addNote">
                            {{ __('Submit') }}
                        </x-jet-button>
                        <x-jet-action-message class="mr-3" on="note_created">
                            {{ __('Added.') }}
                        </x-jet-action-message>
                    </footer>
                </form>
            </li>
        @endif
    </ol>

</div>
