<x-sb-admin-master>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">{{ __('Admin Dashboard') }}</h1>
        </div>
    </x-slot>

    <div class="">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 dark:text-gray-100">
                        {{ __('Welcome, Mr. ' . Auth::user()->name . "! You're logged in and the floor is your!") }}
                    </div>
                    {{-- <a href="{{ route('admin.navigations.syncRoutes') }}" class="btn btn-primary mb-3">
                        Sync Routes to Navigations
                    </a> --}}
                </div>
            </div>
        </div>
        <div class="justify-between px-4 py-4 border-b dark:border-primary-darker">
            <x-backend.sections.visitor-analytics />
        </div>
    </div>
</x-sb-admin-master>
