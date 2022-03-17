@extends('layouts.app')

@section('content')
<style>
    .progress {
        background: rgba(255,255,255,0.1);
        justify-content: flex-start;
        border-radius: 100px;
        align-items: center;
        position: relative;
        padding: 0 5px;
        display: flex;
        height: 40px;
        width: 200px;
    }

    .progress-value {
        /* animation: load 3s normal forwards; */
        border-radius: 100px;
        background: rgb(0, 143, 0);
        height: 20px;
        width: 100%;
    }

    /* @keyframes load {
        0% { width: 0; }
        100% { width: 68%; }
    } */
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
                                <th class="py-3 px-6">Map</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($devices as $device)
                                <tr class="hover:bg-gray-100">
                                    <td class="py-3 px-6 items-start text-left">
                                        @if ($device->mapped == $device->total)
                                            <span class="w-4 mr-2 transform hover:text-purple-500">
                                                <i class="text-green-500 mx-2 fas fa-circle"></i>
                                            </span>
                                        @elseif ($device->mapped < $device->total && $device->mapped > 0)
                                            <span class="w-4 mr-2 transform hover:text-purple-500">
                                                <i class="text-yellow-500 mx-2 fas fa-circle"></i>
                                            </span>
                                        @else
                                            <span class="w-4 mr-2 transform hover:text-purple-500">
                                                <i class="text-red-500 mx-2 fas fa-circle"></i>
                                            </span>
                                        @endif
                                        {{ $device->standard_name }}
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="progress mx-auto">
                                            <div class="progress-value flex" style="width: {{ ($device->mapped * 100) / $device->total }}%">
                                                @if ($device->mapped == 0)
                                                <p class="text-xs mx-auto font-semibold my-auto text-gray-600">
                                                    {{ $device->mapped.'/'.$device->total }}
                                                </p>
                                                @else
                                                <p class="text-xs mx-auto font-semibold my-auto text-white">
                                                    {{ $device->mapped.'/'.$device->total }}
                                                </p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            {{-- <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('aspak.create', ['id' => $device->id]) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div> --}}
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="#nomenclature" rel="modal:open" id="{{ $device->id }}" onclick="getNomenclature(this)" class="mx-2 modal-open nomenclature-toggle">
                                                    <i class="fas fa-search"></i>
                                                </a>   
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
                                "ordering": true,
                                "info":     false,
                                "lengthChange": false,
                                "searching": true,
                                "paging":   false,
                                columnDefs: [
                                    { orderable: false, targets: -1 }
                                ],
                                "dom": 'lrtip'
                            });
            
                            $('#search_').keyup(function(){
                                table.search($(this).val()).draw()
                            })
                        })
                    </script>
                </div>
            </div>
        </section>
    </div>
</main>

<div id="nomenclature" style="background-color: rgb(31, 41, 55); max-width: 600px; padding-left: 0px; padding-right: 0px;" class="modal text-gray-200 flex items-center justify-center">
    <div class="flex justify-between w-full items-center pb-3 px-6 text-lg">
        Referensi Nomenklatur ASPAK
    </div>
    <form action="{{ route('aspak.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="input_parameter" value="device">
        <input id="device_id" name="id" type="hidden" value="">
        <input id="code_suggested" type="hidden" name="code_" value="">
        <div class="text-xs">
            <div class="flex flex-col col-span-2">
                <span class="text-sm my-3 text-center">Pick from <span class="font-semibold">Suggested Nomenclatures,</span> 
                    <span class="text-center my-6"> or  
                        <a href="#manual" rel="modal:open" onclick="manualModal(this)" class="hover:text-purple-500 modal-open manual-toggle">Search Manually</a>
                    </span>
                </span>
                <div class="h-96 my-6 mx-6 overflow-y-auto no-scrollbar">
                    <div id="suggestionList" class="flex flex-col w-full text-base font-light">
                    </div>
                </div>
            </div>
            <div class="flex w-full justify-end pt-2">
                <input type="submit" value="{{ __('Submit') }}" class="block text-center text-white bg-green-600 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
            </div>
        </div>
    </form>
</div>  

<div id="manual" style="background-color: rgb(31, 41, 55); width: 100%;" class="modal text-gray-200 flex items-center justify-center">
    <div class="flex justify-between items-center pb-3 text-lg">
        Manual Search
    </div>
    <form action="{{ route('aspak.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="input_parameter" value="device">
        <input id="device_id_manual" name="id" type="hidden" value="">
        <div class="text-xs">
            <div class="flex flex-col col-span-2">
                <div class="py-2 w-full">
                    <select style="width: 100%;" id="nomenclature_code" name="code_" class="text-center text-sm bg-gray-20 focus:outline-none block w-full px-3">
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
                <input type="submit" value="{{ __('Submit') }}" class="block text-center text-white bg-green-600 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
            </div>
        </div>
    </form>
</div>  

<script>    
    function manualModal(button) {
        document.getElementById('device_id_manual').value = document.getElementById('device_id').value
    }

    function getNomenclature(button) {
        $.ajax({
            type: "GET",
            url: "/ajax/aspak-map/" + button.id,
            success: function (data) {
                let list = document.getElementById('suggestionList')
                list.innerHTML = ''
                if (data.data.length > 0) {
                    for (let i = 0; i < data.data.length; i++) {
                        list.innerHTML += populateRow(data.data[i])             
                    }
                } else {
                    let par = document.createElement('span')
                    par.classList.add('text-center', 'flex', 'justify-center', 'mt-6')
                    par.innerHTML = 'No Suggested Entry'

                    list.appendChild(par)
                }

                document.getElementById('device_id').value = button.id
            },
            error: function (error) {
                // console.log(error)
                swal("Error!", "Server responded with code " + error.status, "error");
            }
        })
    }

    function populateRow (data) {
        return '<button onclick="selectSuggestion(\''+data.code+'\')" type="button" class="suggestions pl-8 py-2 text-gray-200 hover:text-purple-500 focus:text-purple-500 focus:outline-none w-full border-l-2 border-gray-700 hover:border-purple-500 focus:border-purple-500">'+
                    '<span class="flex items-center text-left">'+
                        '<span class="ml-4 capitalize">'+data.name+'</span>'+
                    '</span>'+
            '</button>'
    }

    function selectSuggestion (code) {
        document.getElementById('code_suggested').value = code
    }

    function toggleDisable (toggle) {
        let radios = document.getElementsByClassName('form-radio')
        for (let i = 0; i < radios.length; i++) {
            radios[i].disabled = toggle                
        }

        let manual = document.getElementById('nomenclature_code')
        manual.disabled = !toggle
        manual.hidden = !toggle
    }
</script>
@endsection