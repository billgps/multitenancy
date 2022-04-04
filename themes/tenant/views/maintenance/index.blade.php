@extends('layouts.app')

@section('content')
<main class="sm:container sm:mx-auto sm:mt-6 overflow-y-auto">
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="sm:grid sm:grid-cols-6 sm:gap-2 break-words">
            <div class="col-span-6 h-12 flex items-center py-2 px-4 bg-gray-200" x-data="{ dropdownOpen: false }">
                <div class="ml-auto my-auto flex text-xs">
                    <input class="h-8 rounded-r-none text-xs text-gray-800 w-full px-2 rounded-md focus:ring-0 border-none" id="search_" type="text" placeholder="Search..." name="search" />
                    <button type="button" class="h-8 rounded-l-none w-20 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:text-gray-800 hover:bg-gray-400 active:bg-gray-900 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">
                        Search
                    </button>
                </div>
            </div>
            <div class="flex flex-col sm:col-span-6 break-words bg-white sm:border-1">
                <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                    {{ __('Riwayat Preventive Maintenance') }}
                </header>   
                <div class="w-full px-6 py-3">
                    <table id="maintenance" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th></th>
                                <th class="py-3 px-6">Nama Alat</th>
                                <th class="py-3 px-6">No Label</th>
                                <th class="py-3 px-6">Tanggal Pengerjaan</th>
                                <th class="py-3 px-6">Petugas</th>
                                <th class="py-3 px-6">Action</th>
                                <th>barcode</th>
                                <th>merk</th>
                                <th>model</th>
                                <th>result</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($maintenances as $m)
                                <tr class="hover:bg-gray-100">
                                    <td class="dt-control"></td>
                                    <td class="py-3 px-3 text-left flex-nowrap">
                                        {{ $m->inventory->device->standard_name }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $m->inventory->latest_record->label }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $m->created_at }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $m->user->name }}
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('inventory.show', ['id' => $m->inventory_id]) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('maintenance.download', ['maintenance' => $m->id]) }}">
                                                    <i class="fas fa-file-alt"></i>
                                                </a>
                                            </div>
                                            @if (Auth::user()->role < 2)
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <a href="{{ route('maintenance.edit', ['maintenance' => $m->id]) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            @endif
                                            @if (Auth::user()->role < 1)
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <a href="{{ route('maintenance.delete', ['maintenance' => $m->id]) }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        {{ $m->inventory->barcode }}
                                    </td>
                                    <td>
                                        {{ $m->inventory->identity->brand->brand }}
                                    </td>
                                    <td>
                                        {{ $m->inventory->identity->model }}
                                    </td>
                                    <td>
                                        @if ($m->result == 'Alat Bekerja dengan Baik')
                                            <div class="rounded w-max bg-green-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                {{ $m->result }}
                                            </div>
                                        @else
                                            <div class="rounded w-max bg-red-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                {{ $m->result }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 
                    <script>
                        function format ( d ) {
                            return '<table class="pl-6 text-sm text-left">'+
                                '<tr class="p-0">'+
                                    '<td>Nama Alat :</td>'+
                                    '<td>'+d[1]+'</td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td>No Label :</td>'+
                                    '<td>'+d[2]+'</td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td>Barcode :</td>'+
                                    '<td>'+d[3]+'</td>'+
                                '</tr>'+
                                '<tr class="p-0">'+
                                    '<td>Merk :</td>'+
                                    '<td>'+d[7]+'</td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td>Model :</td>'+
                                    '<td>'+d[8]+'</td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<td>Hasil :</td>'+
                                    '<td>'+d[9]+'</td>'+
                                '</tr>'+

                            '</table>';
                        }

                        $(document).ready(function() {
                            var table = $('#maintenance').DataTable({
                                "pageLength": 15,
                                "ordering": true,
                                "info":     false,
                                "lengthChange": false,
                                "searching": true,
                                "paging":   true,
                                "order": [[3, 'desc']],
                                columnDefs: [
                                    { orderable: false, targets: 5 },
                                    { targets: [6, 7, 8, 9], orderable:false, visible: false }
                                ],
                                "dom": 'lrtip'
                            });

                            $('#maintenance tbody').on('click', 'td.dt-control', function () {
                                let tr = $(this).closest('tr');
                                let row = table.row( tr );
                        
                                if ( row.child.isShown() ) {
                                    row.child.hide();
                                    tr.removeClass('shown');
                                }
                                else {
                                    row.child( format(row.data()) ).show();
                                    tr.addClass('shown');
                                }
                            });

                            drawPaginate()
            
                            $('#search_').keyup(function(){
                                table.search($(this).val()).draw()
                            })
            
                            $("#page").append($(".dataTables_paginate"));
            
                            $('#maintenance').on( 'draw.dt', function () {
                                drawPaginate()
                            })

                            function drawPaginate() {
                                let prev = document.getElementsByClassName('previous')[0]
                                prev.classList.add('mr-3', 'cursor-pointer', 'hover:text-purple-500')
                                prev.innerHTML = '<i class="fas fa-chevron-left"></i>'
                
                                let next = document.getElementsByClassName('next')[0]
                                next.classList.add('ml-3', 'cursor-pointer', 'hover:text-purple-500')
                                next.innerHTML = '<i class="fas fa-chevron-right"></i>'
                
                                let page = document.getElementById('maintenance_paginate').getElementsByTagName('span')[0].getElementsByClassName('paginate_button')
                                for (let i = 0; i < page.length; i++) {
                                    if (page[i].classList.contains('current')) {
                                        page[i].classList.add('mx-1', 'text-purple-500')                    
                                    }
                                    page[i].classList.add('mx-1', 'cursor-pointer', 'hover:text-purple-500')                    
                                }
                            }
                        })
                    </script>
                    <div class="mt-3 w-full h-20 flex justify-center text-sm p-2" id="page"></div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection