<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Assign Role for') }} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    All Role(s):
                    {{ $user->roles->isNotEmpty() ? $user->roles->pluck('name')->implode(', ') : 'No Data Found' }}
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('users.assign.roles', $user->uuid) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="roles" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Select Role(s)
                                <span class="block text-xs text-gray-500 dark:text-gray-400">
                                    (Hold Ctrl or Command to select multiple options.)
                                </span>
                            </label>
                            <select id="roles" name="roles[]" multiple
                                class="mt-2 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm h-40">
                                @forelse ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        @if ($user->roles->pluck('id')->contains($role->id)) selected @endif>
                                        {{ $role->name }}
                                    </option>
                                @empty
                                    <option value="" disabled>No Roles Available</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border rounded-md font-semibold text-sm hover:bg-indigo-700 transition ease-in-out duration-150">
                                Assign Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            // Optional JS if needed later
        </script>
    @endpush
</x-app-layout>
