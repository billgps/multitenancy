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
    <div class="mx-auto w-3/4 sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="flex flex-col break-words bg-white sm:border-1">

            <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                {{ __('Create New Type') }}
            </header>

            <form class="w-3/4 mx-auto my-auto space-y-8 sm:p-6" method="POST"
                action="{{ route('identity.store') }}">
                @csrf
                <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-6">
                    <div class="flex flex-col col-span-2">
                        <label class="block text-sm text-gray-00" for="device_id">Nama Alat</label>
                        <div class="relative flex items-center h-10 w-3/4 input-component">
                            <select style="width: 100%;" id="device_id" name="device_id" class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded">
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
                            {{-- <input class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="device_id" name="device_id" type="text" required> --}}
                            <a class="mx-2 text-green-600 hover:text-purple-500" href="{{ route('device.create') }}">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="flex flex-col col-span-2">
                        <label class="block text-sm text-gray-00" for="brand_id">Merk Alat</label>
                        <div class="relative flex items-center h-10 w-3/4 input-component">
                            <select style="width: 100%;" id="brand_id" name="brand_id" class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded">
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
                            {{-- <input class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="device_id" name="device_id" type="text" required> --}}
                            <a class="mx-2 text-green-600 hover:text-purple-500" href="{{ route('brand.create') }}">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <label class="block mb-2 text-sm text-gray-00" for="model">Tipe Alat</label>
                        <div class="relative flex items-center h-10 w-full input-component">
                            <input class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="model" name="model" type="text" required>
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