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
        border-radius: 0px !important;
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

            <header class="px-6 py-5 font-semibold text-gray-700 sm:p-6">
                {{ __('Add to Inventory') }}
            </header>

            <form class="w-3/5 mx-auto pb-6 my-6"  enctype="multipart/form-data" method="POST"
                action="{{ route('inventory.store') }}">
                @csrf
                <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-16">
                    <div class="flex flex-col col-span-2">
                        <label class="block text-sm text-gray-00" for="device_id">Nama Alat</label>
                        <div class="py-2 text-left">
                            <select style="width: 90%;" id="device_id" name="device_id" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4">
                                <option value=""></option>
                                @foreach ($devices as $device)
                                    <option value="{{ $device->id }}">{{ $device->standard_name }}</option>
                                @endforeach
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#device_id').select2();
                                });
                            </script>
                            <button id="deviceToggle" class="mx-2 text-green-600 hover:text-purple-500" href="{{ route('inventory.create') }}">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <label class="block mb-2 text-sm text-gray-00" for="barcode">Barcode</label>
                        <div class="py-2 text-left">
                            <input class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4" id="barcode" name="barcode" type="text" required>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <label class="block mb-2 text-sm text-gray-00" for="serial">Serial Number</label>
                        <div class="py-2 text-left">
                            <input class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4" id="serial" name="serial" type="text" required>
                        </div>
                    </div>
                    <div class="flex flex-col col-span-2">
                        <label class="block text-sm text-gray-00" for="brand_id">Merk</label>
                        <div class="py-2 text-left">
                            <select style="width: 90%;" id="brand_id" name="brand_id" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4">
                                <option value=""></option>
                                @foreach ($devices as $device)
                                    <option value="{{ $device->id }}">{{ $device->standard_name }}</option>
                                @endforeach
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#brand_id').select2();
                                });
                            </script>
                            <button id="deviceToggle" class="mx-2 text-green-600 hover:text-purple-500" href="{{ route('inventory.create') }}">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col col-span-2">
                        <label class="block text-sm text-gray-00" for="identity_id">Tipe Alat</label>
                        <div class="py-2 text-left">
                            <select style="width: 90%;" id="identity_id" name="identity_id" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4">
                                <option value=""></option>
                                @foreach ($devices as $device)
                                    <option value="{{ $device->id }}">{{ $device->standard_name }}</option>
                                @endforeach
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#identity_id').select2();
                                });
                            </script>
                            <button id="deviceToggle" class="mx-2 text-green-600 hover:text-purple-500" href="{{ route('inventory.create') }}">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col col-span-2">
                        <label class="block text-sm text-gray-00" for="room_id">Ruangan</label>
                        <div class="py-2 text-left">
                            <select style="width: 90%;" id="room_id" name="room_id" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4">
                                <option value=""></option>
                                @foreach ($devices as $device)
                                    <option value="{{ $device->id }}">{{ $device->standard_name }}</option>
                                @endforeach
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#room_id').select2();
                                });
                            </script>
                            <button id="deviceToggle" class="mx-2 text-green-600 hover:text-purple-500" href="{{ route('inventory.create') }}">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center col-span-2">
                        <label class="block text-sm text-gray-00 mb-8" for="picture">Foto Alat</label>
                        <div class="relative h-4 border-gray-200 bg-white flex justify-center items-center hover:cursor-pointer">
                            <div class="absolute">
                                <div class="flex flex-col items-center "> 
                                    <i class="fa fa-cloud-upload fa-3x text-gray-300"></i> 
                                    <span class="block text-blue-400 font-normal">Browse files</span> 
                                </div>
                            </div> 
                            <input type="file" class="h-full w-full opacity-0 cursor-pointer" name="picture" id="picture" accept="image/*">
                        </div>
                    </div>
                </div>

                {{-- <div class="col-span-2 h-full w-full p-3 mb-6 bg-white" :class="{ 'pb-3': show }" x-data="{show:false}">
                    <div class="text-md text-gray-600 items-start w-full">
                        Kondisi Alat (optional)                    
                        <div class="float-right">
                            <a x-on:click.prevent="show=!show" class="text-gray-600 cursor-pointer hover:text-purple-500">
                                <i class="hidden-item fas" :class="{ 'fa-angle-up': show, 'fa-angle-down': !show }"></i>
                            </a>
                        </div>
                    </div>
                    <div class="mt-3 text-sm sm:grid sm:grid-cols-2 sm:gap-2" x-show="show">
                        <div class="flex flex-wrap">
                            <label class="block mb-2 text-sm text-gray-00" for="event_date">Tanggal Kejadian</label>
                            <div class="relative flex items-center h-10 w-full input-component">
                                <input class="text-sm border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="event_date" name="event_date" type="date">
                            </div>
                        </div>
                        <div class="flex flex-wrap">
                            <label class="block mb-2 text-sm text-gray-00" for="event_date">Kondisi Alat</label>
                            <div class="relative flex items-center h-10 w-full input-component">
                                <select class="border-none text-sm outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="event_date" name="event_date">
                                    <option class="text-xs" selected hidden></option>
                                    <option class="text-xs" value="Baik">Baik</option>
                                    <option class="text-xs" value="Rusak">Rusak</option>
                                    <option class="text-xs" value="Tidak Diketahui">Tidak Diketahui</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <label class="mb-2 text-sm text-gray-00" for="event">Detail</label>
                            <div class="flex mt-10 items-center h-10 w-full">
                                <textarea rows="5" cols="50" class="text-sm border-none outline-none w-full px-3 py-1 text-gray-700 bg-gray-200 rounded" id="event" name="event"></textarea>
                            </div>
                        </div>
                        <div class="flex flex-wrap">
                            <label class="block mb-2 text-sm text-gray-00" for="worksheet">Lembar Kerja</label>
                            <div class="relative flex items-center h-10 w-full input-component">
                                <input type="file" id="worksheet" name="worksheet">
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="flex flex-wrap justify-center mt-12">
                    <input type="submit" value="{{ __('Submit') }}" class="block text-center text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-48">
                </div>        
            </form>

        </section>
    </div>
</main>
@endsection