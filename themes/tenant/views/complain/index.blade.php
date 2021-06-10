@extends('layouts.app')

@section('content')
<main class="sm:container sm:mx-auto sm:mt-6 overflow-y-auto">
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="sm:grid sm:grid-cols-6 sm:gap-2 break-words">
            <div class="col-span-6 h-12 flex items-center py-2 px-4 bg-gray-200">
                <a class="mx-2 text-green-600 hover:text-gray-400" href="{{ route('complain.create') }}">
                    <i class="fas fa-plus"></i>
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
                    {{ __('Daftar Komplain') }}
                </header>   
                <div class="w-full px-6 py-3">
                    <table id="device" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6">ID</th>
                                <th class="py-3 px-6">User</th>
                                <th class="py-3 px-6">Ruangan</th>
                                <th class="py-3 px-6">Tanggal Komplain</th>
                                <th class="py-3 px-6">Status Respon</th>
                                <th class="py-3 px-6">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($complains as $complain)
                                <tr class="hover:bg-gray-100">
                                    <td class="py-3 px-6">
                                        {{ $complain->id }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $complain->user->name }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $complain->room->room_name }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $complain->date_time }}
                                    </td>
                                    <td class="py-3 px-6 flex">
                                        <div class="py-2 mx-auto w-min">
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
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('complain.show', ['id' => $complain->id]) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('response.create', ['complain' => $complain->id]) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('complain.delete', ['complain' => $complain->id]) }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 
                    <script>
                        $(document).ready(function() {
                            var table = $('#device').DataTable({
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
            
                            $('#device').on( 'draw.dt', function () {
                                drawPaginate()
                            })

                            function drawPaginate() {
                                let prev = document.getElementsByClassName('previous')[0]
                                prev.classList.add('mr-3', 'cursor-pointer', 'hover:text-purple-500')
                                prev.innerHTML = '<i class="fas fa-chevron-left"></i>'
                
                                let next = document.getElementsByClassName('next')[0]
                                next.classList.add('ml-3', 'cursor-pointer', 'hover:text-purple-500')
                                next.innerHTML = '<i class="fas fa-chevron-right"></i>'
                
                                let page = document.getElementById('device_paginate').getElementsByTagName('span')[0].getElementsByClassName('paginate_button')
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
