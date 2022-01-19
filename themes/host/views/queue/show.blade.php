@extends('layouts.app')

@section('content')
<style>
    /* CHECKBOX TOGGLE SWITCH */
    /* @apply rules for documentation, these do not work as inline style */
    .toggle-checkbox:checked {
      @apply: right-0 border-green-400;
      right: 0;
      border-color: #68D391;
    }
    .toggle-checkbox:checked + .toggle-label {
      @apply: bg-green-400;
      background-color: #68D391;
    }
</style>

<main class="mx-auto px-2 sm:container sm:mx-auto mt-6 overflow-scroll">
    <div class="w-full sm:px-6">
        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="flex flex-col break-words bg-white sm:border-1 sm:shadow overflow-auto">
            <header class="px-6 py-5 font-semibold text-gray-700 bg-gray-200 sm:py-6 sm:px-8">
                Detail Queue
            </header>
            <div class="w-full p-3">
                <div class="w-full sm:px-6 mx-auto flex">
                    <div class="w-2/5 mx-4">
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00" for="standard_name">Tenant</label>
                            <div class="py-2 text-left w-full">
                                <input disabled value="{{ $queue->tenant->name }}" id="standard_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                            </div>
                        </div> 
                        <div class="mb-3">
                            <label class="block text-sm text-gray-00" for="status">Status</label>
                            <div class="py-2 text-center flex justify-center w-full">
                                <div class="w-1/2 flex">
                                    @if ($queue->status == 'queue')
                                        <div class="rounded bg-yellow-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                            Queue
                                        </div>
                                    @else
                                        @if ($queue->status == 'failed')
                                            <div class="rounded bg-red-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                Failed
                                            </div>
                                            <span class="ml-2">
                                                <form action="{{ route('queue.retry') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="activity_id" value="{{ $queue->activity_id }}">
                                                    <input type="hidden" name="tenant_id" value="{{ $queue->tenant_id }}">
                                                    <input type="hidden" name="payload" value="{{ $queue->payload }}">
                                                    <button type="submit" role="submit">
                                                        <i class="material-icons">replay</i>
                                                    </button>
                                                </form>
                                            </span>
                                        @else
                                            <div class="rounded bg-green-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                Success
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div> 
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00" for="created_at">Jumlah Alat</label>
                            <div class="py-2 text-center w-full">
                                {{ count($payload) }}
                            </div>
                        </div> 
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00" for="created_at">Created at</label>
                            <div class="py-2 text-left text-xs w-full">
                                {{ $queue->created_at }}
                            </div>
                        </div> 
                    </div>
                    <div class="w-full mx-4 overflow-auto">
                        <table id="tenants" class="min-w-max w-full table-auto text-center">
                            <thead class="shadow">
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6">Inventory ID</th>
                                    <th class="py-3 px-6">Kode Alat</th>
                                    <th class="py-3 px-6">Kode Ruang</th>
                                    <th class="py-3 px-6">Serial</th>
                                    <th class="py-3 px-6">Merk</th>
                                    <th class="py-3 px-6">Tipe</th>
                                    <th class="py-3 px-6">Tanggal Sertifikat</th>
                                    <th class="py-3 px-6">Nomor Sertifikat</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach ($payload as $p)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6">
                                            <a target="blank_" href="{{ 'http://'.$queue->tenant->domain.'/inventory/'.$p->inventory_id }}" class="hover:text-purple-500">
                                                {{ $p->inventory_id }}
                                            </a>
                                        </td>
                                        <td class="py-3 px-6">
                                            {{ $p->cd_alat }}
                                        </td>
                                        <td class="py-3 px-6">
                                            {{ $p->cd_ruang }}
                                        </td>
                                        <td class="py-3 px-6">
                                            {{ $p->sn }}
                                        </td>
                                        <td class="py-3 px-6">
                                            {{ $p->merk }}
                                        </td>
                                        <td class="py-3 px-6">
                                            {{ $p->tipe }}
                                        </td>
                                        <td class="py-3 px-6">
                                            {{ $p->tgl_ser }}
                                        </td>
                                        <td class="py-3 px-6">
                                            {{ $p->no_ser }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>       
            </div>
        </section>

        <section class="flex flex-col break-words bg-white sm:border-1 sm:shadow overflow-auto">
            <header class="px-6 py-5 font-semibold text-gray-700 bg-gray-200 sm:py-6 sm:px-8">
                Riwayat Log
            </header>
            <div class="w-full p-3">
                <form class="w-full" enctype="multipart/form-data" method="POST"
                    action="{{ route('tenant.store') }}">
                    @csrf
                    <div class="w-full sm:px-6 mx-auto flex">
                        <div class="w-full mx-4 overflow-auto">
                            <table id="tenants" class="min-w-max w-full table-auto text-center">
                                <thead class="shadow">
                                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 w-96">Response</th>
                                        <th class="py-3 px-6">Status</th>
                                        <th class="py-3 px-6">Created at</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach ($queue->logs as $q)
                                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                                            <td class="py-3 px-6 w-96 text-left">
                                                {{ json_decode($q->response)->msg }}
                                            </td>
                                            <td class="py-3 px-6">
                                                @if (json_decode($q->response)->success)
                                                    <div class="rounded bg-green-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                        Success
                                                    </div>
                                                @else
                                                    <div class="rounded bg-red-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                        Failed
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="py-3 px-6">
                                                {{ $q->created_at }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>       
                </form>
            </div>
        </section>
    </div>
</main>
@endsection