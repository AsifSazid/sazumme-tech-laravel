<x-sb-admin-master>
    @push('css')
        <style>
            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type=number] {
                -moz-appearance: textfield;
            }
        </style>
    @endpush

    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h2 class="text-2xl font-semibold">{{ __('Create Ebook') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        @if ($errors->any())
                            <div class="mb-4 text-red-600">
                                <ul class="list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.ebooks.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="title" class="block text-sm font-medium text-gray-700">Ebook
                                    Title</label>
                                <input type="text" name="title" id="title" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="mb-4">
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="5"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="author" class="block text-sm font-medium text-gray-700">Author
                                    Name</label>
                                <input type="text" name="author" id="author" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="mb-4">
                                <label for="cover_image" class="block text-sm font-medium text-gray-700">Cover
                                    Image</label>
                                <input type="file" name="cover_image" id="cover_image"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
                            </div>

                            <div class="mb-4">
                                <label for="ebook_file" class="block text-sm font-medium text-gray-700">Upload
                                    Ebook</label>
                                <input type="file" name="ebook_file" id="ebook_file"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
                            </div>

                            <div class="mb-4">
                                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                <input type="number" name="price" id="price" step="0.01" value="0.00"
                                    min="0"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="mb-4">
                                <label for="page_count" class="block text-sm font-medium text-gray-700">Total Page</label>
                                <input type="number" name="page_count" id="page_count" min="1"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="mb-4">
                                <label for="category"
                                    class="block text-sm font-medium text-gray-700">Select Category</label>
                                <select name="category" id="category"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="" selected disabled>Select Any One Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="tags"
                                    class="block text-sm font-medium text-gray-700">Select Tags</label>
                                <select name="tags" id="tags"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="" selected disabled>Select Tags</option>
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4 flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" checked
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                            </div>

                            <div class="mt-6">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border rounded-md font-semibold text-sm hover:bg-indigo-700 transition ease-in-out duration-150">
                                    Create Ebook
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script></script>
    @endpush
</x-sb-admin-master>
