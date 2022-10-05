@extends('layouts.app')

@section('content')

<main class="sm:container sm:mx-auto sm:mt-6 overflow-y-auto">
    <div class="w-full sm:px-2">        
        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="sm:grid sm:grid-cols-6 sm:gap-2 break-words">
            <div class="col-span-6 h-12 flex items-center py-2 px-4 bg-gray-200">
                @if (Auth::user()->hasRole('nurse'))
            
                @else
                <a class="mx-2 text-green-600 hover:text-gray-400" href="{{ route('complain.create') }}">
                    <i class="fas fa-plus"></i>
                </a>
                <a class="mx-2 text-green-600 hover:text-gray-400" target="blank" href="/complain/pdf">   
                    <i class="fa fa-print"></i>
                </a>
                @endif
                <div class="ml-auto my-auto flex text-xs " x-data="{ search: '' }">
                    <input class="h-8 rounded-r-none text-xs text-gray-800 w-full px-2 rounded-md focus:ring-0 border-none" id="search_" type="search" placeholder="Search..." name="search" x-model="search"/>
                    <button type="button" class="h-8 rounded-l-none w-20 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:text-gray-800 hover:bg-gray-400 active:bg-gray-900 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">
                        Search
                    </button>
                </div>
            </div>
            <div class="flex flex-col sm:col-span-6 break-words bg-white sm:border-1" style="max-width:100%">

                <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                    {{ __('Daftar Tiket') }}
                </header>   
                <div class="w-full px-1 py-3" style="max-width: 100%">
                    <table id="device" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6">ID</th>
                                <th class="py-3 px-6">User</th>
                                <th class="py-3 px-6">Ruangan</th>
                                <th class="py-3 px-6">Tanggal Tiket</th>
                                <th class="py-3 px-6">Status</th>
                                <th class="py-3 px-6">Barcode</th>
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

                                    <td class="py-3 px-6">
                                        {{ $complain->response->status }}
                                    </td>

                                    <td class="[py-3 px-6">
                                        {{ explode(' | ',$complain->barcode)[0]}}
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
                                                @if (Auth::user()->hasRole('staff')||Auth::user()->hasRole('nurse'))
                                                    @empty($complain->response->user_id)
                                                        <a href="{{ route('response.create', ['complain' => $complain->id]) }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endempty
                                                @endif
                                            </div>
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                @if (Auth::user()->hasRole('admin') || $complain->user_id === Auth::user()->id)
                                                    <a href="{{ route('complain.delete', ['complain' => $complain->id]) }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <script>
                        $(document).ready( function () {
                            let table = $('#device').DataTable({
                                "paging": true,
                                "lengthChange": false,
                                "ordering": true,
                                "info": true,
                                "autoWidth": true,
                                "responsive": true,
                                "pageLength": 4,
                                });

                            $('#search_').keyup(function(){
                            table.search($(this).val()).draw() ;
                            })

                            $('#device_filter').css("display","none")
                        } );
                    </script>
                    {{-- <script>
                            var table = $('#example').DataTable({
                                "pageLength": 30,
                                "ordering": true,
                                "info":     false,
                                "lengthChange": false,
                                "searching": true,
                                "paging":   true,
                                columnDefs: [
                                    { orderable: false, targets: -1 }
                                ],
                                "dom": 'lrtip',
                                processing: true,
                                serverSide: true,
                                ajax: {
                                    url: "{{ route('complaints.ajax') }}",
                                    dataSrc: 'data',
                                    complete: function() {
                                        var prev = document.getElementsByClassName('previous')[0]
                                        prev.classList.add('mr-3', 'cursor-pointer', 'hover:text-purple-500')
                                        prev.innerHTML = '<i class="fas fa-chevron-left"></i>'

                                        var next = document.getElementsByClassName('next')[0]
                                        next.classList.add('ml-3', 'cursor-pointer', 'hover:text-purple-500')
                                        next.innerHTML = '<i class="fas fa-chevron-right"></i>'

                                        var page = document.getElementById('example_paginate').getElementsByTagName('span')[0].getElementsByClassName('paginate_button')
                                        for (let i = 0; i < page.length; i++) {
                                            if (page[i].classList.contains('current')) {
                                                page[i].classList.add('mx-1', 'text-purple-500')                    
                                            }
                                            page[i].classList.add('mx-1', 'cursor-pointer', 'hover:text-purple-500')                    
                                        }
                                    }
                                },
                                columns: [
                                    {data: 'date_time'},
                                    {data: 'user_name'},
                                    {data: 'room'},
                                    {data: 'response_user'},
                                    {data: 'response_date'},
                                    {data: 'response_status'},
                                    {data: 'created_at'},
                                ]
                            });

                            $('#search_').keyup(function(){
                                table.search($(this).val()).draw()
                            })

                            $("#page").append($(".dataTables_paginate"));
                            var prev = document.getElementsByClassName('previous')[0]
                            prev.classList.add('mr-3', 'cursor-pointer', 'hover:text-purple-500')
                            prev.innerHTML = '<i class="fas fa-chevron-left"></i>'

                            var next = document.getElementsByClassName('next')[0]
                            next.classList.add('ml-3', 'cursor-pointer', 'hover:text-purple-500')
                            next.innerHTML = '<i class="fas fa-chevron-right"></i>'

                            var page = document.getElementById('example_paginate').getElementsByTagName('span')[0].getElementsByClassName('paginate_button')
                            for (let i = 0; i < page.length; i++) {
                                if (page[i].classList.contains('current')) {
                                    page[i].classList.add('mx-1', 'text-purple-500')                    
                                }
                                page[i].classList.add('mx-1', 'cursor-pointer', 'hover:text-purple-500')                    
                            }

                            $('#example').on( 'draw.dt', function () {
                                prev = document.getElementsByClassName('previous')[0]
                                prev.classList.add('mr-3', 'cursor-pointer', 'hover:text-purple-500')
                                prev.innerHTML = '<i class="fas fa-chevron-left"></i>'

                                next = document.getElementsByClassName('next')[0]
                                next.classList.add('ml-3', 'cursor-pointer', 'hover:text-purple-500')
                                next.innerHTML = '<i class="fas fa-chevron-right"></i>'

                                page = document.getElementById('example_paginate').getElementsByTagName('span')[0].getElementsByClassName('paginate_button')
                                for (let i = 0; i < page.length; i++) {
                                    if (page[i].classList.contains('current')) {
                                        page[i].classList.add('mx-1', 'text-purple-500')                    
                                    }
                                    page[i].classList.add('mx-1', 'cursor-pointer', 'hover:text-purple-500')                    
                                }
                            })
                        })
                    </script> --}}
                    <div class="mt-3 w-full h-20 flex justify-center text-sm p-2" id="page"></div>
                </div>
            </div>
        </section>
    </div>
