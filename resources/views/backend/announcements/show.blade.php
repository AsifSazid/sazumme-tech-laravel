<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Announcement of') }} {{ $announcement->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <div
                            class="min-w-[300px] max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                            <div class="px-4 py-2 bg-gray-100 border-t text-sm text-gray-500 flex justify-between items-center">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $announcement->title }}</h3>
                                    <p class="px-4"><strong>{{ $announcement->wing->title ?? 'Main Website' }}</strong> </p>
                                </div>
                                <p><strong>Status:</strong>
                                    @if ($announcement->is_active)
                                        <span class="text-green-600 font-semibold">Active</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Inactive</span>
                                    @endif
                                </p>
                            </div>
                            <div class="p-4">
                                <div class="mb-4 text-gray-600 flex justify-between items-center">
                                    <p><strong>Starts At:</strong>
                                        {{ $announcement->starts_at?->format('d-M-Y H:i') ?? 'N/A' }}</p>
                                    <p><strong>Ends At:</strong>
                                        {{ $announcement->ends_at?->format('d-M-Y H:i') ?? 'N/A' }}</p>
                                </div>
                                <p class="text-gray-600">
                                    {{ $announcement->body }}
                                </p>
                                @if ($announcement->image)
                                    <div class="mt-6 mb-6 flex justify-center">
                                        <img src="{{ asset('storage/' . $announcement->image->url) }}"
                                            alt="Announcement Image {{ $announcement->title }}"
                                            class="rounded-lg shadow-md w-1/2 max-w-md mx-auto">
                                    </div>
                                @endif
                            </div>
                            <div class="px-4 py-2 bg-gray-100 border-t text-sm text-gray-500 flex justify-between items-center">
                                <div>
                                    <span class="">Posted on: {{ $announcement->created_at->format('d-M-Y H:i') }}</span>
                                    <span class="px-4">Updated on: {{ $announcement->updated_at->format('d-M-Y H:i') }}</span>
                                </div>
                                <div>
                                    <a href="{{ route('announcements.index') }}"
                                        class="inline-block text-blue-600 hover:underline px-2">← Back to list</a>
                                    <a href="{{ route('announcements.edit', $announcement->uuid) }}" class="text-blue-600 hover:underline px-2">Edit</a>
                                    <button class="text-blue-600 hover:underline px-2">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script></script>
    @endpush
</x-app-layout>
