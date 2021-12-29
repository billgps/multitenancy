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

<script>
    function populate(data, select, param) {
        document.getElementById(select).innerHTML = ''
        
        for (let i = 0; i < data.length; i++) {
            let option
            if (param == 'model') {
                option = new Option(data[i].brand.brand + ' : ' + data[i].model, data[i].id, false, false);
            } else {
                option = new Option(data[i].brand.brand, data[i].id, false, false); 
            }
            $('#' + select).append(option).trigger('change');            
        }
    }
</script>

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
                            <select style="width: 90%;" id="device_id" name="device_id" class="text-sm bg-gray-20 focus:outline-none block w-full px-3">
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
                            <button onclick="toggleModal(this, 'device-toggle', 'device-modal')" type="button" class="modal-open device-toggle mx-2 text-green-600 hover:text-purple-500">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <label class="block mb-2 text-sm text-gray-00" for="barcode">Barcode</label>
                        <div class="py-2 text-left">
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="barcode" name="barcode" type="text" required>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <label class="block mb-2 text-sm text-gray-00" for="serial">Serial Number</label>
                        <div class="py-2 text-left">
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="serial" name="serial" type="text" required>
                        </div>
                    </div>
                    {{-- <div class="flex flex-col col-span-2">
                        <label class="block text-sm text-gray-00" for="brand_id">Merk</label>
                        <div class="py-2 text-left">
                            <select style="width: 90%;" id="brand_id" name="brand_id" class="text-sm bg-gray-20 focus:outline-none block w-full px-3">
                                <option></option>
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

                            <script>
                                $(document).ready(function() {
                                    let brandSelect = $('#device_id')
                                    brandSelect.on('change', function () {
                                        $.ajax({
                                            type: "GET",
                                            url: "{{ route('brand.ajax') }}",
                                            data: {
                                                id: $('#device_id').select2('data')[0].id
                                            },
                                            success: function (data) {
                                                console.log(data.data);
                                                populate(data.data, 'brand_id', 'brand')
                                            },
                                            error: function (error) {
                                                console.log(error)
                                            }
                                        })
                                    })
                                });
                            </script>
                            <button onclick="toggleModal(this, 'brand-toggle', 'brand-modal')" type="button" class="modal-open brand-toggle mx-2 text-green-600 hover:text-purple-500" href="{{ route('inventory.create') }}">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div> --}}
                    <div class="flex flex-col col-span-2">
                        <label class="block text-sm text-gray-00" for="identity_id">Tipe Alat</label>
                        <div class="py-2 text-left">
                            <select style="width: 90%;" id="identity_id" name="identity_id" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4">
                                <option></option>
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#identity_id').select2({
                                        placeholder: 'Select Model'
                                    });

                                    let brandSelect = $('#device_id')
                                    brandSelect.on('change', function () {
                                        $.ajax({
                                            type: "GET",
                                            url: "{{ route('identity.ajax') }}",
                                            data: {
                                                id: $('#device_id').select2('data')[0].id
                                            },
                                            success: function (data) {
                                                // console.log(data.data);
                                                populate(data.data, 'identity_id', 'model')
                                            },
                                            error: function (error) {
                                                console.log(error)
                                            }
                                        })
                                    })
                                });
                            </script>
                            <button onclick="toggleModal(this, 'identity-toggle', 'identity-modal')" type="button" class="modal-open identity-toggle mx-2 text-green-600 hover:text-purple-500">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col col-span-2">
                        <label class="block text-sm text-gray-00" for="room_id">Ruangan</label>
                        <div class="py-2 text-left">
                            <select style="width: 90%;" id="room_id" name="room_id" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4">
                                <option></option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                                @endforeach
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#room_id').select2({
                                        placeholder: 'Select Room'
                                    });
                                });
                            </script>
                            <button onclick="toggleModal(this, 'room-toggle', 'room-modal')" type="button" class="modal-open room-toggle mx-2 text-green-600 hover:text-purple-500" href="{{ route('inventory.create') }}">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col col-span-2">
                        <label class="block mb-2 text-sm text-gray-00" for="picture">Foto Alat</label>
                        <div class="py-2 text-left">
                            <input class="" id="picture" name="picture" type="file" accept="image/*">
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

