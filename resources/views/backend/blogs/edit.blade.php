<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Blog') }}
        </h2>
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

                        <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $blog->title) }}" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="mb-4">
                                <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                                <textarea name="body" id="body" rows="5" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('body', $blog->body) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="image" class="block text-sm font-medium text-gray-700">Replace Image</label>
                                <input type="file" name="image" id="image"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
                            </div>

                            @if($blog->image)
                                <div class="mb-6 flex justify-center">
                                    <img src="{{ asset('storage/' . $blog->image->url) }}" alt="Current Image"
                                        class="rounded-lg shadow-md w-1/2 max-w-md">
                                </div>
                            @endif

                            <div class="mb-4 flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" {{ old('is_active', $blog->is_active) ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                            </div>

                            <div class="mt-6">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border rounded-md font-semibold text-sm hover:bg-indigo-700 transition ease-in-out duration-150">
                                    Update Blog
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
