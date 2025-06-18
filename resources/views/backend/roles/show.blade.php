<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $role->title }} {{ __('Role') }}
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
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $role->name }}</h3>
                                    <p class="px-4"><strong>{{ $role->created_by ?? ' ' }}</strong> </p>
                                </div>
                                <p><strong>Status:</strong>
                                    @if ($role->is_active)
                                        <span class="text-green-600 font-semibold">Active</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Inactive</span>
                                    @endif
                                </p>
                            </div>
                            <div class="p-4">
                                <p class="text-gray-600 mt-2 mb-4">
                                    <label for="alias" class="font-semibold">Alias: </label> {{ $role->alias }}
                                </p>
                                <div class="text-gray-600 my-2">
                                    <label for="access_control" class="font-semibold">Access Control: </label>
                                    <ul>
                                        @if($role->access_control)
                                        <li>---</li>
                                        @else
                                            <li>Not Given Any Access Control</li>    
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="px-4 py-2 bg-gray-100 border-t text-sm text-gray-500 flex justify-between items-center">
                                <div>
                                    <span class="">Created on: {{ $role->created_at->format('d-M-Y H:i') }}</span>
                                    <span class="px-4">Updated on: {{ $role->updated_at->format('d-M-Y H:i') }}</span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.roles.index') }}"
                                        class="inline-block text-blue-600 hover:underline px-2">← Back to list</a>
                                    <a href="{{ route('admin.roles.edit', $role->uuid) }}" class="text-blue-600 hover:underline px-2">Edit</a>
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
