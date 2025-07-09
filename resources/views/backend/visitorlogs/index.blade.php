<x-sb-admin-master>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h2 class="text-2xl font-semibold">{{ __('Visitor Log Lists') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <input id="searchInput"
                            class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md py-2 pl-9 pr-3 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm"
                            placeholder="Search for anything..." type="text" name="search">
                        <table id="roleTable" class="w-full table-striped table-bordered text-sm mt-4">
                            <thead class="bg-gray-100 text-gray-700 uppercase">
                                <tr>
                                    <th class="px-6 py-4">Sl No.</th>
                                    <th class="px-6 py-4">IP Address</th>
                                    <th class="px-6 py-4">Visiting Time</th>
                                    <th class="px-6 py-4">Visit From</th>
                                    <th class="px-6 py-4">Country</th>
                                    <th class="px-6 py-4">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody" class="text-center">

                            </tbody>
                        </table>

                        <div id="paginationLinks" class="mt-4 flex justify-center"></div>

                        <div
                            class="mt-4 px-4 py-2 bg-gray-100 border-t text-sm text-gray-500 flex justify-between items-center">
                            <a id="downloadPdfBtn" class="text-blue-500 hover:text-blue-700 mx-1 cursor-pointer"
                                title="Download as PDF"><i class="fa-solid fa-download"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const input = document.getElementById("searchInput");
                const tableBody = document.getElementById("tableBody");
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const fetchAnnouncements = async (search = '', page = 1) => {
                    try {
                        const response = await fetch(
                            `{{ route('admin.visitorlogs.getData') }}?search=${search}&page=${page}`);
                        const result = await response.json();
                        renderTable(result.data);
                        renderPagination(result, search);
                    } catch (error) {
                        console.error("Error fetching visitorlogs:", error);
                    }
                };

                const renderTable = (visitorlogs) => {
                    tableBody.innerHTML = "";
                    if (visitorlogs.length === 0) {
                        tableBody.innerHTML =
                            `<tr><td colspan="7" class="py-4 text-center text-gray-500">No visitorlogs found</td></tr>`;
                        return;
                    }

                    visitorlogs.forEach((visitorlog, index) => {
                        const row = `
                        <tr>
                            <td class="px-6 py-4">${index + 1}</td>
                            <td class="px-6 py-4">${visitorlog.ip_address}</td>
                            <td class="px-6 py-4"><i class="${visitorlog.visit_date}"></i></td>
                            <td class="px-6 py-4">${visitorlog.visit_from}</td>
                            <td class="px-6 py-4"><i class="${visitorlog.country}"></i></td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    <a href="/admin/visitorlogs/${visitorlog.uuid}" class="px-1 text-blue-500 hover:text-blue-700" title="View"><i class="fas fa-eye"></i></a>
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
                        btn.addEventListener("click", () => fetchAnnouncements(search, i));
                        paginationDiv.appendChild(btn);
                    }
                };

                // Initial load
                fetchAnnouncements();

                // Search input listener
                input.addEventListener("input", (e) => {
                    const searchTerm = e.target.value.trim();
                    fetchAnnouncements(searchTerm, 1); // reset to page 1 on new search
                });

                document.getElementById("downloadPdfBtn").addEventListener("click", () => {
                    const search = document.getElementById("searchInput").value.trim();
                    let url = `{{ route('admin.visitorlogs.download.pdf') }}`;
                    if (search) {
                        url += `?search=${encodeURIComponent(search)}`;
                    }
                    window.open(url, "_blank");
                });
            });
        </script>
    @endpush
</x-sb-admin-master>
