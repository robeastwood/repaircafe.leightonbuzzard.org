<div>
    @if (Auth::user()->volunteer)
        <div class="relative inline-block">
            <label class="block font-medium text-sm text-gray-700" for="status">
                Are you volunteering at this event?
                @error('status')
                    <span class="text-sm text-red-800">{{ $message }}</span>
                @enderror
            </label>

            <select id="status" wire:model="status"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                <option value="notattending">Not Attending</option>
                <option value="attending">Attending</option>
                <option value="volunteering">Volunteering</option>
            </select>
        </div>
    @else
        <div class="text-xs">Do you have repair skills?<br /><a class="font-semibold text-indigo-700 hover:underline"
                href="/user/profile">Volunteer to help</a></div>
    @endif
</div>
