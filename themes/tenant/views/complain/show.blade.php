@extends('layouts.app')

@section('content')
<main class="flex sm:container sm:mx-auto sm:mt-10 overflow-auto">
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <section class="flex flex-col break-words bg-gray-200 sm:border-1">
            <div class="col-span-6 h-12 flex items-center py-2 px-4 bg-gray-200"> 
                @if (Auth::user()->id === $complain->user_id || Auth::user()->hasRole('admin'))
                    <a href="{{ route('complain.delete', ['complain' => $complain->id]) }}" class="mx-2 text-gray-600 hover:text-gray-400 modal-open image-toggle">
                        <i class="fas fa-trash-alt"></i>
                    </a>   
                @endif
                @empty($complain->response->id)
                    @role('staff')
                        <a href="{{ route('response.create', ['complain' => $complain->id]) }}" class="ml-auto mx-2 text-gray-600 hover:text-gray-400 modal-open image-toggle">
                            <i class="fas fa-plus-circle"></i>
                        </a>  
                    @endrole
                @endempty
                @isset($complain->response->id)
                    
                    <a href="{{ route('response.edit', ['response' => $complain->response->id]) }}" class="ml-auto mx-2 text-gray-600 hover:text-gray-400 modal-open image-toggle">
                        <i class="fas fa-edit"></i>
                    </a>
                @endisset      
                {{-- <div class="ml-auto my-auto flex text-xs">
                    <input class="h-8 rounded-r-none text-xs text-gray-800 w-full px-2 rounded-md focus:ring-0 border-none" id="search_" type="text" placeholder="Search..." name="search" />
                    <button type="button" class="h-8 rounded-l-none w-20 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:text-gray-800 hover:bg-gray-400 active:bg-gray-900 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">
                        Search
                    </button>
                </div> --}}
            </div>
            <div class="bg-white">
                <header class="grid grid-cols-2 px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                    <span>
                        {{ 'Ticket ID '.$complain->id }}
                        <div class="text-xs mt-3">
                            {{ __('Created at : '.$complain->created_at) }}
                        </div>
                    </span>
                    <span>
                        {{ 'Response ID '.$complain->response->id }}
                        <div class="text-xs mt-3">
                            {{ __('Created at : '.$complain->response->created_at) }}
                        </div>
                    </span>
                </header>
                
                
                <div class="w-full flex mr-auto pb-6 px-6 my-6">
                    <div class="block w-1/2 sm:px-6">
                        <div class="w-full text-sm">
                            <img src="{{ asset($complain->comPic)}}" style="align-content:flex-start;width:300;height:300px;" onerror="this.src = '/images/no_image.jpg';">
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00 font-bold" for="alias_name">Barcode</label>
                            <div class="py-2 text-left w-full">
                                {{ $complain->barcode }}
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00 font-bold" for="alias_name">Keterangan</label>
                            <div class="py-2 text-left w-full">
                                {{ $complain->description }}
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00 font-bold" for="alias_name">Unit</label>
                            <div class="py-2 text-left w-full">
                                {{ $complain->room->unit }}
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00 font-bold" for="standard_name">Nama Ruangan</label>
                            <div class="py-2 text-left w-full">
                                {{ $complain->room->room_name }}
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00 font-bold" for="alias_name">Tanggal Tiket</label>
                            <div class="py-2 text-left w-full">
                                {{ $complain->date_time }}
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3 text-xs">
                            {{ 'Submitted by. '.$complain->user->name }}
                        </div>
                    </div>   
                    @isset($complain->response)
                        <div class="border-l border-gray-700 px-3">
                            <div class="flex-end w-full text-sm">
                                <img src="{{ asset($complain->response->resPic)}}" style="height:300px;"onerror="this.src = '/images/no_image.jpg';">
                            </div>
                            <div class="flex flex-col mb-3">
                                <label class="block text-sm text-gray-00 font-bold" for="alias_name">Status Respon</label>
                                <div class="py-2 text-left w-min">
                                    @if ($complain->response->progress_status == 'Pending')
                                        <div class="rounded bg-yellow-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                            {{ $complain->response->progress_status }}
                                        </div>
                                    @elseif($complain->response->progress_status == 'Finished')
                                        <div class="rounded bg-green-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                            {{ $complain->response->progress_status }}
                                        </div>
                                    @else
                                        <div class="rounded bg-blue-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                            {{ $complain->response->progress_status }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-wrap mb-3">
                                    <label class="block text-sm text-gray-00 font-bold" for="alias_name">Status</label>
                                    <div class="py-2 text-left w-full">
                                        {{ $complain->response->status }}
                                    </div>
                                </div>
                                <div class="flex flex-wrap mb-3">
                                    <label class="block text-sm text-gray-00 font-bold" for="alias_name">Barcode</label>
                                    <div class="py-2 text-left w-full">
                                        {{ $complain->response->barcode }}
                                    </div>
                                </div>
                                <div class="flex flex-wrap mb-3">
                                    <label class="block text-sm text-gray-00 font-bold" for="alias_name">Keterangan</label>
                                    <div class="py-2 text-left w-full">
                                        {{ $complain->response->description }}
                                    </div>
                                    <div class="flex flex-wrap mt-6 text-xs">
                                        {{ 'Responded by. '.$complain->response->user->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endisset 
                </div>
            </div>
        </section>
    </div>
</main>
@endsection