<div class="mt-4 flex flex-col gap-6">
    <flux:text class="text-center">
        {{ __('Your email address must be verified before you can continue, please check your inbox.') }}        
    </flux:text>

    <flux:text class="text-center">
        {{ __('If you did not receive an email, you can click below to have another one sent. Remember to check your spam folder.') }}
    </flux:text>

    @if (session('status') == 'verification-link-sent')
        <flux:text class="text-center font-medium !dark:text-green-400 !text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </flux:text>
    @endif

    <div class="flex flex-col items-center justify-between space-y-3">
        <flux:button wire:click="sendVerification" variant="primary" class="w-full">
            {{ __('Resend verification email') }}
        </flux:button>

        <flux:link class="text-sm cursor-pointer" wire:click="logout">
            {{ __('Log out') }}
        </flux:link>
    </div>
</div>
