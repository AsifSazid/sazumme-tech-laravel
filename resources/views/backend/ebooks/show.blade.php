<x-sb-admin-master>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h2 class="text-2xl font-semibold">
                {{ __('Ebook: ') }} {{ $ebook->title }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <div
                            class="min-w-[300px] max-w-3xl mx-auto bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                            <div class="px-4 py-2 bg-gray-100 border-t text-sm text-gray-500">
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $ebook->title }}</h3>
                                <p class="text-sm text-gray-600">By <strong>{{ $ebook->author }}</strong></p>
                                <p class="text-sm mt-1">
                                    <strong>Status:</strong>
                                    @if ($ebook->is_active)
                                        <span class="text-green-600 font-semibold">Active</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Inactive</span>
                                    @endif
                                </p>
                            </div>

                            <div class="p-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

                                    <div>
                                        <p class="mb-4 text-gray-700">{{ $ebook->description }}</p>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4 text-gray-700 text-sm">
                                            <p><strong>Price:</strong> ৳ {{ number_format($ebook->price, 2) }}</p>
                                            <p><strong>Page Count:</strong> {{ $ebook->page_count }}</p>
                                            <p><strong>Created At:</strong>
                                                {{ $ebook->created_at->format('d-M-Y H:i') }}</p>
                                            <p><strong>Updated At:</strong>
                                                {{ $ebook->updated_at->format('d-M-Y H:i') }}</p>
                                        </div>

                                        @if ($ebook->categories?->count())
                                            <div class="mb-4">
                                                <p><strong>Categories:</strong></p>
                                                <div class="flex flex-wrap mt-1">
                                                    @foreach ($ebook->categories as $category)
                                                        <span
                                                            class="bg-blue-100 text-blue-700 text-xs font-medium mr-2 mb-2 px-2.5 py-0.5 rounded">
                                                            {{ $category->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        @if ($ebook->tags?->count())
                                            <div class="mb-4">
                                                <p><strong>Tags:</strong></p>
                                                <div class="flex flex-wrap mt-1">
                                                    @foreach ($ebook->tags as $tag)
                                                        <span
                                                            class="bg-green-100 text-green-700 text-xs font-medium mr-2 mb-2 px-2.5 py-0.5 rounded">
                                                            {{ $tag->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex flex-col items-center">
                                        @if ($ebook->image)
                                            <div class="mb-6 w-full flex justify-center">
                                                <img src="{{ asset('storage/' . $ebook->image->url) }}"
                                                    alt="{{ $ebook->title }} Cover"
                                                    class="rounded-lg shadow-md w-3/4 max-w-sm">
                                            </div>
                                        @endif

                                        @if ($ebook->file)
                                            <a href="{{ asset('storage/' . $ebook->file->url) }}" target="_blank"
                                                class="inline-block bg-indigo-600 hover:bg-indigo-700 text-sm font-semibold px-6 py-2 rounded shadow">
                                                📄 View Ebook File
                                            </a>
                                        @endif
                                    </div>

                                </div>
                            </div>


                            <div
                                class="px-4 py-2 bg-gray-100 border-t text-sm text-gray-500 flex justify-between items-center">
                                <div>
                                    <span class="">Posted on:
                                        {{ $ebook->created_at->format('d-M-Y H:i') }}</span>
                                    <span class="px-4">Updated on:
                                        {{ $ebook->updated_at->format('d-M-Y H:i') }}</span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.ebooks.index') }}"
                                        class="inline-block text-blue-600 hover:underline px-2">← Back to list</a>
                                    <a href="{{ route('admin.ebooks.edit', $ebook->uuid) }}"
                                        class="text-blue-600 hover:underline px-2">Edit</a>
                                    <form action="{{ route('admin.ebooks.destroy', $ebook->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline px-2"
                                            onclick="return confirm('Are you sure you want to delete this ebook?')">
                                            Delete
                                        </button>
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
</x-sb-admin-master>
