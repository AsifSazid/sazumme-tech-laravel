<x-sb-admin-master>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h2 class="text-2xl font-semibold">
                {{ __('Edit Navigation') }}
            </h2>
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

                        <form action="{{ route('admin.navigations.update', $navigation->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                <input type="text" name="title" id="title"
                                    value="{{ old('title', $navigation->title) }}" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="mb-4">
                                <label for="announcement_for" class="block text-sm font-medium text-gray-700">Navigation
                                    For</label>
                                <select name="announcement_for" id="announcement_for"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="" disabled>Select Any One</option>
                                    <option value="main_website"
                                        {{ old('announcement_for', $navigation->announcement_for) === 'main_website' ? 'selected' : '' }}>
                                        Main Website</option>
                                    @foreach ($wings as $wing)
                                        <option value="{{ $wing->id }}"
                                            {{ old('announcement_for', $navigation->announcement_for) == $wing->id ? 'selected' : '' }}>
                                            {{ $wing->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                                <textarea name="body" id="body" rows="5" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('body', $navigation->body) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="image" class="block text-sm font-medium text-gray-700">Replace
                                    Image</label>
                                <input type="file" name="image" id="image"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
                            </div>

                            @if ($navigation->image)
                                <div class="mb-6 flex justify-center">
                                    <img src="{{ asset('storage/' . $navigation->image->url) }}" alt="Current Image"
                                        class="rounded-lg shadow-md w-1/2 max-w-md">
                                </div>
                            @endif

                            <div class="mb-4">
                                <label for="starts_at" class="block text-sm font-medium text-gray-700">Starts At</label>
                                <input type="datetime-local" name="starts_at" id="starts_at"
                                    value="{{ old('starts_at', optional($navigation->starts_at)->format('Y-m-d\TH:i')) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="mb-4">
                                <label for="ends_at" class="block text-sm font-medium text-gray-700">Ends At</label>
                                <input type="datetime-local" name="ends_at" id="ends_at"
                                    value="{{ old('ends_at', optional($navigation->ends_at)->format('Y-m-d\TH:i')) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="mb-4 flex items-center">
                                <input type="checkbox" name="is_active" id="is_active"
                                    {{ old('is_active', $navigation->is_active) ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                            </div>

                            <div class="mt-6">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border rounded-md font-semibold text-sm hover:bg-indigo-700 transition ease-in-out duration-150">
                                    Update Navigation
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-sb-admin-master>
