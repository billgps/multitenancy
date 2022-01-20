@extends('layouts.app')

@section('content')
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

        <section class="flex flex-col break-words bg-white sm:border-1 sm:shadow">
            <header class="px-6 py-5 font-semibold text-gray-700 bg-gray-200 sm:py-6 sm:px-8">
                Queue List
            </header>
            <div class="w-full sm:p-6 overflow-x-scroll sm:overflow-x-auto">
                <table id="tenants" class="min-w-max w-full table-auto text-center">
                    <thead class="shadow">
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6">Tenant</th>
                            <th class="py-3 px-6">Status</th>
                            <th class="py-3 px-6">Log</th>
                            <th class="py-3 px-6">Created at</th>
                            <th class="py-3 px-6">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($queues as $queue)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-16 flex w-full justify-center">
                    {{ $queues->links() }}
                </div>
            </div>
        </section>
    </div>
</main>
@endsection