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
            <div class="flex flex-col sm:col-span-6 break-words bg-white sm:border-1">

                <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                    {{ __('Daftar Nama Alat') }}
                </header>   
                <div class="w-full px-6 py-3">
                    <table id="device" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6">Nama Alat</th>
                                <th class="py-3 px-6"></th>
                                <th class="py-3 px-6">ID</th>
                                <th class="py-3 px-6">Nomenklatur</th>
                                <th class="py-3 px-6">IPM Frequency</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($devices as $device)
                                <tr class="hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left w-80 break-normal">
                                        {{ $device['nama_alat'] }}
                                        <input type="hidden" name="standard_name[]" value="{{ $device['nama_alat'] }}">
                                    </td>
                                    <td>
                                        <a href="#map" rel="modal:open">
                                            <i class="fas fa-exchange"></i>
                                        </a>
                                    </td>
                                    @if ($device['nomenclature_id'])
                                        <td class="nom-id w-8 font-semibold">
                                            {{ $device['nomenclature_id']->id }}
                                            <input type="hidden" name="nomenclature_id[]" value="{{ $device['nomenclature_id']->id }}">
                                        </td>
                                        <td class="nom-name break-normal w-96 text-justify">
                                            {{ $device['nomenclature_id']->standard_name }}
                                        </td>
                                        <td class="nom-risk flex w-full h-16 justify-center items-center">
                                            @if ($device['nomenclature_id']->standard_name == 3)
                                                <div class="rounded bg-red-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                    4 Bulan (High)
                                                </div>
                                            @elseif($device['nomenclature_id']->standard_name == 2)
                                                <div class="rounded bg-yellow-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                    6 Bulan (Medium)
                                                </div>
                                            @else
                                                <div class="rounded bg-green-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                    12 Bulan (Low)
                                                </div>
                                            @endif
                                        </td>
                                    @else
                                        <td colspan="3" class="not-found text-center bg-red-200 hover:bg-red-300 hover:text-gray-600 text-gray-400 font-semibold">
                                            Match Not Found (Code 404)
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 
                </div>
            </div>
        </section>
    </div>
</main>

<div id="map" style="background-color: rgb(31, 41, 55);" class="modal text-gray-200 flex items-center justify-center">
    <div class="flex justify-between items-center pb-3 text-lg">
        Find Nomenclature
    </div>
    <div class="text-xs">
        <div>
            <label class="block mb-2 text-sm text-gray-00" for="file">Records</label>
            <div class="py-2 text-left">
                <input id="file" name="file" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
            </div>
        </div>
        <div class="flex w-full justify-end pt-2">
            <input type="submit" value="{{ __('Import') }}" class="block text-center text-white bg-green-600 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
        </div>
    </div>
</div>  
@endsection