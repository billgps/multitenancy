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
                    <a href="{{ route('condition.edit', ['condition' => $condition->id]) }}" class="mx-2 text-gray-600 hover:text-gray-400">
                        <i class="fas fa-edit"></i>
                    </a>   
                @endif
                @if (Auth::user()->role < 1)
                    <a href="{{ route('condition.delete', ['condition' => $condition->id]) }}" class="mx-2 text-gray-600 hover:text-gray-400">
                        <i class="fas fa-trash-alt"></i>
                    </a>   
                @endif  
                <a href="{{ route('condition.download.worksheet', ['condition' => $condition->id]) }}" class="mx-2 text-gray-600 hover:text-gray-400">
                    <i class="fas fa-file-download"></i>
                </a>
                {{-- <div class="ml-auto my-auto flex text-xs">
                    <input class="h-8 rounded-r-none text-xs text-gray-800 w-full px-2 rounded-md focus:ring-0 border-none" id="search_" type="text" placeholder="Search..." name="search" />
                    <button type="button" class="h-8 rounded-l-none w-20 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:text-gray-800 hover:bg-gray-400 active:bg-gray-900 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">
                        Search
                    </button>
                </div> --}}
            </div>
            <div class="bg-white">
                <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                    {{ __('Kondisi Inventory ID '.$inventory->id) }}
                </header>
    
                <div class="w-full flex mr-auto pb-6 px-6 my-6">
                    <div class="block sm:px-6">
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00" for="standard_name">Tanggal Kejadian</label>
                            <div class="py-2 text-left w-full">
                                <input disabled value="{{ $condition->event_date }}" id="standard_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00" for="alias_name">Keterangan</label>
                            <div class="py-2 text-left w-full">
                                {{ $condition->event }}
                            </div>
                        </div>
                        <div class="flex flex-col mb-3">
                            <label class="block text-sm text-gray-00" for="alias_name">Status Alat</label>
                            <div class="py-2 text-left w-min">
                                @if ($condition->status == 'Baik')
                                    <div class="rounded bg-green-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                        {{ $condition->status }}
                                    </div>
                                @elseif($condition->status == 'Rusak')
                                    <div class="rounded bg-red-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                        {{ $condition->status }}
                                    </div>
                                @else
                                    <div class="rounded bg-yellow-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                        {{ $condition->status }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00" for="standard_name">Petugas</label>
                            <div class="py-2 text-left w-full">
                                <input disabled value="{{ $user->name }}" id="standard_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                            </div>
                        </div>
                    </div>    
                    <div class="ml-auto text-xs">
                        {{ __('Created at : '.$condition->created_at) }}
                        {{-- <img class="w-96 h-56 opacity-75" src="{{ asset('illust_4.png') }}" alt=""> --}}
                    </div>
                    {{-- <div class="flex flex-wrap justify-end">
                        <button disabled id="cancelBtn" onclick="toggleEdit(true)" type="button" class="block text-center text-white bg-red-600 mx-2 p-3 duration-300 rounded-sm hover:bg-red-500 disabled:opacity-75 w-24">Cancel</button>
                        <input disabled type="submit" value="{{ __('Update') }}" class="block text-center mx-2 text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black disabled:opacity-75 w-24">
                    </div>         --}}
                </div>
            </div>
        </section>
    </div>
</main>
@endsection