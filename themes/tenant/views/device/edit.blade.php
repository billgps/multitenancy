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

            <form class="w-3/5 mx-auto pb-6 my-6" method="POST"
                action="{{ route('device.update', ['device' => $device->id]) }}">
                @csrf
                <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-6">
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="standard_name">Nama Standar</label>
                        <div class="py-2 text-left">
                            <input value="{{ $device->standard_name }}" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4" id="standard_name" name="standard_name" type="text" required>
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="alias_name">Nama Alias</label>
                        <div class="py-2 text-left">
                            <input value="{{ $device->alias_name }}" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4" id="alias_name" name="alias_name" type="text" required>
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="risk_level">Risk Level</label>
                        <div class="py-2 text-left">
                            <input value="{{ $device->risk_level }}" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4" id="risk_level" name="risk_level" type="text" required>
                        </div>
                    </div>
                    <div class="row-start-3">
                        <label class="block mb-2 text-sm text-gray-00" for="ipm_frequency">IPM Frequency</label>
                        <div class="py-2 text-left">
                            <input value="{{ $device->ipm_frequency }}" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4" id="ipm_frequency" name="ipm_frequency" type="text" required>
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
@endsection