<div id="device-modal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-gray-800 text-gray-300 mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3 text-lg">
                Create New Device
            </div>
            <form action="{{ route('device.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="modal" value="1">
                <div class="text-xs">
                    <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-6">
                        <div class="">
                            <label class="block mb-2 text-sm text-gray-00" for="standard_name">Nama Standar</label>
                            <div class="py-2 text-left">
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline4" id="standard_name" name="standard_name" type="text" required>
                            </div>
                        </div>
                        <div class="">
                            <label class="block mb-2 text-sm text-gray-00" for="alias_name">Nama Alias</label>
                            <div class="py-2 text-left">
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline4" id="alias_name" name="alias_name" type="text" required>
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
                    <div class="flex w-full justify-end pt-6">
                        <input type="submit" value="{{ __('Upload') }}" class="block text-center text-white bg-gray-700 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
                        <button onclick="toggleModal(this, 'device-toggle', 'device-modal')" type="button" class="modal-close device-toggle block text-center text-white bg-red-600 p-3 duration-300 rounded-sm hover:bg-red-700 w-full sm:w-24 mx-2">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="brand-modal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-gray-800 text-gray-300 mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3 text-lg">
                Create New Device
            </div>
            <form action="{{ route('device.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="modal" value="1">
                <div class="text-xs">
                    <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-6">
                        <div class="">
                            <label class="block mb-2 text-sm text-gray-00" for="brand">Nama Merk</label>
                            <div class="py-2 text-left">
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="brand" name="brand" type="text" required>
                            </div>
                        </div>
                        <div class="row-start-2">
                            <label class="block mb-2 text-sm text-gray-00" for="origin">Asal</label>
                            <div class="py-2 text-left">
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="origin" name="origin" type="text" required>
                            </div>
                        </div>
                    </div>
                    <div class="flex w-full justify-end pt-6">
                        <input type="submit" value="{{ __('Upload') }}" class="block text-center text-white bg-gray-700 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
                        <button onclick="toggleModal(this, 'brand-toggle', 'brand-modal')" type="button" class="modal-close brand-toggle block text-center text-white bg-red-600 p-3 duration-300 rounded-sm hover:bg-red-700 w-full sm:w-24 mx-2">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="room-modal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-gray-800 text-gray-300 mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3 text-lg">
                Create New Room
            </div>
            <form action="{{ route('room.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="modal" value="1">
                <div class="text-xs">
                    <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-6">
                        <div class="">
                            <label class="block mb-2 text-sm text-gray-00" for="unit">Unit</label>
                            <div class="py-2 text-left">
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="unit" name="unit" type="text" required>
                            </div>
                        </div>
                        <div class="">
                            <label class="block mb-2 text-sm text-gray-00" for="building">Gedung</label>
                            <div class="py-2 text-left">
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="building" name="building" type="text" required>
                            </div>
                        </div>
                        <div class="">
                            <label class="block mb-2 text-sm text-gray-00" for="room_name">Nama Ruangan</label>
                            <div class="py-2 text-left">
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="room_name" name="room_name" type="text" required>
                            </div>
                        </div>
                        <div class="row-start-3">
                            <label class="block mb-2 text-sm text-gray-00" for="room_pic">PIC Ruangan</label>
                            <div class="py-2 text-left">
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="room_pic" name="room_pic" type="text" required>
                            </div>
                        </div>
                    </div>
                    <div class="flex w-full justify-end pt-6">
                        <input type="submit" value="{{ __('Upload') }}" class="block text-center text-white bg-gray-700 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
                        <button onclick="toggleModal(this, 'room-toggle', 'room-modal')" type="button" class="modal-close room-toggle block text-center text-white bg-red-600 p-3 duration-300 rounded-sm hover:bg-red-700 w-full sm:w-24 mx-2">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="identity-modal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-gray-800 text-gray-300 mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3 text-lg">
                Create New Model
            </div>
            <form action="{{ route('identity.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="modal" value="1">
                <div class="text-xs">
                    <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-6">
                        <div class="">
                            <label class="block text-sm text-gray-00" for="device_id">Nama Alat</label>
                            <div class="py-2 text-left flex">
                                <select style="width: 90%;" id="device_id_" name="device_id" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4">
                                    <option></option>
                                    @foreach ($devices as $device)
                                        <option value="{{ $device->id }}">{{ $device->standard_name }}</option>
                                    @endforeach
                                </select>
                                
                                <script>
                                    $(document).ready(function() {
                                        $('#device_id_').select2({
                                            placeholder: 'Select Device'
                                        });
                                    });
                                </script>
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
                            </div>
                        </div>
                        <div class="">
                            <label class="block mb-2 text-sm text-gray-00" for="model">Tipe Alat</label>
                            <div class="py-2 text-left">
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="model" name="model" type="text" required>
                            </div>
                        </div>
                        {{-- <div class="row-start-3">
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
                        </div> --}}
                    </div>
                    <div class="flex w-full justify-end pt-6">
                        <input type="submit" value="{{ __('Save') }}" class="block text-center text-white bg-gray-700 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
                        <button onclick="toggleModal(this, 'identity-toggle', 'identity-modal')" type="button" class="modal-close identity-toggle block text-center text-white bg-red-600 p-3 duration-300 rounded-sm hover:bg-red-700 w-full sm:w-24 mx-2">Close</button>
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
</script>
@endsection