<div class="space-y-6">
    {{-- Notes Timeline Header --}}
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-950 dark:text-white">
            Notes for "{{ $item->description }}"
        </h2>
        @if($notes->isNotEmpty())
            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <x-filament::icon
                    icon="heroicon-o-magnifying-glass"
                    class="h-4 w-4"
                />
                <span class="font-medium">{{ $item->status ? (App\Models\Item::statusOptions()[$item->status] ?? $item->status) : 'Unknown' }}</span>
            </div>
        @endif
    </div>

    {{-- Notes Timeline --}}
    <div class="space-y-4">
        @forelse($notes as $note)
            @php
                $isCurrentUser = $note->user_id === auth()->id();
                $hasStatusChange = $note->status_orig !== $note->status_new;

                // Determine status badge color
                $statusColor = App\Models\Item::statusDetails($note->status_new)['color'];
            @endphp

            <div class="flex {{ $isCurrentUser ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[75%] {{ $isCurrentUser ? 'ml-auto' : 'mr-auto' }}">
                    {{-- Note Bubble --}}
                    <div class="@if($isCurrentUser) bg-primary-500 text-white @else bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 @endif rounded-2xl px-4 py-3 shadow-sm">
                        {{-- User Info --}}
                        <div class="mb-2 flex items-center gap-2 text-xs {{ $isCurrentUser ? 'text-primary-100' : 'text-gray-600 dark:text-gray-400' }}">
                            <span class="font-semibold">{{ $note->user->name }}</span>
                            <span>•</span>
                            <time datetime="{{ $note->created_at->toIso8601String() }}">
                                {{ $note->created_at->format('Y-m-d g:i A') }}
                            </time>
                            @if($hasStatusChange)
                                <span>•</span>
                                <span class="font-medium uppercase">{{ App\Models\Item::statusOptions()[$note->status_new] ?? $note->status_new }}</span>
                            @endif
                        </div>

                        {{-- Note Content --}}
                        <div class="text-sm leading-relaxed whitespace-pre-wrap">
                            {{ $note->note }}
                        </div>
                    </div>

                    {{-- Status Change Indicator --}}
                    @if($hasStatusChange)
                        <div class="mt-2 {{ $isCurrentUser ? 'text-right' : 'text-left' }}">
                            <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-medium
                                @if($statusColor === 'success') bg-success-50 text-success-700 dark:bg-success-500/10 dark:text-success-400
                                @elseif($statusColor === 'info') bg-info-50 text-info-700 dark:bg-info-500/10 dark:text-info-400
                                @elseif($statusColor === 'warning') bg-warning-50 text-warning-700 dark:bg-warning-500/10 dark:text-warning-400
                                @elseif($statusColor === 'danger') bg-danger-50 text-danger-700 dark:bg-danger-500/10 dark:text-danger-400
                                @else bg-gray-50 text-gray-700 dark:bg-gray-500/10 dark:text-gray-400
                                @endif">
                                @if($note->status_new === 'fixed')
                                    <x-filament::icon
                                        icon="heroicon-o-check-circle"
                                        class="h-4 w-4"
                                    />
                                @elseif($note->status_new === 'unfixable')
                                    <x-filament::icon
                                        icon="heroicon-o-x-circle"
                                        class="h-4 w-4"
                                    />
                                @else
                                    <x-filament::icon
                                        icon="heroicon-o-arrow-path"
                                        class="h-4 w-4"
                                    />
                                @endif
                                <span>
                                    {{ App\Models\Item::statusOptions()[$note->status_orig] ?? $note->status_orig }}
                                    →
                                    {{ App\Models\Item::statusOptions()[$note->status_new] ?? $note->status_new }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="rounded-lg border border-dashed border-gray-300 dark:border-gray-600 p-8 text-center">
                <x-filament::icon
                    icon="heroicon-o-chat-bubble-left-right"
                    class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500"
                />
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    No notes yet. Add the first note to start tracking this item's journey.
                </p>
            </div>
        @endforelse
    </div>

    {{-- Add Note Form --}}
    @if($this->canAddNote())
        <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm">
            <form wire:submit="addNote">
                <div class="space-y-4">
                    {{-- Note Textarea --}}
                    <div>
                        <x-filament::input.wrapper>
                            <textarea
                                wire:model="data.note"
                                rows="3"
                                placeholder="Add a note about this item..."
                                class="fi-input block w-full rounded-lg border-none py-1.5 text-base text-gray-950 outline-none transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
                            ></textarea>
                        </x-filament::input.wrapper>
                        @error('data.note')
                            <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status Select (only shown if user has permission to update item status) --}}
                    @if($this->canUpdateItemStatus())
                        <div>
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Current Status
                            </label>
                            <x-filament::input.wrapper class="mt-1">
                                <x-filament::input.select wire:model="data.status_new">
                                    @foreach(App\Models\Item::statusOptions() as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </x-filament::input.select>
                            </x-filament::input.wrapper>
                            @error('data.status_new')
                                <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        <span class="font-medium">Current Status:</span>
                        <x-filament::badge
                            :color="App\Models\Item::statusDetails($item->status)['color']"
                        >
                            {{ App\Models\Item::statusOptions()[$item->status] ?? $item->status }}
                        </x-filament::badge>
                    </div>

                    <x-filament::button type="submit" size="lg">
                        Add Note
                    </x-filament::button>
                </div>
            </form>
        </div>
    @endif
</div>
