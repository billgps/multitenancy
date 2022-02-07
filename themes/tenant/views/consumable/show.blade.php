@extends('layouts.app')

@section('content')
<main class="flex sm:container sm:mx-auto sm:mt-10">
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <section class="flex flex-col break-words bg-gray-200 sm:border-1">
            <div class="col-span-6 h-12 flex items-center py-2 px-4 bg-gray-200">
                @if (Auth::user()->role < 2)
                    <a href="{{ route('consumable.edit', ['consumable' => $consumable->id]) }}" class="mx-2 text-gray-600 hover:text-gray-400 modal-open image-toggle">
                        <i class="fas fa-edit"></i>
                    </a>   
                @endif
                @if (Auth::user()->role < 1)
                    <a href="{{ route('consumable.delete', ['consumable' => $consumable->id]) }}" class="mx-2 text-gray-600 hover:text-gray-400 modal-open image-toggle">
                        <i class="fas fa-trash-alt"></i>
                    </a>  
                @endif   
            </div>
            <div class="bg-white">
                <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                    {{ __('Consumable Inventory ID '.$inventory->id) }}
                </header>
    
                <div class="w-full flex mr-auto pb-6 px-6 my-6">
                    <div class="block sm:px-6">
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00" for="standard_name">Komponen</label>
                            <div class="py-2 text-left w-full">
                                <input disabled value="{{ $consumable->component }}" id="standard_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00" for="standard_name">Merk</label>
                            <div class="py-2 text-left w-full">
                                <input disabled value="{{ $consumable->brand }}" id="standard_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00" for="alias_name">Keterangan</label>
                            <div class="py-2 text-left w-full">
                                {{ $consumable->details }}
                            </div>
                        </div>
                    </div>    
                    <div class="ml-auto text-xs">
                        {{ __('Created at : '.$consumable->created_at) }}
                        {{-- <img class="w-96 h-56 opacity-75" src="{{ asset('illust_4.png') }}" alt=""> --}}
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection