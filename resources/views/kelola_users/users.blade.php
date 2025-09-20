@extends('layout')
@section('title', 'Kelola User')

@section('content')
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        @include('partials.header')

        <div class="p-6 min-h-screen">
            <!-- Sub-Header -->
            <div class="bg-transparent py-0 px-4 flex justify-between items-center mb-10">
                <h1 class="text-2xl font-semibold">
                    Kelola User
                </h1>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('dashboard.manage_create_user') }}"
                    class="border border-blue-600 py-2 px-5 rounded-lg text-white bg-blue-600 font-semibold cursor-pointer hover:bg-blue-700 hover:transition duration-300">
                    Create User
                    </a>
                </div>
            </div>

            <!-- Search + Table (AJAX) -->
            <div class="overflow-x-auto bg-white shadow p-4 rounded-2xl mb-6">
                <!-- Search Input -->
                <div class="flex items-center space-x-4 relative  mb-4 w-[400px]" id="divSearch">
                    <input id="search" type="text" 
                    placeholder="Cari user berdasarkan nama, email, atau role"
                    class="w-full border rounded-lg px-10 py-2 text-sm border-2 focus:border-blue-400" />

                    <div class="absolute right-3 text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 
                                5.196 5.196a7.5 7.5 0 0 0 
                                10.607 10.607Z" />
                        </svg>
                    </div>
                </div>
                <!-- Table -->
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="p-3">#</th>
                            <th class="p-3">Nama</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Role</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="userTable">
                        <tr>
                            <td colspan="5" class="text-center p-4">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            
                <!-- Pagination -->
                <div id="pagination" class="mb-4 mt-10 flex space-x-2 justify-center"></div>
            </div>
        </div>

        <main class="px-6 relative flex-grow">
            @include('partials.footer')
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            const route_edit = "{{ route('dashboard.manage_edit_user', ':id') }}";
            const route_delete = "{{ route('dashboard.manage_delete_user', ':id') }}";
            const csrfToken = "{{ csrf_token() }}";
            let currentPage = 1;
            let query = "";

            function fetchUsers(page = 1, search = '') {
                $.ajax({
                    url: "{{ route('dashboard.manage_users') }}",
                    type: "GET",
                    data: { page: page, search: search },
                    success: function(res) {
                        let rows = "";
                        if (res.data.length > 0) {
                            $.each(res.data, function(i, user) {

                                let editUrl = route_edit.replace(':id', user.id);
                                let deleteUrl = route_delete.replace(':id', user.id);

                                rows += `
                                    <tr class="border-t hover:bg-gray-100 text-center">
                                        <td class="px-5 py-3">${(res.from + i)}</td>
                                        <td class="px-5 py-3">${user.nama}</td>
                                        <td class="px-5 py-3">${user.email}</td>
                                        <td class="px-5 py-3">${user.role_id ? user.role.nama_role : '-'}</td>
                                        <td class="px-5 py-3 flex justify-center gap-x-3">
                                            <a href="${editUrl}">
                                                <div class="bg-yellow-200 border rounded-full p-2  hover:bg-yellow-300 text-yellow-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </div>
                                            </a>
                                            <!-- DELETE -->
                                            <form action="${deleteUrl}" method="POST">
                                                <input type="hidden" name="_token" value="${csrfToken}">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <div class="bg-red-200 border flex items-center rounded-full p-2  hover:bg-red-300 text-red-600 ">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                    </div>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                `;
                            });
                        } else {
                            rows = `<tr><td colspan="5" class="text-center p-4">Tidak ada data</td></tr>`;
                        }
                        $("#userTable").html(rows);

                        // pagination
                        let pagination = "";
                        for (let i = 1; i <= res.last_page; i++) {
                            pagination += `<button data-page="${i}" class="px-3 py-1 border rounded ${i == res.current_page ? 'bg-blue-600 text-white' : ''}">${i}</button>`;
                        }
                        $("#pagination").html(pagination);
                    }
                });
            }

            // Load awal
            fetchUsers();

            // Search handler
            $('#search').on('keyup', function() {
                let search = $(this).val();
                fetchUsers(1, search);
            });

            // pagination click
            $(document).on("click", "#pagination button", function () {
                let page = $(this).data("page");
                currentPage = page;
                fetchUsers(page, query);
            });

        });
    </script>
@endsection
