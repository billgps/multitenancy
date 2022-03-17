@extends('layouts.app')

@section('content')
<main class="sm:container sm:mx-auto mt-6">
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="w-full flex justify-evenly">
            <div class="w-1/3 mb-3">
                <div class="bg-green-600 border shadow p-2">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pl-1 pr-4 text-white">
                            <i style="font-size: 46px;" class="material-icons">person_pin</i>
                        </div>
                        <div class="flex-1 text-right">
                            <h5 class="text-white">Total Tenant</h5>
                            <h3 class="text-white text-3xl">{{ $tenants->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-1/3 px-3 mb-3">
                <div class="bg-purple-600 border shadow p-2">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pl-1 pr-4 text-white">
                            <i style="font-size: 46px;" class="material-icons">analytics</i>
                        </div>
                        <div class="flex-1 text-right">
                            <h5 class="text-white">Data</h5>
                            <h3 class="text-white text-3xl">{{ array_sum($data) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-1/3 mb-3">
                <div class="bg-yellow-600 border shadow p-2">
                    <div class="flex flex-row items-center">
                        <div class="flex-shrink pl-1 pr-4 text-white">
                            <i style="font-size: 46px;" class="material-icons">cloud_done</i>
                        </div>
                        <div class="flex-1 text-right">
                            <h5 class="text-white">Terkirim ASPAK</h5>
                            <h3 class="text-white text-3xl">
                                {{ $queue }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="flex flex-col break-words bg-white sm:border-1 sm:shadow">
            <header class="px-6 py-5 flex font-semibold text-gray-700 bg-gray-200 sm:py-6 sm:px-8">
                Dashboard
            </header>
            <div class="w-full flex flex-col sm:p-6 overflow-x-scroll sm:overflow-x-auto">
                <span class="ml-auto my-3">
                    <div class="flex items-center max-w-md mx-auto bg-white rounded-lg " x-data="{ search: '' }">
                        <div class="w-full">
                            <input id="searchTerm" type="search" class="w-full px-4 py-1 text-gray-800 rounded-full outline-none ring-0 border-0 focus-within:border-0 focus:ring-0 focus:outline-none"
                                placeholder="Search..." x-model="search">
                        </div>
                        <div>
                            <button disabled type="submit" class="flex items-center bg-blue-500 justify-center w-10 h-10 text-white rounded-r-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </span>
                <table id="tenants" class="min-w-max w-full table-auto text-center">
                    <thead class="shadow">
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6">Nama Tenant</th>
                            <th class="py-3 px-6">Domain</th>
                            <th class="py-3 px-6">Jumlah Data</th>
                            <th class="py-3 px-6">Dibuat pada</th>
                            <th class="py-3 px-6">
                                <i class="material-icons">settings</i>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($tenants as $key => $tenant)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left">
                                    {{ $tenant->name }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    @if ($tenant->is_active)
                                        <i class="fas fa-circle text-green-500 mr-2 md:ml-24"></i>
                                    @else
                                        <i class="fas fa-circle text-red-500 mr-2 md:ml-24"></i>
                                    @endif
                                    <a href="http://{{ $tenant->domain }}" target="blank_">
                                        {{ $tenant->domain }}
                                    </a>
                                </td>
                                <td class="py-3 px-6">
                                    {{ $data[$key] }}
                                </td>
                                <td class="py-3 px-6">
                                    {{ $tenant->created_at }}
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <div class="w-4 mr-2 transform hover:text-gray-500 text-blue-500 hover:scale-110">
                                            <a href="http://{{ $tenant->domain }}" target="blank_">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                        <div class="w-4 mr-2 transform hover:text-gray-500 text-green-500 hover:scale-110">
                                            <a href="">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                        <div class="w-4 mr-2 transform hover:text-gray-500 text-red-500 hover:scale-110">
                                            <a href="{{ route('tenant.delete', ['tenant' => $tenant->id]) }}"
                                                onclick="return confirm('Are you sure you want to delete this tenant? Deleted data cannot be recovered!')">
                                                <i class="delete fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <script>
                    $(document).ready( function () {
                        let table = $('#tenants').DataTable({
                            dom: 'lrtp',
                            pageLength: 20,
                            info: false,
                            lengthChange: false,
                            order: [],
                            columnDefs: [
                                {targets: [4], orderable: false},
                            ]
                        });

                        $('#searchTerm').keyup(function(){
                            table.search($(this).val()).draw() ;
                        })
                    } );
                </script>
            </div>
        </section>
    </div>
</main>
@endsection
