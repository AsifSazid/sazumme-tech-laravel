{{-- <x-app-layout>
    <x-auth-card>
        <x-slot name="logo">
            <h2 class="text-xl font-bold text-center">Admin Password Reset</h2>
        </x-slot>

        @if (session('status'))
            <x-alert-success :message="session('status')" />
        @endif

        <form method="POST" action="{{ route('admin.password.email') }}">
            @csrf

            <div class="mt-4">
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-primary-button class="w-full justify-center">
                    {{ __('Send Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-app-layout> --}}
