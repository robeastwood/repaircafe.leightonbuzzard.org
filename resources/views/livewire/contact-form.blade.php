<div>
    @if($submitted)
        <div class="bg-green-50 border-l-4 border-green-400 p-6 rounded-r-lg mb-6">
            <div class="flex items-start">
                <div class="text-green-600 mr-4 mt-1">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="text-green-700">
                    <p class="font-semibold mb-2">Message Sent Successfully!</p>
                    <p>Thank you for contacting us. We'll get back to you as soon as possible.</p>
                </div>
            </div>
        </div>
    @endif

    <form wire:submit="submit" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name Field -->
            <div>
                <flux:field>
                    <flux:label>
                        <span class="text-gray-700 font-medium">Name</span>
                        <span class="text-red-500">*</span>
                    </flux:label>
                    <flux:input
                        wire:model="name"
                        placeholder="Your name"
                        type="text"
                        class="w-full"
                    />
                    @error('name')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>
            </div>

            <!-- Email Field -->
            <div>
                <flux:field>
                    <flux:label>
                        <span class="text-gray-700 font-medium">Email</span>
                        <span class="text-red-500">*</span>
                    </flux:label>
                    <flux:input
                        wire:model="email"
                        placeholder="your.email@example.com"
                        type="email"
                        class="w-full"
                    />
                    @error('email')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>
            </div>
        </div>

        <!-- Subject Field -->
        <div>
            <flux:field>
                <flux:label>
                    <span class="text-gray-700 font-medium">Subject</span>
                    <span class="text-red-500">*</span>
                </flux:label>
                <flux:input
                    wire:model="subject"
                    placeholder="What is your message about?"
                    type="text"
                    class="w-full"
                />
                @error('subject')
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </flux:field>
        </div>

        <!-- Message Field -->
        <div>
            <flux:field>
                <flux:label>
                    <span class="text-gray-700 font-medium">Message</span>
                    <span class="text-red-500">*</span>
                </flux:label>
                <flux:textarea
                    wire:model="message"
                    placeholder="Tell us how we can help you..."
                    rows="6"
                    class="w-full"
                />
                @error('message')
                    <flux:error>{{ $message }}</flux:error>
                @enderror
                <div class="text-right text-sm text-gray-500 mt-1">
                    {{ strlen($message) }}/2000 characters
                </div>
            </flux:field>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-600">
                <span class="text-red-500">*</span> Required fields
            </p>
            <flux:button type="submit" variant="primary" class="px-8">
                <span wire:loading.remove>Send Message</span>
                <span wire:loading>
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Sending...
                </span>
            </flux:button>
        </div>
    </form>
</div>
