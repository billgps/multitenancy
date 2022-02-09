@extends('layouts.app')

@section('content')
<style>
    input:checked + svg {
        display: block;
    }
</style>

<script>
    function deleteConfirm(queue) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        swal({
            title: "Yakin ingin menghapus Queue?",
            text: "Data yang sudah dihapus tidak bisa dikembalikan!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url    : "/ajax/queue/delete/" + queue,
                    type   : "delete",
                    success: function(data) {
                        swal("Queue sudah dihapus!", {
                            icon: "success",
                        }).then((success) => {
                            $(location).attr('href', "{{route('queue.index')}}"); // temporary, next time do ajax dataatbles refresh
                        })
                    },
                    error: function (error) {
                        console.log(error);
                    }
                })
            }
        });
    }
</script>
<main class="sm:container sm:mx-auto mt-6">
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('queue.send') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section class="flex flex-col break-words bg-white sm:border-1 sm:shadow">
                <header class="px-6 py-5 font-semibold text-gray-700 bg-gray-200 sm:py-6 sm:px-8">
                    Queue List
                </header>
                <div class="flex items-center w-full py-3 px-4">
                    <div class="w-full h-10 pl-3 pr-2 border rounded-full flex justify-between items-center relative">
                        <input type="search" name="search" id="searchTerm" placeholder="Search"
                               class="appearance-none bg-transparent border-none focus:ring-0 w-full outline-none focus:outline-none active:outline-none"/>
                        <button type="submit" role="submit" class="ml-1 hover:text-purple-500 outline-none focus:outline-none active:outline-none">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                viewBox="0 0 24 24" class="w-6 h-6">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="w-4 mx-2 transform hover:text-purple-500 hover:scale-110">
                        <button type="submit">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
                <div class="w-full sm:p-6 overflow-x-scroll sm:overflow-x-auto">
                    <table id="queues" class="min-w-max w-full table-auto text-center">
                        <thead class="shadow">
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th></th>
                                <th class="py-3 px-6">Tenant</th>
                                <th class="py-3 px-6">Status</th>
                                <th class="py-3 px-6">Log</th>
                                <th class="py-3 px-6">Created at</th>
                                <th class="py-3 px-6">Action</th>
                                <th class="never">payload</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($queues as $queue)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6">
                                        @if ($queue->status == "success")
                                            <div class="bg-white border-2 rounded border-gray-400 w-6 h-6 flex flex-shrink-0 justify-center items-center mr-2 focus-within:border-blue-500">
                                                <input name="queues[]" value="{{ $queue->id }}" type="checkbox" class="opacity-0 absolute" checked disabled>
                                                <svg class="fill-current hidden w-4 h-4 text-green-500 pointer-events-none" viewBox="0 0 20 20"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/></svg>
                                            </div>
                                        @elseif($queue->status == "failed")
                                            <div class="bg-gray-200 border-2 rounded border-gray-400 w-6 h-6 flex flex-shrink-0 justify-center items-center mr-2 focus-within:border-blue-500">
                                                <input name="queues[]" value="{{ $queue->id }}" type="checkbox" class="opacity-0 absolute" disabled>
                                                <svg class="fill-current hidden w-4 h-4 text-green-500 pointer-events-none" viewBox="0 0 20 20"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/></svg>
                                            </div>
                                        @else
                                            <div class="bg-white border-2 rounded border-gray-400 w-6 h-6 flex flex-shrink-0 justify-center items-center mr-2 focus-within:border-blue-500">
                                                <input name="queues[]" value="{{ $queue->id }}" type="checkbox" class="opacity-0 absolute">
                                                <svg class="fill-current hidden w-4 h-4 text-green-500 pointer-events-none" viewBox="0 0 20 20"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/></svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $queue->tenant->database }}
                                    </td>
                                    <td class="py-3 px-6">
                                        @if ($queue->status == 'queue')
                                            <div class="rounded bg-yellow-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                Queue
                                            </div>
                                        @else
                                            @if ($queue->status == 'failed')
                                                <div class="rounded bg-red-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                    Failed
                                                </div>
                                            @else
                                                <div class="rounded bg-green-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                    Success
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="py-3 px-6">
                                        <a href="{{ route('queue.logs', ['queue' => $queue->id]) }}" class="hover:text-purple-500">
                                            <i class="material-icons">history</i>
                                            <span class="">
                                                {{ $queue->logs->count() }}
                                            </span>
                                        </a>
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $queue->created_at }}
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('queue.show', ['queue' => $queue->id]) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <button role="button" type="button" onclick="deleteConfirm({{ $queue->id }})">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="never text-left">
                                        {{ $queue->payload }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <script>
                        $(document).ready(function() {
                            let dataTable = $("#queues").DataTable({
                                pageLength: 100,
                                dom: "lrtp",
                                lengthChange: false,
                                order:[[4, 'desc']],
                                columnDefs: [
                                    {targets: [0, 5], orderable: false},
                                    {targets: [6], orderable: false, visible: false},
                                    {targets: [1, 2, 3, 4], orderable: true}
                                ]
                            })

                            $('#searchTerm').keyup(function(){
                                dataTable.search($(this).val()).draw() ;
                            })
                        })
                    </script>
                </div>
            </section>
        </form>
    </div>
</main>
@endsection