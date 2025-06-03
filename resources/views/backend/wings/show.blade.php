<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Wing of') }} {{ $wing->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <div class="min-w-[300px] max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 dark:bg-gray-900">
                            <!-- Header -->
                            <div class="px-4 py-3 bg-gray-100 dark:bg-gray-700 border-t text-sm text-gray-500 dark:text-gray-300 flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{ $wing->title }}</h3>
                                </div>
                                <p class="text-sm">
                                    <strong>Status:</strong>
                                    @if ($wing->is_active)
                                        <span class="text-green-600 font-semibold">Active</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Inactive</span>
                                    @endif
                                </p>
                            </div>

                            <!-- Content -->
                            <div class="p-4">

                                <div class="text-gray-700 dark:text-gray-200 mb-4">
                                    <p class="whitespace-pre-line">{{ $wing->short_description }}</p>
                                </div>

                                @if ($wing->image)
                                    <div class="mt-6 mb-6 flex justify-center">
                                        <img src="{{ asset('storage/' . $wing->image->url) }}"
                                            alt="Wing Image {{ $wing->title }}"
                                            class="rounded-lg shadow-md w-full max-w-md">
                                    </div>
                                @endif

                                <div class="text-gray-700 dark:text-gray-200 mb-4">
                                    <p class="whitespace-pre-line">{{ $wing->description ?? 'Data not given' }}</p>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="px-4 py-2 bg-gray-100 dark:bg-gray-700 border-t text-sm text-gray-500 dark:text-gray-300 flex justify-between items-center">
                                <div>
                                    <span>Posted: {{ $wing->created_at->format('d-M-Y H:i') }}</span>
                                    <span class="ml-4">Updated: {{ $wing->updated_at->format('d-M-Y H:i') }}</span>
                                </div>
                                <div class="space-x-2">
                                    <a href="{{ route('wings.index') }}"
                                        class="text-blue-600 hover:underline">← Back</a>
                                    <a href="{{ route('wings.edit', $wing->uuid) }}"
                                        class="text-yellow-600 hover:underline">Edit</a>
                                    <form action="{{ route('wings.destroy', $wing->uuid) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this wing?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
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
