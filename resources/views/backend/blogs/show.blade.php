<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Blog of') }} {{ $blog->title }}
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
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $blog->title }}</h3>
                                </div>
                                <p><strong>Status:</strong>
                                    @if ($blog->is_active && $blog->is_approved)
                                        <span class="text-green-600 font-semibold">Active & Approved</span>
                                    @elseif ($blog->is_active === 1 && $blog->is_approved === 0)
                                        <span class="text-red-600 font-semibold">Active But Not Approved Yet</span>
                                    @elseif ($blog->is_active === 0 && $blog->is_approved === 1)
                                        <span class="text-red-600 font-semibold">Inactive But Approved</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Inactive</span>
                                    @endif
                                </p>
                            </div>
                            <div class="p-4">
                                <p class="text-gray-600">
                                    {{ $blog->body }}
                                </p>
                                @if ($blog->image)
                                    <div class="mt-6 mb-6 flex justify-center">
                                        <img src="{{ asset('storage/' . $blog->image->url) }}"
                                            alt="Blog Image {{ $blog->title }}"
                                            class="rounded-lg shadow-md w-1/2 max-w-md mx-auto">
                                    </div>
                                @endif
                            </div>
                            <div class="px-4 py-2 bg-gray-100 border-t text-sm text-gray-500 flex justify-between items-center">
                                <div>
                                    <span class="px-2">Posted on: {{ $blog->created_at->format('d-M-Y H:i') }}</span>
                                    <span class="px-2">Approved on: {{ $blog->approved_at ? $blog->approved_at->format('d-M-Y H:i') : 'Not Approved Yet' }}</span>
                                    <span class="px-2">Updated on: {{ $blog->updated_at->format('d-M-Y H:i') }}</span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.blogs.index') }}"
                                        class="inline-block text-blue-600 hover:underline px-2">← Back to list</a>
                                    <a href="{{ route('admin.blogs.edit', $blog->uuid) }}" class="text-blue-600 hover:underline px-2">Edit</a>
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
