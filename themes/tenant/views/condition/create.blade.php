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
                {{ __('Create New Condition') }}
            </header>

            <form class="w-3/5 mx-auto pb-6 my-6" method="POST"
                action="{{ route('condition.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-6">
                    @isset($inventory)
                        <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">
                    @endisset
                    @empty($inventory)
                    <div class="col-span-2">
                        <label class="block text-sm text-gray-00" for="device_id">ID Inventory</label>
                        <div class="py-2 text-left flex">
                            <select style="width: 100%;" id="inventory_id" name="inventory_id" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4">
                                <option></option>
                                @foreach ($inventories as $inventory)
                                    <option value="{{ $inventory->id }}">{{ $inventory->barcode.': '.$inventory->device->standard_name }}</option>
                                @endforeach
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#inventory_id').select2({
                                        placeholder: 'Select Inventory ID'
                                    });
                                });
                            </script>
                        </div>
                    </div>
                    @endempty
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="event">Detail Kejadian</label>
                        <div class="py-2 text-left">
                            <textarea rows="4" cols="16" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="event" name="event" type="number" required></textarea>
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="event_date">Tanggal Kejadian</label>
                        <div class="py-2 text-left">
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="event_date" name="event_date" type="date" required>
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="status">Status Alat</label>
                        <div class="py-2 text-left">
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="status" id="status" required>
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </div>
                    </div>
                    <div></div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="worksheet">Lembar Kerja</label>
                        <div class="py-2 text-left">
                            <input class="" id="worksheet" name="worksheet" type="file">
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

<div id="device-modal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-gray-100 text-gray-800 w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
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
                    <input type="submit" value="{{ __('Submit') }}" class="block text-center text-white bg-gray-700 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
                    <button onclick="toggleModal(this, 'device-toggle', 'device-modal')" type="button" class="modal-close device-toggle block text-center text-white bg-red-600 p-3 duration-300 rounded-sm hover:bg-red-700 w-full sm:w-24 mx-2">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="brand-modal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-gray-100 text-gray-800 w-3/4 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
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
                    <input type="submit" value="{{ __('Submit') }}" class="block text-center text-white bg-gray-700 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
                    <button onclick="toggleModal(this, 'brand-toggle', 'brand-modal')" type="button" class="modal-close brand-toggle block text-center text-white bg-red-600 p-3 duration-300 rounded-sm hover:bg-red-700 w-full sm:w-24 mx-2">Close</button>
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