</main>

{{-- <script>
    $(document).ready(function() {
        let CSRF_TOKEN = document.getElementsByTagName('meta')[2].getAttribute('content')

        var table = $('#device').DataTable({
            "ordering": true,
            "info":     false,
            "lengthChange": false,
            "searching": true,
            "paging":   false,
            "dom": 'lrtip',
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('complain.ajax') }}",
                dataSrc: 'data',
                complete: function(data) {
                    // $("#page").append($(".dataTables_paginate"));

                    // var prev = document.getElementsByClassName('previous')[0]
                    // prev.classList.add('mr-3', 'cursor-pointer', 'hover:text-purple-500')
                    // prev.innerHTML = '<i class="fas fa-chevron-left"></i>'
    
                    // var next = document.getElementsByClassName('next')[0]
                    // next.classList.add('ml-3', 'cursor-pointer', 'hover:text-purple-500')
                    // next.innerHTML = '<i class="fas fa-chevron-right"></i>'
    
                    // var page = document.getElementById('device_paginate').getElementsByTagName('span')[0].getElementsByClassName('paginate_button')
                    // for (let i = 0; i < page.length; i++) {
                    //     if (page[i].classList.contains('current')) {
                    //         page[i].classList.add('mx-1', 'text-purple-500')                    
                    //     }
                    //     page[i].classList.add('mx-1', 'cursor-pointer', 'hover:text-purple-500')                    
                    // }
                }
            },
            columns: [
                {data: 'id'},
                {data: 'user'},
                {data: 'room'},
                {data: 'date_time'},
                {data: 'progress_status'},
                {
                    data: 'id',
                    orderAble: false
                },
                // {
                //     // orderable: true,
                //     // targets: -1,
                //     data: 'id_',
                //     // render: createAction(data)
                // }
            ],
            columnDefs: [
                {
                    "render": function ( data, type, row ) {
                        let user = {!! json_encode(Auth::user()->roles->pluck('name')[0]) !!}
                        console.log(user);
                        let carrier = document.createElement('div')
                        let container = document.createElement('div')
                        container.classList.add('flex', 'item-center', 'justify-center')
                        
                        let viewContainer = document.createElement('div')
                        viewContainer.classList.add('w-4', 'mr-2', 'transform', 'hover:text-purple-500', 'hover:scale-110')
                        container.appendChild(viewContainer)
                        let viewLink = document.createElement('a')
                        viewLink.href = window.location.origin + '/complain/' + data
                        viewContainer.appendChild(viewLink)
                        let viewIcon = document.createElement('i')
                        viewIcon.classList.add('fas', 'fa-eye')
                        viewLink.appendChild(viewIcon)

                        if (user == 'staff') {
                            // console.log(data);
                            // let editContainer = document.createElement('div')
                            // editContainer.classList.add('w-4', 'mr-2', 'transform', 'hover:text-purple-500', 'hover:scale-110')
                            // container.appendChild(editContainer)
                            // let editLink = document.createElement('a')
                            // editLink.href = window.location.origin + '/response/create/' + data
                            // editContainer.appendChild(editLink)
                            // let editIcon = document.createElement('i')
                            // editIcon.classList.add('fas', 'fa-edit')
                            // editLink.appendChild(editIcon)
                        } else {
                            let deleteContainer = document.createElement('div')
                            deleteContainer.classList.add('w-4', 'mr-2', 'transform', 'hover:text-purple-500', 'hover:scale-110')
                            container.appendChild(deleteContainer)
                            let deleteLink = document.createElement('a')
                            deleteLink.href = window.location.origin + '/complain/delete/' + data
                            deleteContainer.appendChild(deleteLink)
                            let deleteIcon = document.createElement('i')
                            deleteIcon.classList.add('fas', 'fa-trash-alt')
                            deleteLink.appendChild(deleteIcon)
                        }

                        carrier.appendChild(container)
                        return carrier.innerHTML
                    },
                    targets: -1
                },
                {
                    "render": function ( data, type, row ) {
                        let carrier = document.createElement('div')
                        let container = document.createElement('div')
                        container.classList.add('py-2', 'mx-auto', 'w-min')
                        
                        let statusContainer = document.createElement('div')
                        statusContainer.classList.add('rounded', 'text-gray-800', 'py-1', 'px-3', 'text-xs', 'font-bold')
                        statusContainer.innerHTML = data
                        if (data == 'Pending') {
                            statusContainer.classList.add('bg-yellow-400')
                        }

                        else if (data == 'Finished') {
                            statusContainer.classList.add('bg-green-400')
                        }

                        else {
                            statusContainer.classList.add('bg-blue-400')
                        }

                        container.appendChild(statusContainer)
                        carrier.appendChild(container)
                        return carrier.innerHTML
                    },
                    targets: -2
                }
            ]
        });

        setInterval( function () {
            table.ajax.reload();
        }, 60000 );

        // drawPaginate()

        $('#search_').keyup(function(){
            table.search($(this).val()).draw()
        })

        // $("#page").append($(".dataTables_paginate"));

        // $('#device').on( 'draw.dt', function () {
        //     drawPaginate()
        // })

        // function drawPaginate() {
        //     var prev = document.getElementsByClassName('previous')[0]
        //     prev.classList.add('mr-3', 'cursor-pointer', 'hover:text-purple-500')
        //     prev.innerHTML = '<i class="fas fa-chevron-left"></i>'

        //     var next = document.getElementsByClassName('next')[0]
        //     next.classList.add('ml-3', 'cursor-pointer', 'hover:text-purple-500')
        //     next.innerHTML = '<i class="fas fa-chevron-right"></i>'

        //     var page = document.getElementById('device_paginate').getElementsByTagName('span')[0].getElementsByClassName('paginate_button')
        //     for (let i = 0; i < page.length; i++) {
        //         if (page[i].classList.contains('current')) {
        //             page[i].classList.add('mx-1', 'text-purple-500')                    
        //         }
        //         page[i].classList.add('mx-1', 'cursor-pointer', 'hover:text-purple-500')                    
        //     }
        // }
    })
</script> --}}
@endsection
