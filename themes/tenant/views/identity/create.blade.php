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
        border-radius: 0 !important;
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
                {{ __('Create New Identiy') }}
            </header>

            <form class="w-3/5 mx-auto pb-6 my-6" method="POST"
                action="{{ route('identity.store') }}">
                @csrf
                <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-6">
                    <div class="">
                        <label class="block text-sm text-gray-00" for="device_id">Nama Alat</label>
                        <div class="py-2 text-left flex">
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
                            <button onclick="toggleModal(this, 'device-toggle', 'device-modal')" type="button" class="modal-open device-toggle mx-2 text-green-600 hover:text-purple-500">
                                <i class="fas fa-plus"></i>
                            </button>
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
                                    $('#brand_id').select2();
                                });
                            </script>
                            <button onclick="toggleModal(this, 'brand-toggle', 'brand-modal')" type="button" class="modal-open brand-toggle mx-2 text-green-600 hover:text-purple-500">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="model">Tipe Alat</label>
                        <div class="py-2 text-left">
                            <input class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4" id="model" name="model" type="text" required>
                        </div>
                    </div>
                    <div class="row-start-3">
                        <label class="block mb-2 text-sm text-gray-00" for="manual">Manual Book</label>
                        <div class="py-2 text-left">
                            <input class="text-sm border-2 border-gray-100 focus:outline-none block w-full py-2 px-4" id="manual" name="manual" type="file">
                        </div>
                    </div>
                    <div class="row-start-3">
                        <label class="block mb-2 text-sm text-gray-00" for="procedure">Prosedur</label>
                        <div class="py-2 text-left">
                            <input class="text-sm border-2 border-gray-100 focus:outline-none block w-full py-2 px-4" id="procedure" name="procedure" type="file">
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
    <div class="modal-container bg-gray-800 text-gray-300 w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
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
                            <input class="text-sm text-gray-600 bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4 h-7" id="standard_name" name="standard_name" type="text" required>
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="alias_name">Nama Alias</label>
                        <div class="py-2 text-left">
                            <input class="text-sm text-gray-600 bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4 h-7" id="alias_name" name="alias_name" type="text" required>
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="risk_level">Risk Level</label>
                        <div class="py-2 text-left">
                            <input class="text-sm text-gray-600 bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4 h-7" id="risk_level" name="risk_level" type="text" required>
                        </div>
                    </div>
                    <div class="row-start-3">
                        <label class="block mb-2 text-sm text-gray-00" for="ipm_frequency">IPM Frequency</label>
                        <div class="py-2 text-left">
                            <input class="text-sm text-gray-600 bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4 h-7" id="ipm_frequency" name="ipm_frequency" type="text" required>
                        </div>
                    </div>
                </div>
                <div class="flex w-full justify-end pt-2">
                    <input type="submit" value="{{ __('Submit') }}" class="block text-center text-white bg-gray-700 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
                    <button onclick="toggleModal(this, 'device-toggle', 'device-modal')" type="button" class="modal-close device-toggle block text-center text-white bg-red-600 p-3 duration-300 rounded-sm hover:bg-red-700 w-full sm:w-24 mx-2">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="brand-modal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-gray-800 text-gray-300 w-3/4 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
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
                            <input class="text-sm text-gray-600 bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4 h-7" id="brand" name="brand" type="text" required>
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="origin">Asal</label>
                        <div class="py-2 text-left">
                            <input class="text-sm text-gray-600 bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4 h-7" id="origin" name="origin" type="text" required>
                        </div>
                    </div>
                </div>
                <div class="flex w-full justify-end pt-2">
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