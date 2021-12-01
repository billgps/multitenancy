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
            <div class="col-span-6 h-12 flex items-center py-2 px-4 bg-gray-200">
                {{-- @if (Auth::user()->role < 2)
                    <a class="mx-2 text-green-600 hover:text-gray-400" href="{{ route('device.create') }}">
                        <i class="fas fa-plus"></i>
                    </a>
                @endif
                @if (Auth::user()->role < 1)
                    <button onclick="toggleModal(this, 'import-toggle', 'import-modal')" class="mx-2 text-blue-600 hover:text-gray-400 modal-open import-toggle">
                        <i class="fas fa-file-upload"></i>
                    </button>   
                @endif
                <a class="mx-2 text-blue-600 hover:text-gray-400" href="{{ route('device.export') }}">
                    <i class="fas fa-download"></i>
                </a> --}}
                <div class="ml-auto my-auto flex text-xs">
                    <input class="h-8 rounded-r-none text-xs text-gray-800 w-full px-2 rounded-md focus:ring-0 border-none" id="search_" type="text" placeholder="Search..." name="search" />
                    <button type="button" class="h-8 rounded-l-none w-20 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:text-gray-800 hover:bg-gray-400 active:bg-gray-900 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">
                        Search
                    </button>
                </div>
            </div>
            <div class="flex flex-col sm:col-span-6 break-words bg-white sm:border-1">

                <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                    {{ __('Daftar Nama Alat') }}
                </header>   
                <div class="w-full px-6 py-3">
                    <table id="device" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6">Nama Alat</th>
                                <th class="py-3 px-6">Barcode</th>
                                <th class="py-3 px-6">Merk</th>
                                <th class="py-3 px-6">Model</th>
                                <th class="py-3 px-6">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($invo->inventories as $i)
                                <tr class="hover:bg-gray-100">
                                    <td class="py-3 px-6 items-start text-left">
                                        {{ $invo->standard_name }}
                                    </td>
                                    <td class="py-3 px-6 items-start">
                                        {{ $i->barcode }}
                                    </td>
                                    <td class="py-3 px-6 items-start">
                                        {{ $i->brand->brand }}
                                    </td>
                                    <td class="py-3 px-6 items-start">
                                        {{ $i->identity->model }}
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <button id="{{ $i->id }}" onclick="getNomenclature(this, 'nomenclature-toggle', 'nomenclature-modal')" class="mx-2 modal-open nomenclature-toggle">
                                                    <i class="fas fa-search"></i>
                                                </button>   
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 
                    <script>
                        $(document).ready(function() {
                            var table = $('#device').DataTable({
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
            
                            $('#device').on( 'draw.dt', function () {
                                drawPaginate()
                            })

                            function drawPaginate() {
                                let prev = document.getElementsByClassName('previous')[0]
                                prev.classList.add('mr-3', 'cursor-pointer', 'hover:text-purple-500')
                                prev.innerHTML = '<i class="fas fa-chevron-left"></i>'
                
                                let next = document.getElementsByClassName('next')[0]
                                next.classList.add('ml-3', 'cursor-pointer', 'hover:text-purple-500')
                                next.innerHTML = '<i class="fas fa-chevron-right"></i>'
                
                                let page = document.getElementById('device_paginate').getElementsByTagName('span')[0].getElementsByClassName('paginate_button')
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

<div id="nomenclature-modal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-gray-800 text-gray-300 w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3 text-lg">
                Referensi Nomenklatur ASPAK
            </div>
            <form action="{{ route('device.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="text-xs">
                    <div class="flex flex-col col-span-2">
                        <label class="block text-sm text-gray-00" for="device_id">Pencarian Manual</label>
                        <div class="py-2 text-left">
                            <select style="width: 90%;" id="nomenclature_code" class="text-sm bg-gray-20 focus:outline-none block w-full px-3">
                                <option></option>
                                @foreach ($nomenclatures as $n)
                                    <option value="{{ $n->code }}">{{ $n->name }}</option>
                                @endforeach
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#nomenclature_code').select2({
                                        placeholder: 'Select Nomenclature'
                                    });
                                });
                            </script>
                        </div>
                    </div>
                    <div class="flex w-full justify-end pt-2">
                        <input type="submit" value="{{ __('Upload') }}" class="block text-center text-white bg-gray-700 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
                        <button onclick="toggleModal(this, 'nomenclature-toggle', 'nomenclature-modal')" type="button" class="modal-close nomenclature-toggle block text-center text-white bg-red-600 p-3 duration-300 rounded-sm hover:bg-red-700 w-full sm:w-24 mx-2">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

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
        console.log(button.id);
        const body = document.querySelector('body')
        if (button.classList.contains(toggle)) {
            modal = document.getElementById(modal)
        } 
        
        modal.classList.toggle('opacity-0')
        modal.classList.toggle('pointer-events-none')
        body.classList.toggle('modal-active')
    }

    $(document).ready(function() {
        let details = document.querySelectorAll('.detail-toggle.modal-open')
        for (let i = 0; i < details.length; i++) {
            details[i].addEventListener('click', function (event) {
                event.preventDefault()
                getDetails(this, 'detail-toggle', 'detail-modal')
            })
        }

        let nomenclatures = document.querySelectorAll('.nomenclature-toggle.modal-open')
        for (let i = 0; i < nomenclatures.length; i++) {
            nomenclatures[i].addEventListener('click', function (event) {
                event.preventDefault()
                getNomenclature(this, 'nomenclature-toggle', 'nomenclature-modal')
            })
        }

        function getNomenclature(button, toggle, modal) {
            $.ajax({
                type: "GET",
                url: "/ajax/aspak-map/" + button.id,
                success: function (data) {
                    console.log(data);
                    toggleModal(button, toggle, modal)
                },
                error: function (error) {
                    console.log(error)
                }
            })
        }
    })
</script>
@endsection