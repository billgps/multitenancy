@extends('layouts.app')

@section('content')
<style>
    .select2-results__option, .select2-search__field {
        color: black;
        font-size: 0.75rem !important;
        line-height: 1rem !important;
    }

    .select2-container--default .select2-selection--single {
        --tw-text-opacity: 1 !important;
        color: rgba(55, 65, 81, var(--tw-text-opacity)) !important;
        padding-left: 1.25rem !important;
        padding-right: 1.25rem !important;
        padding-top: 0.25rem !important;
        padding-bottom: 0.25rem !important;
        outline: 2px solid transparent !important;
        outline-offset: 2px !important;
        border-style: none !important;
        border-radius: 0.25rem !important;
        --tw-bg-opacity: 1 !important;
        background-color: rgba(229, 231, 235, var(--tw-bg-opacity)) !important;
    }

    .select2-selection__rendered {
        text-align: left !important;
    }

    /* select {
        width: 50%;
    } */
</style>

<main class="flex sm:container sm:mx-auto sm:mt-10">
    <div class="mx-auto w-4/5 sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="flex flex-col break-words bg-white sm:border-1">

            <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                {{ __('Edit Device') }}
            </header>

            <form class="mx-auto pb-6 my-6" method="POST"
                action="{{ route('device.update', ['device' => $device->id]) }}">
                @csrf
                <div class="flex items-center w-full">
                    <div class="mx-4">
                        <label class="block mb-2 text-sm text-gray-00" for="standard_name">Nama Standar</label>
                        <div class="py-2 text-left flex items-center w-80">
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline4" id="standard_name" name="standard_name" type="text" value="{{ $device->standard_name }}" required>
                        </div>
                    </div>
                    <div class="mx-4">
                        <label class="block mb-2 text-sm text-gray-00 ml-4" for="alias_name">Nomenklatur</label>
                        <div class="py-2 text-left flex items-center w-96">
                            <a href="#map" rel="modal:open" onclick="getIndex()" class="mr-4">
                                <i class="fas fa-exchange"></i>
                            </a>
                            <input type="hidden" 
                            @isset($device->nomenclature)
                                value="{{ $device->nomenclature->id }}"
                            @endisset
                                id="nomenclature_id" name="nomenclature_id">
                            <input readonly 
                            @isset($device->nomenclature)
                                value="{{ $device->nomenclature->standard_name }}"
                            @endisset
                                id="nomenclature_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline4" type="text">
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap justify-center mt-12">
                    <input type="submit" value="{{ __('Update') }}" class="block text-center text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-48">
                </div>        
            </form>

        </section>
    </div>
</main>

<script>
    function getIndex() {
        // reset innerHTML for device name
        document.getElementById('deviceName').innerHTML = ""

        let standardName = document.getElementById('standard_name').value
        
        // set name in modal
        document.getElementById('deviceName').innerHTML = standardName
    }

    function getNomenclatureId(id) {
        let inputNomenclature = document.getElementById('nomenclature_name')
        inputNomenclature.value = id.standard_name
        let inputNomId = document.getElementById('nomenclature_id')
        inputNomId.value = id.id
    }
</script>

<div id="map" style="max-width: fit-content;" class="modal text-gray-600 w-1/2 flex items-center justify-center">
    <div class="flex justify-between items-center pb-3 text-lg">
        Find Nomenclature for <span id="deviceName"></span>
        <input type="hidden" id="row-index" value="">
    </div>
    <div class="flex relative mx-auto w-full">
        <input class="h-8 rounded-r-none text-xs text-gray-800 w-full px-2 rounded-md focus:ring-0 border-none" id="searchTerm" type="text" placeholder="Search..." name="search" />
        <button disabled type="button" class="h-8 rounded-l-none w-20 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:text-gray-800 hover:bg-gray-400 active:bg-gray-900 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">
            Search
        </button>
    </div>
    <div class="text-xs h-3/4 overflow-auto no-scrollbar py-3">
        <table class="rounded-t-lg mx-auto bg-white-200 text-gray-600" id="productsTable">
            <thead>
                <tr class="text-left border-b-2 border-gray-300">
                    <th class="px-4 text-sm text-center py-3">Nama Alat</th>
                    <th class="px-4 text-sm text-center py-3">Kode ASPAK</th>
                    <th class="px-4 text-sm py-3 text-center">Risk Level</th>
                    <th class="px-4 text-sm py-3"></th>
                </tr>
            </thead>
            <tbody class="text-base">
                @foreach ($nomenclatures as $nom)
                    <tr>
                        <td class="w-96 break-normal px-2 py-1 text-left ">{{ $nom->standard_name }}</td>
                        <td class="px-2 py-1 text-center ">{{ $nom->aspak_code }}</td>
                        <td class="px-2 py-1 text-center ">{{ $nom->risk_level }}</td>
                        <td class="">
                            <a href="#" rel="modal:close" onclick="getNomenclatureId({{ $nom }})" class="text-green-500 hover:text-gray-400">
                                <i class="fas fa-badge-check"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready( function () {
            let table = $('#productsTable').DataTable({
                dom: 'lrt',
                scrollY: "450px",
                // scrollCollapse: true,
                paging: false,
                info: false,
                lengthChange: false,
                order: [],
                columnDefs: [
                    {targets: [2, 3], orderable: false},
                ]
            });

            $('#searchTerm').keyup(function(){
                table.search($(this).val()).draw()
            })
        });
    </script>
</div>  
@endsection