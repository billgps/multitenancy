@extends('layouts.app')

@section('content')
<style>
    canvas {
        width: 100%;
        height: 100%;
    }
</style>
<main class="sm:container sm:mx-auto sm:mt-6 overflow-y-auto">
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="sm:grid sm:grid-cols-6 sm:gap-2 break-words">
            <div class="col-span-6 h-12 flex items-center py-2 px-4 bg-gray-200">
                @if (Auth::user()->role < 2)
                    <a class="mx-2 text-green-600 hover:text-gray-400" href="{{ route('identity.create') }}">
                        <i class="fas fa-plus"></i>
                    </a>
                @endif
                @if (Auth::user()->role < 1)
                    <a href="#import" rel="modal:open" class="mx-2 text-blue-600 hover:text-gray-400">
                        <i class="fas fa-file-upload"></i>
                    </a>  
                    
                    <div id="import" style="background-color: rgb(31, 41, 55);" class="modal text-gray-200 flex items-center justify-center">
                        <div class="flex justify-between items-center pb-3 text-lg">
                            Import Excel to Identity
                        </div>
                        <form action="{{ route('identity.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="text-xs">
                                <div>
                                    <label class="block mb-2 text-sm text-gray-00" for="file">identities</label>
                                    <div class="py-2 text-left">
                                        <input id="file" name="file" type="file">
                                    </div>
                                </div>
                                <div class="flex w-full justify-end pt-2">
                                    <input type="submit" value="{{ __('Import') }}" class="block text-center text-white bg-green-600 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
                                </div>
                            </div>
                        </form>
                    </div>   
                @endif
                <a class="mx-2 text-blue-600 hover:text-gray-400" href="{{ route('identity.export') }}">
                    <i class="fas fa-download"></i>
                </a>
                <div class="ml-auto my-auto flex text-xs">
                    <input class="h-8 rounded-r-none text-xs text-gray-800 w-full px-2 rounded-md focus:ring-0 border-none" id="search_" type="text" placeholder="Search..." name="search" />
                    <button type="button" class="h-8 rounded-l-none w-20 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:text-gray-800 hover:bg-gray-400 active:bg-gray-900 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">
                        Search
                    </button>
                </div>
            </div>
            <div class="flex flex-col sm:col-span-6 break-words bg-white sm:border-1">

                <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                    {{ __('Daftar Tipe Alat') }}
                </header>   
                <div class="w-full px-6 py-3">
                    <table id="identity" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal border-b border-gray-600">
                                <th class="py-3 px-6">Nama Alat</th>
                                <th class="py-3 px-6">Merk</th>
                                <th class="py-3 px-6">Tipe</th>
                                <th class="py-3 px-6">Manual Book</th>
                                <th class="py-3 px-6">Procedure</th>
                                <th class="py-3 px-6">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($identities as $identity)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left">
                                        {{ $identity->device->standard_name }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $identity->brand->brand }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $identity->model }}
                                    </td>
                                    <td class="py-3 px-6">
                                        <a href="{{ route('identity.download.manual', ['identity' => $identity->id]) }}">
                                            {{ $identity->manual }}
                                        </a>
                                    </td>
                                    <td class="py-3 px-6">
                                        <a href="{{ route('identity.download.procedure', ['identity' => $identity->id]) }}">
                                            {{ $identity->procedure }}
                                        </a>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('identity.edit', ['identity' => $identity->id]) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                            @if (Auth::user()->role < 1)
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <a href="{{ route('identity.delete', ['identity' => $identity->id]) }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 
                    <script>
                        $(document).ready(function() {
                            var table = $('#identity').DataTable({
                                "pageLength": 15,
                                "ordering": true,
                                "info":     false,
                                "lengthChange": false,
                                "searching": true,
                                "paging":   true,
                                columnDefs: [
                                    { orderable: false, targets: -1 }
                                ],
                                "dom": 'lrtip'
                            });

                            drawPaginate()
            
                            $('#search_').keyup(function(){
                                table.search($(this).val()).draw()
                            })
            
                            $("#page").append($(".dataTables_paginate"));
            
                            $('#identity').on( 'draw.dt', function () {
                                drawPaginate()
                            })

                            function drawPaginate() {
                                let prev = document.getElementsByClassName('previous')[0]
                                prev.classList.add('mr-3', 'cursor-pointer', 'hover:text-purple-500')
                                prev.innerHTML = '<i class="fas fa-chevron-left"></i>'
                
                                let next = document.getElementsByClassName('next')[0]
                                next.classList.add('ml-3', 'cursor-pointer', 'hover:text-purple-500')
                                next.innerHTML = '<i class="fas fa-chevron-right"></i>'
                
                                let page = document.getElementById('identity_paginate').getElementsByTagName('span')[0].getElementsByClassName('paginate_button')
                                for (let i = 0; i < page.length; i++) {
                                    if (page[i].classList.contains('current')) {
                                        page[i].classList.add('mx-1', 'text-purple-500')                    
                                    }
                                    page[i].classList.add('mx-1', 'cursor-pointer', 'hover:text-purple-500')                    
                                }
                            }
                        })
                    </script>
                    <div class="mt-3 w-full h-20 flex justify-center text-sm p-2" id="page"></div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection