@extends('layouts.app')

@section('content')
<style>
    .select2-results__option, .select2-search__field, .select2-selection__rendered {
        color: black;
        font-size: 0.875rem;
        line-height: 1.25rem;
    }

    .select2-selection__rendered {
        text-align: left !important;
    }

    .select2-selection, .select2-selection--single {
        height: 32px !important;
    }
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
                {{ __('Create New Identiy') }}
            </header>

            <form enctype="multipart/form-data" class="w-3/5 mx-auto pb-6 my-6" method="POST"
                action="{{ route('identity.store') }}">
                @csrf
                <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-6">
                    <div class="">
                        <label class="block text-sm text-gray-00" for="device_id">Nama Alat</label>
                        <div class="py-2 text-left flex">
                            <select style="width: 90%;" id="device_id" name="device_id" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4">
                                <option></option>
                                @foreach ($devices as $device)
                                    <option value="{{ $device->id }}">{{ $device->standard_name }}</option>
                                @endforeach
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#device_id').select2({
                                        placeholder: 'Select Device'
                                    });
                                });
                            </script>
                            <a href="#deviceModal" rel="modal:open" class="mx-2 my-2 text-green-600 hover:text-purple-500">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="">
                        <label class="block text-sm text-gray-00" for="brand_id">Merk</label>
                        <div class="py-2 text-left flex">
                            <select style="width: 90%;" id="brand_id" name="brand_id" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4">
                                <option value=""></option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->brand }}</option>
                                @endforeach
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#brand_id').select2({
                                        placeholder: 'Select Brand'
                                    });
                                });
                            </script>
                            <a href="#brandModal" rel="modal:open" class="mx-2 my-2 text-green-600 hover:text-purple-500">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="model">Tipe Alat</label>
                        <div class="py-2 text-left">
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="model" name="model" type="text" required>
                        </div>
                    </div>
                    <div class="row-start-3">
                        <label class="block mb-2 text-sm text-gray-00" for="manual">Manual Book</label>
                        <div class="py-2 text-left">
                            <input class="" id="manual" name="manual" type="file">
                        </div>
                    </div>
                    <div class="row-start-3">
                        <label class="block mb-2 text-sm text-gray-00" for="procedure">Prosedur</label>
                        <div class="py-2 text-left">
                            <input class="" id="procedure" name="procedure" type="file">
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap justify-center mt-12">
                    <input type="submit" value="{{ __('Submit') }}" class="block text-center text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-48">
                </div>        
            </form>

        </section>
    </div>
</main>


<div id="deviceModal" style="max-width: fit-content; background-color: rgb(31, 41, 55);" class="modal text-gray-200 flex items-center justify-center w-11/12">
    <div class="flex justify-between items-center pb-3 text-lg">
        Create New Device
    </div>
    <form class="mx-auto pb-6 my-6" method="POST"
        action="{{ route('device.store') }}">
        @csrf
        <input type="hidden" name="modal" value="1">
        <div class="flex items-center w-full">
            <div class="mx-4">
                <label class="block mb-2 text-sm text-gray-00" for="standard_name">Nama Standar</label>
                <div class="py-2 text-left flex items-center w-80">
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline4" id="standard_name" name="standard_name" type="text" required>
                </div>
            </div>
            <div class="mx-4">
                <label class="block mb-2 text-sm text-gray-00 ml-4" for="alias_name">Nomenklatur</label>
                <div class="py-2 text-left flex items-center w-96">
                    <a href="#map" class="mr-4">
                        <i class="fas fa-exchange"></i>
                    </a>
                    <input type="hidden" id="nomenclature_id" name="nomenclature_id">
                    <input readonly id="nomenclature_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline4" type="text">
                </div>
            </div>
        </div>

        <div class="flex w-full justify-end pt-3">
            <input type="submit" value="{{ __('Submit') }}" class="block text-center text-white bg-green-600 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
        </div>       
    </form>
</div>   

<div id="brandModal" style="background-color: rgb(31, 41, 55);" class="modal text-gray-200 flex items-center justify-center">
    <div class="flex justify-between items-center pb-3 text-lg">
        Create New Brand
    </div>
    <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="modal" value="1">
        <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-6">
            <div class="">
                <label class="block mb-2 text-sm text-gray-00" for="brand">Nama Merk</label>
                <div class="py-2 text-left">
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="brand" name="brand" type="text" required>
                </div>
            </div>
            <div class="">
                <label class="block mb-2 text-sm text-gray-00" for="origin">Asal</label>
                <div class="py-2 text-left">
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="origin" name="origin" type="text" required>
                </div>
            </div>
        </div>
        <div class="flex w-full justify-end pt-3">
            <input type="submit" value="{{ __('Submit') }}" class="block text-center text-white bg-green-600 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
        </div>
    </form>
</div>  

<div id="map" style="max-width: fit-content;" class="modal text-gray-600 w-1/2 flex items-center justify-center">
    <div class="flex justify-between items-center pb-3 text-lg">
        Find Nomenclature
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

<script>
    function getNomenclatureId(id) {
        let inputNomenclature = document.getElementById('nomenclature_name')
        inputNomenclature.value = id.standard_name

        let inputNomId = document.getElementById('nomenclature_id')
        inputNomId.value = id.id
    }

    $('a[href="#map"]').click(function(event) {
        event.preventDefault();
        $(this).modal({
            closeExisting: false
        });
    });
</script>
@endsection