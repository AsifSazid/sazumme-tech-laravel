<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table id="roleTable" class="w-full table-striped table-bordered text-sm">
                            <thead class="bg-gray-100 text-gray-700 uppercase">
                                <tr>
                                    <th class="px-6 py-4">Sl No.</th>
                                    <th class="px-6 py-4">User Name</th>
                                    <th class="px-6 py-4">Email</th>
                                    <th class="px-6 py-4">Phone No</th>
                                    <th class="px-6 py-4">Role(s)</th>
                                    <th class="px-6 py-4">Verified</th>
                                    <th class="px-6 py-4">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">{{ $user->name }}</td>
                                        <td class="px-6 py-4">{{ $user->email }}</td>
                                        <td class="px-6 py-4">{{ $user->phone_no }}</td>
                                        <td class="px-6 py-4">
                                            @if ($user->roles->isNotEmpty())
                                                {{ $user->roles->pluck('name')->join(', ') }}
                                            @else
                                                Not Selected by Admin
                                            @endif
                                            <a href="{{ route('users.assign-roles', $user->uuid) }}" target="_blank"
                                                class="text-blue-500 hover:text-blue-700 mx-1" title="Add Role">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">{{ $user->is_phone_verified ? 'Yes' : 'No' }}</td>
                                        <td class="px-6 py-4">
                                            <button class="text-blue-500 hover:text-blue-700 mx-1"
                                                title="View Profile"><i class="fas fa-eye"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-4 text-center text-gray-500">No users found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $users->links() }}
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
