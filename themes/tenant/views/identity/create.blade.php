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


<div id="deviceModal" style="background-color: rgb(31, 41, 55);" class="modal text-gray-200 flex items-center justify-center">
    <div class="flex justify-between items-center pb-3 text-lg">
        Create New Device
    </div>
    <form action="{{ route('device.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="modal" value="1">
        <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-6">
            <div class="">
                <label class="block mb-2 text-sm text-gray-00" for="standard_name">Nama Standar</label>
                <div class="py-2 text-left">
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="standard_name" name="standard_name" type="text" required>
                </div>
            </div>
            <div class="">
                <label class="block mb-2 text-sm text-gray-00" for="alias_name">Nama Alias</label>
                <div class="py-2 text-left">
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="alias_name" name="alias_name" type="text" required>
                </div>
            </div>
            <div class="">
                <label class="block mb-2 text-sm text-gray-00" for="risk_level">Risk Level</label>
                <div class="py-2 text-left">
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="risk_level" name="risk_level" type="text" required>
                </div>
            </div>
            <div class="row-start-3">
                <label class="block mb-2 text-sm text-gray-00" for="ipm_frequency">IPM Frequency</label>
                <div class="py-2 text-left">
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="ipm_frequency" name="ipm_frequency" type="text" required>
                </div>
            </div>
        </div>
        <div class="flex w-full justify-end pt-3">
            <input type="submit" value="{{ __('Import') }}" class="block text-center text-white bg-green-600 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
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
            <input type="submit" value="{{ __('Import') }}" class="block text-center text-white bg-green-600 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
        </div>
    </form>
</div>  
@endsection