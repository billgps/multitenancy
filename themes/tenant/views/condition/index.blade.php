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
                @if (Auth::user()->role < 2)
                    <a class="mx-2 text-green-600 hover:text-gray-400" href="{{ route('condition.create') }}">
                        <i class="fas fa-plus"></i>
                    </a>
                @endif
                @if (Auth::user()->role < 1)
                    <button @click="dropdownOpen = !dropdownOpen" class="relative z-10 block mx-2 text-blue-600 hover:text-gray-400">
                        <i class="fas fa-file-upload"></i>
                    </button>
                    <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

                    <div x-show="dropdownOpen" class="absolute top-28 left-48 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                        <a @click="dropdownOpen = false" href="#conditionImport" rel="modal:open" class="w-full text-left block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-400 hover:text-white">
                            Conditions
                        </a>       
                        <a @click="dropdownOpen = false" href="#worksheetImport" rel="modal:open" class="w-full text-left block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-400 hover:text-white">
                            Worksheets
                        </a>        
                    </div>

                    <div id="conditionImport" style="background-color: rgb(31, 41, 55);" class="modal text-gray-200 flex items-center justify-center">
                        <div class="flex justify-between items-center pb-3 text-lg">
                            Import Excel to Conditions
                        </div>
                        <form action="{{ route('condition.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="text-xs">
                                <div>
                                    <label class="block mb-2 text-sm text-gray-00" for="file">Conditions</label>
                                    <div class="py-2 text-left">
                                        <input id="file" name="file" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    </div>
                                </div>
                                <div class="flex w-full justify-end pt-2">
                                    <input type="submit" value="{{ __('Import') }}" class="block text-center text-white bg-green-600 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
                                </div>
                            </div>
                        </form>
                    </div>  
                    <div id="worksheetImport" style="background-color: rgb(31, 41, 55);" class="modal text-gray-200 flex items-center justify-center">
                        <div class="flex justify-between items-center pb-3 text-lg">
                            Upload Batch Worksheets
                        </div>
                        <form action="{{ route('condition.upload.worksheet') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="text-xs">
                                <div>
                                    <label class="block mb-2 text-sm text-gray-00" for="file">Worksheets</label>
                                    <div class="py-2 text-left">
                                        <input id="file" name="file" type="file">
                                    </div>
                                </div>
                                <div class="flex w-full justify-end pt-2">
                                    <input type="submit" value="{{ __('Import') }}" class="block text-center text-white bg-green-600 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
                                </div>
                            </div>
                        </form>
                    </div>  
                @endif    

                <div class="ml-auto my-auto flex text-xs">
                    <input class="h-8 rounded-r-none text-xs text-gray-800 w-full px-2 rounded-md focus:ring-0 border-none" id="search_" type="text" placeholder="Search..." name="search" />
                    <button type="button" class="h-8 rounded-l-none w-20 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:text-gray-800 hover:bg-gray-400 active:bg-gray-900 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">
                        Search
                    </button>
                </div>
            </div>
            <div class="flex flex-col sm:col-span-6 break-words bg-white sm:border-1">

                <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                    {{ __('Riwayat Kondisi') }}
                </header>   
                <div class="w-full px-6 py-3">
                    <table id="record" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6">ID Inventory</th>
                                <th class="py-3 px-6">Barcode</th>
                                <th class="py-3 px-6">Tanggal Kejadian</th>
                                <th class="py-3 px-6">Status Alat</th>
                                <th class="py-3 px-6">Lembar Kerja</th>
                                <th class="py-3 px-6">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($conditions as $condition)
                                <tr class="hover:bg-gray-100">
                                    <td class="py-3 px-6">
                                        {{ $condition->inventory_id }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $condition->inventory->device->standard_name }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $condition->event_date }}
                                    </td>
                                    <td class="py-3 px-6">
                                        @if ($condition->status == 'Baik')
                                            <div class="rounded bg-green-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                {{ $condition->status }}
                                            </div>
                                        @elseif($condition->status == 'Rusak')
                                            <div class="rounded bg-red-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                {{ $condition->status }}
                                            </div>
                                        @else
                                            <div class="rounded bg-yellow-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                {{ $condition->status }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6">
                                        <a href="{{ route('condition.download.worksheet', ['condition' => $condition->id]) }}">
                                            {{ $condition->worksheet }}
                                        </a>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('condition.show', ['condition' => $condition->id]) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                            @if (Auth::user()->role < 2)
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <a href="{{ route('condition.edit', ['condition' => $condition->id]) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            @endif
                                            @if (Auth::user()->role < 1)
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <a href="{{ route('condition.delete', ['condition' => $condition->id]) }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            @endif    
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 
                    <script>
                        $(document).ready(function() {
                            var table = $('#record').DataTable({
                                "pageLength": 15,
                                "ordering": true,
                                "info":     false,
                                "lengthChange": false,
                                "searching": true,
                                "paging":   true,
                                columnDefs: [
                                    { orderable: false, targets: -1 }
                                ],
                                "dom": 'lrtip'
                            });

                            drawPaginate()
            
                            $('#search_').keyup(function(){
                                table.search($(this).val()).draw()
                            })
            
                            $("#page").append($(".dataTables_paginate"));
            
                            $('#record').on( 'draw.dt', function () {
                                drawPaginate()
                            })

                            function drawPaginate() {
                                let prev = document.getElementsByClassName('previous')[0]
                                prev.classList.add('mr-3', 'cursor-pointer', 'hover:text-purple-500')
                                prev.innerHTML = '<i class="fas fa-chevron-left"></i>'
                
                                let next = document.getElementsByClassName('next')[0]
                                next.classList.add('ml-3', 'cursor-pointer', 'hover:text-purple-500')
                                next.innerHTML = '<i class="fas fa-chevron-right"></i>'
                
                                let page = document.getElementById('record_paginate').getElementsByTagName('span')[0].getElementsByClassName('paginate_button')
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

<script>    
    const overlay = document.querySelector('.modal-overlay')
    overlay.addEventListener('click', toggleModal)
    
    var closemodal = document.querySelectorAll('.modal-close')
    for (var i = 0; i < closemodal.length; i++) {
        closemodal[i].addEventListener('click', function(event){
            event.preventDefault()
            toggleModal(this)
        })
    }
    
    function toggleModal (button, toggle, modal) {
        const body = document.querySelector('body')
        if (button.classList.contains(toggle)) {
            modal = document.getElementById(modal)
        } 
        
        modal.classList.toggle('opacity-0')
        modal.classList.toggle('pointer-events-none')
        body.classList.toggle('modal-active')
    }
</script>
@endsection