<div class="relative mb-6 w-full">
    <flux:button
        variant="ghost"
        icon="arrow-left"
        :href="route('filament.dashboard.pages.dashboard')"
        class="mb-4"
    >
        {{ __('Back to app') }}
    </flux:button>

    <flux:heading size="xl" level="1">{{ __('Settings') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Manage your profile and account settings') }}</flux:subheading>
    <flux:separator variant="subtle" />
</div>
