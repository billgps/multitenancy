@extends('layouts.app')

@section('content')
<main class="sm:container sm:mx-auto mt-6">
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="flex flex-col break-words bg-white sm:border-1 sm:shadow">
            <header class="px-6 py-5 font-semibold text-gray-700 bg-gray-200 sm:py-6 sm:px-8">
                Log History
            </header>
            <div class="w-full sm:p-6 overflow-x-scroll sm:overflow-x-auto">
                <table id="tenants" class="min-w-max w-full table-auto text-center">
                    <thead class="shadow">
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6">Queue ID</th>
                            <th class="py-3 px-6">Response</th>
                            <th class="py-3 px-6">Message</th>
                            <th class="py-3 px-6">Created at</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($logs as $log)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6">
                                    {{ $log->queue->id }}
                                </td>
                                <td class="py-3 px-6">
                                    @if (json_decode($log->response)->success)
                                        <div class="rounded bg-green-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                            Success
                                        </div>
                                    @else
                                        <div class="rounded bg-red-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                            Failed
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 px-6 w-72">
                                    <a href="" class="hover:text-purple-500">
                                        {{ json_decode($log->response)->msg }}
                                    </a>
                                </td>
                                <td class="py-3 px-6">
                                    {{ $log->created_at }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if(Route::currentRouteName() == 'log.index')
                    <div class="mt-16 flex w-full justify-center">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </section>
    </div>
</main>
@endsection