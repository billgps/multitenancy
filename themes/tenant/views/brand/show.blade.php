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
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <section class="flex flex-col break-words bg-white sm:border-1">
            <div class="col-span-6 h-12 flex items-center py-2 px-4 bg-gray-200">
                <a href="{{ route('brand.edit', ['brand' => $brand->id]) }}" class="mx-2 text-yellow-600 hover:text-gray-400 modal-open image-toggle">
                    <i class="fas fa-edit"></i>
                </a>   
                <a href="{{ route('brand.delete', ['brand' => $brand->id]) }}" class="mx-2 text-red-600 hover:text-gray-400 modal-open image-toggle">
                    <i class="fas fa-trash-alt"></i>
                </a>     
                {{-- <div class="ml-auto my-auto flex text-xs">
                    <input class="h-8 rounded-r-none text-xs text-gray-800 w-full px-2 rounded-md focus:ring-0 border-none" id="search_" type="text" placeholder="Search..." name="search" />
                    <button type="button" class="h-8 rounded-l-none w-20 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:text-gray-800 hover:bg-gray-400 active:bg-gray-900 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">
                        Search
                    </button>
                </div> --}}
            </div>
            <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                {{ $brand->brand }}
            </header>

            <form class="mr-auto my-auto space-y-6 sm:px-12 sm:pb-6"  method="POST"
                action="">
                @csrf
                <div class="block sm:px-16">
                    <div class="flex flex-wrap mb-3">
                        <label class="block mb-2 text-sm text-gray-00" for="standard_name">Nama Merk</label>
                        <div class="relative flex items-center h-10 w-full input-component">
                            <input value="{{ $brand->brand }}" class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="standard_name" name="standard_name" type="text" disabled>
                        </div>
                    </div>
                    <div class="flex flex-wrap mb-3">
                        <label class="block mb-2 text-sm text-gray-00" for="alias_name">Asal Merk</label>
                        <div class="relative flex items-center h-10 w-full input-component">
                            <input value="{{ $brand->origin }}" class="border-none outline-none w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="alias_name" name="alias_name" type="text" disabled>
                        </div>
                    </div>
                </div>

                {{-- <div class="flex flex-wrap justify-end">
                    <button disabled id="cancelBtn" onclick="toggleEdit(true)" type="button" class="block text-center text-white bg-red-600 mx-2 p-3 duration-300 rounded-sm hover:bg-red-500 disabled:opacity-75 w-24">Cancel</button>
                    <input disabled type="submit" value="{{ __('Update') }}" class="block text-center mx-2 text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black disabled:opacity-75 w-24">
                </div>         --}}
            </form>
            <script>
                let inputs = document.getElementsByTagName('input')
                let editBtn = document.getElementById('editBtn')
                let cancelBtn = document.getElementById('cancelBtn');

                function toggleEdit (edit) {
                    for (let i = 0; i < inputs.length; i++) {
                        inputs[i].disabled = edit
                        cancelBtn.disabled = edit
                    }
                }
            </script>

        </section>
    </div>
</main>
@endsection