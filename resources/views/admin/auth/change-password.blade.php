{{-- <x-app-layout>
    <x-auth-card>
        <x-slot name="logo">
            <h2 class="text-xl font-bold text-center">Change Password</h2>
        </x-slot>

        @if (session('status'))
            <x-alert-success :message="session('status')" />
        @endif

        <form method="POST" action="{{ route('admin.password.change') }}">
            @csrf
            @method('PUT')

            <div class="mt-4">
                <x-input-label for="current_password" :value="__('Current Password')" />
                <x-text-input id="current_password" class="block mt-1 w-full" type="password" name="current_password" required />
                <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('New Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-primary-button class="w-full justify-center">
                    {{ __('Change Password') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-app-layout> --}}
