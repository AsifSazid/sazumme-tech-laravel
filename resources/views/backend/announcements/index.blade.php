<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Announcement Lists') }}
            </h2>
            <a href="{{ route('announcements.create') }}" class="text-green-500 hover:text-green-700 mx-1"
                title="Create"><i class="fas fa-plus"></i> Create New</a>
        </div>
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
                                    <th class="px-6 py-4">Announcement Title</th>
                                    <th class="px-6 py-4">Created By</th>
                                    <th class="px-6 py-4">Started At</th>
                                    <th class="px-6 py-4">Will be Ended</th>
                                    <th class="px-6 py-4">Activity</th>
                                    <th class="px-6 py-4">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($announcements as $announcement)
                                    <tr>
                                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">{{ $announcement->title }}</td>
                                        <td class="px-6 py-4">{{ $announcement->user->name }}</td>
                                        <td class="px-6 py-4">{{ $announcement->starts_at }}</td>
                                        <td class="px-6 py-4">{{ $announcement->ends_at }}</td>
                                        <td class="px-6 py-4">{{ $announcement->is_active ? 'Active' : 'Inactive' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('announcements.show', $announcement->uuid) }}"
                                                    class="text-blue-500 hover:text-blue-700 mx-1"
                                                    title="View Profile"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('announcements.edit', $announcement->uuid) }}"
                                                    class="text-yellow-500 hover:text-yellow-700 mx-1" title="Edit"><i
                                                        class="fas fa-edit"></i></a>
                                                <form
                                                    action="{{ route('announcements.destroy', $announcement->uuid) }}"
                                                    method="POST" onsubmit="return confirm('Move to trash?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 mx-1"
                                                        title="Destroy"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-4 text-center text-gray-500">No announcements found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $announcements->links() }}
                        </div>

                        <div
                            class="mt-4 px-4 py-2 bg-gray-100 border-t text-sm text-gray-500 flex justify-between items-center">
                            <a href="{{ route('announcements.trash') }}" class="text-red-500 hover:text-red-700 mx-1"
                                title="Trash Lists"><i class="fas fa-trash-alt"></i> Trash Lists</a>
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
