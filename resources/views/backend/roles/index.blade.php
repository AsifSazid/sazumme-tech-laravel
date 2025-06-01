<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Roles') }}
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
                                    <th class="px-6 py-4">Role Name</th>
                                    <th class="px-6 py-4">Created By</th>
                                    <th class="px-6 py-4">Access Control</th>
                                    <th class="px-6 py-4">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($roles as $role)
                                    <tr>
                                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">{{$role->name}}</td>
                                        <td class="px-6 py-4">{{$role->created_by}}</td>
                                        <td class="px-6 py-4">{{$role->access_control}}</td>
                                        <td class="px-6 py-4">
                                            {{-- <button class="text-blue-500 hover:text-blue-700 mx-1" title="Show"><i
                                                    class="fas fa-eye"></i></button> --}}
                                            <button class="text-yellow-500 hover:text-yellow-700 mx-1" title="Edit"><i
                                                    class="fas fa-edit"></i></button>
                                            <button class="text-red-500 hover:text-red-700 mx-1" title="Delete"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>

                                @empty
                                @endforelse
                            </tbody>
                        </table>
                        {{ $roles->links() }}


                        <!-- Pagination -->
                        {{-- <div class="flex justify-between items-center mt-4">
                            <p class="text-sm text-gray-600">Showing 1 to 3 of 10 results</p>
                            <nav class="inline-flex space-x-1">
                                <button
                                    class="px-3 py-1 rounded-l-md border border-gray-300 bg-white text-sm text-gray-700 hover:bg-gray-100 disabled:opacity-50"
                                    disabled>
                                    Previous
                                </button>
                                <button
                                    class="px-3 py-1 border border-gray-300 bg-blue-500 text-sm text-gray-700 font-semibold hover:bg-blue-600">
                                    1
                                </button>
                                <button
                                    class="px-3 py-1 border border-gray-300 bg-white text-sm text-gray-700 hover:bg-gray-100">
                                    2
                                </button>
                                <button
                                    class="px-3 py-1 border border-gray-300 bg-white text-sm text-gray-700 hover:bg-gray-100">
                                    3
                                </button>
                                <button
                                    class="px-3 py-1 rounded-r-md border border-gray-300 bg-white text-sm text-gray-700 hover:bg-gray-100">
                                    Next
                                </button>
                            </nav>
                        </div> --}}
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            // $(document).ready(function() {
            //     $('#roleTable').DataTable({
            //         responsive: true,
            //         autoWidth: false, // Prevent automatic column width
            //         columnDefs: [{
            //                 orderable: false,
            //                 targets: 3
            //             } // Disable sorting for Action column
            //         ]
            //     });
            // });
        </script>
    @endpush
</x-app-layout>
