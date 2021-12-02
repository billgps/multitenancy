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
                                <th class="py-3 px-6">Tersinkron</th>
                                <th class="py-3 px-6">Jumlah</th>
                                <th class="py-3 px-6">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($devices as $device)
                                <tr class="hover:bg-gray-100">
                                    <td class="py-3 px-6 items-start text-left">
                                        @if ($device->mapped == $device->total)
                                            <span class="w-4 mr-2 transform hover:text-purple-500">
                                                <i class="text-green-500 mx-2 far fa-circle"></i>
                                            </span>
                                        @elseif ($device->mapped < $device->total && $device->mapped > 0)
                                            <span class="w-4 mr-2 transform hover:text-purple-500">
                                                <i class="text-yellow-500 mx-2 far fa-circle"></i>
                                            </span>
                                        @else
                                            <span class="w-4 mr-2 transform hover:text-purple-500">
                                                <i class="text-red-500 mx-2 far fa-circle"></i>
                                            </span>
                                        @endif
                                        {{ $device->standard_name }}
                                    </td>
                                    <td class="py-3 px-6 text-center text-green-500">
                                        {{ $device->mapped }}
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        {{ $device->total }}
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('aspak.create', ['id' => $device->id]) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <button id="{{ $device->id }}" onclick="getNomenclature(this, 'nomenclature-toggle', 'nomenclature-modal')" class="mx-2 modal-open nomenclature-toggle">
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
    <div class="modal-container bg-gray-800 text-gray-300 w-2/5 mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3 text-lg">
                Referensi Nomenklatur ASPAK
            </div>
            <form action="{{ route('aspak.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="input_parameter" value="device">
                <input id="device_id" name="id" type="hidden" value="">
                <div class="text-xs">
                    <div class="flex flex-col col-span-2">
                        <span class="text-center my-6"> Suggested Nomenclatures </span>
                        <div id="suggestionList" class="w-full h-80 overflow-y-auto">
                            <div class="flex my-1">
                                <div class="w-4/5 h-10 py-3 px-1">
                                </div>
                                <div class="w-1/5 h-10 text-right p-3">
                                    <p class="text-sm text-grey-dark">Member</p>
                                </div>
                            </div>
                        </div>
                        <span class="text-center my-6"> or  
                            <button type="button" id="disableToggle">Search Manually</button>
                        </span>
                        {{-- <label class="block text-sm text-gray-00" for="device_id">Pencarian Manual</label> --}}
                        <div class="py-2 w-80">
                            <select disabled style="width: 90%;" id="nomenclature_code" name="code_" class="text-center text-sm bg-gray-20 focus:outline-none block w-full px-3">
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
                        <input type="submit" value="{{ __('Submit') }}" class="block text-center text-white bg-gray-700 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
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
        const body = document.querySelector('body')
        if (button.classList.contains(toggle)) {
            modal = document.getElementById(modal)
        } 
        
        modal.classList.toggle('opacity-0')
        modal.classList.toggle('pointer-events-none')
        body.classList.toggle('modal-active')
    }

    $(document).ready(function() {
        let nomenclatures = document.querySelectorAll('.nomenclature-toggle.modal-open')
        for (let i = 0; i < nomenclatures.length; i++) {
            nomenclatures[i].addEventListener('click', function (event) {
                event.preventDefault()
                getNomenclature(this, 'nomenclature-toggle', 'nomenclature-modal')
            })
        }

        let toggleBtn = document.getElementById('disableToggle')
        toggleBtn.onclick = function () {
            toggleDisable(document.getElementById('nomenclature_code').disabled)
        }

        function getNomenclature(button, toggle, modal) {
            $.ajax({
                type: "GET",
                url: "/ajax/aspak-map/" + button.id,
                success: function (data) {
                    console.log(data);
                    let list = document.getElementById('suggestionList')
                    list.innerHTML = ''
                    for (let i = 0; i < data.data.length; i++) {
                        populateRow(list, data.data[i])                        
                    }
                    document.getElementById('device_id').value = button.id
                    toggleModal(button, toggle, modal)
                },
                error: function (error) {
                    console.log(error)
                }
            })
        }

        function populateRow (list, data) {
            let container = document.createElement('div')
            container.classList.add('flex', 'my-1')

            let text = document.createElement('div')
            text.classList.add('w-4/5', 'h-10', 'py-3', 'px-1')
            text.innerHTML = data.name

            let button = document.createElement('input')
            button.type = 'radio'
            button.classList.add('form-radio', 'h-5', 'w-5', 'my-2', 'text-gray-600')
            button.name = 'code_'
            button.value = data.code

            container.appendChild(text)
            container.appendChild(button)
            list.appendChild(container)
        }

        function toggleDisable (toggle) {
            let radios = document.getElementsByClassName('form-radio')
            for (let i = 0; i < radios.length; i++) {
                radios[i].disabled = toggle                
            }

            let manual = document.getElementById('nomenclature_code')
            manual.disabled = !toggle
        }
    })
</script>
@endsection