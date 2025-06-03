<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Wing') }}
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

                        <form action="{{ route('wings.update', $wing->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="title" class="block text-sm font-medium text-gray-700">Wing Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $wing->title) }}" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="mb-4">
                                <label for="icon_code" class="block text-sm font-medium text-gray-700">Icon Code</label>
                                <input type="text" name="icon_code" id="icon_code" value="{{ old('icon_code', $wing->icon_code) }}" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="mb-4">
                                <label for="short_description" class="block text-sm font-medium text-gray-700">Short Description</label>
                                <textarea name="short_description" id="short_description" rows="5" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('short_description', $wing->short_description) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="5"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $wing->description) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="image" class="block text-sm font-medium text-gray-700">Wing Image</label>
                                @if ($wing->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $wing->image) }}" alt="Current Image" class="h-24">
                                    </div>
                                @endif
                                <input type="file" name="image" id="image"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
                            </div>

                            <div class="mb-4 flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" {{ old('is_active', $wing->is_active) ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                            </div>

                            <div class="mt-6">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Update Wing
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
</x-app-layout>
