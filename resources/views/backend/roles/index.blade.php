<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Roles') }}
            </h2>
            <a href="{{ route('admin.roles.create') }}" class="text-green-500 hover:text-green-700 mx-1" title="Create"><i
                    class="fas fa-plus"></i> Create New</a>
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
                                    <th class="px-6 py-4">Role Name</th>
                                    <th class="px-6 py-4">Created By</th>
                                    <th class="px-6 py-4">Access Control</th>
                                    <th class="px-6 py-4">Action</th>
                                </tr>
                            </thead>
                            <tbody id="roleTableBody" class="text-center">
                            </tbody>
                        </table>
                        {{-- {{ $roles->links() }} --}}
                        <div id="paginationLinks" class="mt-4 flex justify-center"></div>


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
            document.addEventListener("DOMContentLoaded", () => {
                const input = document.getElementById("searchInput");
                const tableBody = document.getElementById("roleTableBody");
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const formatDateTime = (dateStr) => {
                    const date = new Date(dateStr);
                    return date.toLocaleString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false,
                        timeZone: 'UTC'
                    }).replace(',', ' ||');
                };

                const fetchRoles = async (search = '', page = 1) => {
                    try {
                        const response = await fetch(
                            `{{ route('admin.roles.getData') }}?search=${search}&page=${page}`);
                        const result = await response.json();
                        renderTable(result);
                        renderPagination(result, search);
                    } catch (error) {
                        console.error("Error fetching roles:", error);
                    }
                };

                const renderTable = (data) => {
                    const roles = data.data;
                    tableBody.innerHTML = "";
                    if (roles.length === 0) {
                        tableBody.innerHTML =
                            `<tr><td colspan="7" class="py-4 text-center text-gray-500">No roles found</td></tr>`;
                        return;
                    }

                    const startIndex = (data.current_page - 1) * data.per_page;

                    roles.forEach((role, index) => {
                        const row = `
                        <tr>
                            <td class="px-6 py-4">${startIndex + index + 1}</td>
                            <td class="px-6 py-4">${role.name}</td>
                            <td class="px-6 py-4">${role.created_by}</td>
                            <td class="px-6 py-4">${role.access_control ? 'Show Details' : 'Not Given'}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    <a href="/roles/${role.uuid}" class="px-1 text-blue-500 hover:text-blue-700" title="View"><i class="fas fa-eye"></i></a>
                                    <a href="/roles/${role.uuid}/edit" class="px-1 text-yellow-500 hover:text-yellow-700" title="Edit"><i class="fas fa-edit"></i></a>
                                    <form action="/roles/${role.uuid}" method="POST" onsubmit="return confirm('Move to trash?')">
                                        <input type="hidden" name="_token" value="${csrfToken}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="px-1 text-red-500 hover:text-red-700" title="Destroy">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    `;
                        tableBody.insertAdjacentHTML('beforeend', row);
                    });
                };

                const renderPagination = (data, search) => {
                    const paginationDiv = document.getElementById("paginationLinks");
                    paginationDiv.innerHTML = "";

                    if (data.last_page <= 1) return;

                    for (let i = 1; i <= data.last_page; i++) {
                        const btn = document.createElement("button");
                        btn.innerText = i;
                        btn.className =
                            `mx-1 px-3 py-1 rounded ${i === data.current_page ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700'}`;
                        btn.addEventListener("click", () => fetchRoles(search, i));
                        paginationDiv.appendChild(btn);
                    }
                };

                // Initial load
                fetchRoles();

                // Search input listener
                input.addEventListener("input", (e) => {
                    const searchTerm = e.target.value.trim();
                    fetchRoles(searchTerm, 1); // reset to page 1 on new search
                });

                document.getElementById("downloadPdfBtn").addEventListener("click", () => {
                    const search = document.getElementById("searchInput").value.trim();
                    let url = `{{ route('admin.roles.download.pdf') }}`;
                    if (search) {
                        url += `?search=${encodeURIComponent(search)}`;
                    }
                    window.open(url, "_blank");
                });
            });
        </script>
    @endpush
</x-app-layout>
