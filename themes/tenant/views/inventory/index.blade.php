@extends('layouts.app')

@section('content')
<style>
    canvas {
        width: 100%;
        height: 100%;
    }
</style>
<main class="sm:container sm:mx-auto sm:mt-6 overflow-y-auto">
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="sm:grid sm:grid-cols-6 sm:gap-2 break-words">
            <div class="col-span-6 h-12 flex items-center py-2 px-4 bg-gray-200">
                <a class="mx-2 text-green-600 hover:text-gray-400" href="{{ route('inventory.create') }}">
                    <i class="fas fa-plus"></i>
                </a>
                <button class="mx-2 text-yellow-600 hover:text-gray-400 modal-open image-toggle">
                    <i class="fas fa-images"></i>
                </button>        
                <div class="ml-auto my-auto flex text-xs">
                    <input class="h-8 rounded-r-none text-xs text-gray-800 w-full px-2 rounded-md focus:ring-0 border-none" id="search_" type="text" placeholder="Search..." name="search" />
                    <button type="button" class="h-8 rounded-l-none w-20 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:text-gray-800 hover:bg-gray-400 active:bg-gray-900 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">
                        Search
                    </button>
                </div>
            </div>
            <div class="col-span-6 flex w-full p-4 bg-gray-200">
                <div class="w-full justify-center text-gray-600">
                    <div class="text-md">
                        Data Inventaris
                    </div>
                    <table class="hidden" id="example" style="display: none;">
                        <thead>
                            <th>name</th>
                            <th>condition</th>
                            <th>barcode</th>
                            <th>brand</th>
                            <th>model</th>
                            <th>serial</th>
                            <th>room</th>
                            <th>calibration_status</th>
                            <th>image</th>
                            <th>action</th>
                        </thead>
                        <tbody>
                            @foreach ($inventories as $inventory)
                                <tr>
                                    <td>
                                        <div class="text-md flex hover:text-purple-500 mx-2 my-2">
                                            <a href="#">
                                                {{ $inventory->device->standard_name }}
                                            </a>
                                        </div>
                                    </td>
                                    @if ($inventory->latest_condition)
                                        <td>
                                            <div class="flex mb-2 mx-2">
                                                @if ($inventory->latest_condition->status != 'Rusak')
                                                    @if ($inventory->latest_condition->status == 'Baik')
                                                        <div class="rounded bg-green-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                            {{ $inventory->latest_condition->status }}
                                                        </div>
                                                    @else
                                                        <div class="rounded bg-yellow-300 text-gray-800 py-1 px-3 text-xs font-bold">
                                                            Belum Update
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="rounded bg-red-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                        {{ $inventory->latest_condition->status }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    @else
                                        <td>
                                            <div class="flex mb-2 mx-2">
                                                <div class="rounded bg-yellow-300 text-gray-800 py-1 px-3 text-xs font-bold">
                                                    Belum Update
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                    <td>
                                        <div class="flex justify-end text-right">
                                            {{ $inventory->barcode }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex justify-end hover:text-purple-500 text-right">
                                            <a href="#">
                                                {{ $inventory->brand->brand }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex justify-end text-right">
                                            {{ $inventory->identity->model }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex justify-end text-right">
                                            {{ $inventory->serial }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex justify-end hover:text-purple-500 text-right">
                                            <a href="#">
                                                {{ $inventory->room->room_name }}
                                            </a>
                                        </div>
                                    </td>
                                    @if ($inventory->latest_record)
                                        <td>
                                            <div class="flex justify-end text-right">
                                                @if ($inventory->latest_record->calibration_status != 'Wajib Kalibrasi')
                                                    <div class="rounded bg-green-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                        Terkalibrasi
                                                    </div>
                                                @else
                                                    <div class="rounded bg-yellow-300 text-gray-800 py-1 px-3 text-xs font-bold">
                                                        Wajib Kalibrasi
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    @else
                                        <td>
                                            <div class="flex justify-end text-right">
                                                <div class="rounded bg-yellow-300 text-gray-800 py-1 px-3 text-xs font-bold">
                                                    Wajib Kalibrasi
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                    <td>
                                        <div class="w-ful h-48 text-sm">
                                            <img class="object-cover" src="{{ asset('images/'.$inventory->picture) }}" alt="{{ $inventory->barcode }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="px-6 py-4 mt-auto">
                                            <div class="flex item-end justify-center">
                                                <a href="#">
                                                    <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </div>
                                                </a>
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </div>
                                                @if (Auth::user()->role == 0)
                                                    <a href="#">
                                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </div>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            
                    <script>
                        $(document).ready(function() {
                            var table = $('#example').DataTable({
                                "pageLength": 16,
                                "ordering": false,
                                "info":     false,
                            });
            
                            var container = document.getElementById('display')
                            let rows = table.rows({ page: 'current' }).data()
                            fetchData(rows)
            
                            $('#search_').keyup(function(){
                                table.search($(this).val()).draw()
                            })
            
                            $('#example').on( 'search.dt', function () {
                                rows = table.rows( { search: 'applied' } ).data()
                                container.innerHTML = ''
            
                                fetchData(rows)
                            })
            
                            function fetchData(rows) {
                                for (let i = 0; i < rows.length; i++) {                      
                                    var card = document.createElement('div')
                                    card.classList.add('max-w-xs', 'flex', 'flex-col', 'rounded', 'overflow-hidden', 'bg-gray-100', 'my-2')
                                    card.innerHTML = rows[i][8]
                                    card.innerHTML += rows[i][0]
                                    card.innerHTML += rows[i][1]
            
                                    var grid = document.createElement('div')
                                    grid.classList.add('grid', 'grid-cols-2', 'gap-2', 'w-full', 'text-xs', 'px-2')
                                    card.appendChild(grid)
            
                                    var array = ['Barcode', 'Merk', 'Model', 'Serial Number', 'Ruangan', 'Status Kalibrasi']
            
                                    for (let j = 0; j < 6; j++) {
                                        var label = document.createElement('div')
                                        label.classList.add('flex')
                                        label.innerHTML = array[j] + ' :'
            
                                        grid.appendChild(label)
            
                                        grid.innerHTML += rows[i][j + 2]
                                    }
            
                                    card.innerHTML += rows[i][9]
            
                                    container.appendChild(card)                
                                }
                            }

                            if (rows.length > 0) {
                                console.log(rows.length);

                                $("#page").append($(".dataTables_paginate"));
                                let prev = document.getElementsByClassName('previous')[0]
                                prev.classList.add('mr-3', 'cursor-pointer', 'hover:text-purple-500')
                                prev.innerHTML = '<i class="fas fa-chevron-left"></i>'
                
                                let next = document.getElementsByClassName('next')[0]
                                next.classList.add('ml-3', 'cursor-pointer', 'hover:text-purple-500')
                                next.innerHTML = '<i class="fas fa-chevron-right"></i>'
                
                                let page = document.getElementById('example_paginate').getElementsByTagName('span')[0].getElementsByClassName('paginate_button')
                                for (let i = 0; i < page.length; i++) {
                                    if (page[i].classList.contains('current')) {
                                        page[i].classList.add('mx-1', 'text-purple-500')                    
                                    }
                                    page[i].classList.add('mx-1', 'cursor-pointer', 'hover:text-purple-500')                    
                                }
                
                                $('#example').on( 'page.dt', function () {
                                    rows = table.rows( { page: 'current' } ).data()
                                    container.innerHTML = ''
                
                                    fetchData(rows)
                                })
                
                                $('#example').on( 'draw.dt', function () {
                                    prev = document.getElementsByClassName('previous')[0]
                                    prev.classList.add('mr-3', 'cursor-pointer', 'hover:text-purple-500')
                                    prev.innerHTML = '<i class="fas fa-chevron-left"></i>'
                
                                    next = document.getElementsByClassName('next')[0]
                                    next.classList.add('ml-3', 'cursor-pointer', 'hover:text-purple-500')
                                    next.innerHTML = '<i class="fas fa-chevron-right"></i>'
                
                                    page = document.getElementById('example_paginate').getElementsByTagName('span')[0].getElementsByClassName('paginate_button')
                                    for (let i = 0; i < page.length; i++) {
                                        if (page[i].classList.contains('current')) {
                                            page[i].classList.add('mx-1', 'text-purple-500')                    
                                        }
                                        page[i].classList.add('mx-1', 'cursor-pointer', 'hover:text-purple-500')                    
                                    }
                                })   
                            }
                        })
                    </script>
            
                    <div id="display" class="grid lg:grid-cols-4 gap-2 w-full justify-center"></div>
                    <div class="mt-3 w-full h-20 flex justify-center text-sm p-2" id="page"></div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection