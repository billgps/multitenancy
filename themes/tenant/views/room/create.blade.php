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
                {{ __('Create New Room') }}
            </header>

            <form class="w-3/4 mx-auto my-auto space-y-8 sm:p-6" method="POST"
                action="{{ route('room.store') }}">
                @csrf
                <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-6">
                    <div class="flex flex-wrap">
                        <label class="block mb-2 text-sm text-gray-00" for="unit">Nama Unit</label>
                        <div class="relative flex items-center h-10 w-full input-component">
                            <input class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="unit" name="unit" type="text" required>
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <label class="block mb-2 text-sm text-gray-00" for="building">Nama Gedung</label>
                        <div class="relative flex items-center h-10 w-full input-component">
                            <input class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="building" name="building" type="text">
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <label class="block mb-2 text-sm text-gray-00" for="room_name">Nama Ruangan</label>
                        <div class="relative flex items-center h-10 w-full input-component">
                            <input class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="room_name" name="room_name" type="text">
                        </div>
                    </div>
                    <div class="flex flex-wrap row-start-3">
                        <label class="block mb-2 text-sm text-gray-00" for="room_pic">PIC Ruangan</label>
                        <div class="relative flex items-center h-10 w-full input-component">
                            <input class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="room_pic" name="room_pic" type="text">
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