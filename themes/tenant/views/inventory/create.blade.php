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

<main class="sm:container sm:mx-auto sm:mt-10">
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="flex flex-col break-words bg-white sm:border-1">

            <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                {{ __('Add to Inventory') }}
            </header>

            <form class="w-3/4 mx-auto my-auto space-y-6 sm:px-12 sm:pb-6 sm:space-y-8" method="POST"
                action="{{ route('inventory.store') }}">
                @csrf
                <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-16">
                    <div class="flex flex-col col-span-2">
                        <label class="block text-sm text-gray-00" for="device_id">Nama Alat</label>
                        <div class="relative flex items-center h-10 w-3/4 input-component">
                            <select style="width: 100%;" id="device_id" name="device_id" class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded">
                                <option value=""></option>
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#device_id').select2();
                                });
                            </script>
                            {{-- <input class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="device_id" name="device_id" type="text" required> --}}
                            <a class="mx-2 text-green-600 hover:text-purple-500" href="{{ route('inventory.create') }}">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <label class="block mb-2 text-sm text-gray-00" for="barcode">Barcode</label>
                        <div class="relative flex items-center h-10 w-full input-component">
                            <input class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="barcode" name="barcode" type="text" required>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <label class="block mb-2 text-sm text-gray-00" for="serial">Serial Number</label>
                        <div class="relative flex items-center h-10 w-3/4 input-component">
                            <input class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="serial" name="serial" type="text" required>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <label class="block text-sm text-gray-00" for="brand_id">Merk</label>
                        <div class="relative flex items-center h-10 w-full input-component">
                            <select style="width: 100%;" id="brand_id" name="brand_id" class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded">
                                <option value=""></option>
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#brand_id').select2();
                                });
                            </script>
                            {{-- <input class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="device_id" name="device_id" type="text" required> --}}
                            <a class="mx-2 text-green-600 hover:text-purple-500" href="{{ route('inventory.create') }}">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="flex flex-col row-start-4">
                        <label class="block text-sm text-gray-00" for="identity_id">Tipe</label>
                        <div class="relative flex items-center h-10 w-full input-component">
                            <select style="width: 100%;" id="identity_id" name="identity_id" class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded">
                                <option value=""></option>
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#identity_id').select2();
                                });
                            </script>
                            {{-- <input class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="device_id" name="device_id" type="text" required> --}}
                            <a class="mx-2 text-green-600 hover:text-purple-500" href="{{ route('inventory.create') }}">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="flex flex-col row-start-5">
                        <label class="block text-sm text-gray-00" for="room_id">Ruangan</label>
                        <div class="relative flex items-center h-10 w-full input-component">
                            <select style="width: 100%;" id="room_id" name="room_id" class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded">
                                <option value=""></option>
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#room_id').select2();
                                });
                            </script>
                            {{-- <input class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="device_id" name="device_id" type="text" required> --}}
                            <a class="mx-2 text-green-600 hover:text-purple-500" href="{{ route('inventory.create') }}">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-span-2 h-full w-full p-3 mb-6 bg-white" :class="{ 'pb-3': show }" x-data="{show:false}">
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
                    </div>
                </div>

                <div class="flex flex-wrap justify-center">
                    <input type="submit" value="{{ __('Submit') }}" class="block text-center text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-80">
                </div>        
            </form>

        </section>
    </div>
</main>
@endsection