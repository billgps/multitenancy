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
                    <a href="{{ route('room.edit', ['room' => $room->id]) }}" class="mx-2 text-gray-600 hover:text-gray-400">
                        <i class="fas fa-edit"></i>
                    </a>   
                @endif
                @if (Auth::user()->role < 1)
                    <a href="{{ route('room.delete', ['room' => $room->id]) }}" class="mx-2 text-gray-600 hover:text-gray-400">
                        <i class="fas fa-trash-alt"></i>
                    </a>     
                @endif
            </div>
            <div class="bg-white">
                <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                    {{ $room->room_name }}
                    <div class="text-xs font-light">
                        {{ __('Created at : '.$room->created_at) }}
                    </div>
                </header>
    
                <div class="w-full flex mr-auto pb-6 px-6 my-6">
                    <div class="block sm:px-6">
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00" for="standard_name">Unit</label>
                            <div class="py-2 text-left w-full">
                                <input disabled value="{{ $room->unit }}" id="standard_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00" for="alias_name">Gedung</label>
                            <div class="py-2 text-left w-full">
                                <input disabled value="{{ $room->building }}" id="alias_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00" for="alias_name">Nama Ruangan</label>
                            <div class="py-2 text-left w-full">
                                <input disabled value="{{ $room->room_name }}" id="standard_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                            </div>
                        </div>
                        <div class="flex flex-wrap mb-3">
                            <label class="block text-sm text-gray-00" for="alias_name">PIC Ruangan</label>
                            <div class="py-2 text-left w-full">
                                <input disabled value="{{ $room->room_pic }}" id="standard_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                            </div>
                        </div>
                    </div>    
                    <div class="ml-auto text-sm h-11/12 w-8/12">
                        <table class="w-full">
                            <thead>
                                <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                                    <th class="px-4 py-3 text-center">Nama Alat</th>
                                    <th class="px-4 py-3 text-center">Jumlah</th>
                                    <th class="px-4 py-3 text-center">
                                        <i class="fas fa-cog"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($legends as $item)
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-3 border break-normal w-96">
                                            {{ $item->standard_name }}
                                        </td>
                                        <td class="px-4 py-3 text-ms font-semibold border text-center">
                                            {{ $item->c }}
                                        </td>
                                        <td class="px-4 py-3 text-sm border">
                                            <div class="flex item-center justify-center">
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <a href="{{ route('device.show', ['id' => $item->id]) }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                                @if (Auth::user()->role < 2)
                                                    <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                        <a href="{{ route('device.edit', ['device' => $item->id]) }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                                @if (Auth::user()->role < 1)
                                                    <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                        <a href="{{ route('device.delete', ['device' => $item->id]) }}">
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
                    </div>
                </div>
            </div>
        </section>

        <section class="flex flex-col mt-3 break-words bg-white sm:border-1">
            <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                List Inventori
            </header>

            <div class="w-full px-6 py-3">
                <div id="display" class="flex flex-col lg:grid lg:grid-cols-4 gap-2 w-full justify-center">
                    @foreach ($inventories as $inventory)
                        <div class="max-w-xs flex flex-col rounded overflow-hidden bg-gray-100 my-2">
                            <div class="w-full h-48 text-sm">
                                <img class="object-cover h-48 w-full" src="{{ asset($inventory->picture) }}" alt="{{ $inventory->barcode }}">
                            </div>
                            <div class="text-md flex hover:text-purple-500 mx-2 my-2">
                                <a href="{{ route('inventory.param', ['parameter' => 'device', 'value' => $inventory->device_id]) }}">
                                    {{ $inventory->device->standard_name }}
                                    @if ($inventory->is_verified)
                                        <i class="fas fa-check-circle text-blue-500 mx-2 my-1 aspak-verified"></i>
                                    @endif
                                </a>
                            </div>
                            <div class="flex mb-2 mx-2">
                                @if ($inventory->latest_condition)
                                    <div class="flex mb-2 mx-2">
                                        @if ($inventory->latest_condition->status != 'Rusak')
                                            @if ($inventory->latest_condition->status == 'Baik')
                                                <div class="rounded bg-green-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                    {{ $inventory->latest_condition->status }}
                                                </div>
                                            @else
                                                <div class="rounded bg-yellow-300 text-gray-800 py-1 px-3 text-xs font-bold">
                                                    Belum Update
                                                </div>
                                            @endif
                                        @else
                                            <div class="rounded bg-red-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                {{ $inventory->latest_condition->status }}
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="flex mb-2 mx-2">
                                        <div class="rounded bg-yellow-300 text-gray-800 py-1 px-3 text-xs font-bold">
                                            Belum Update
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full text-xs px-2">
                                <div class="flex">Barcode :</div>
                                <div class="flex justify-end text-right">
                                    {{ $inventory->barcode }}
                                </div>
                                <div class="flex">Merk :</div>
                                <div class="flex justify-end hover:text-purple-500 text-right">
                                    <div class="flex justify-end hover:text-purple-500 text-right">
                                        <a href="{{ route('inventory.param', ['parameter' => 'brand', 'value' => $inventory->identity->brand->id]) }}">
                                            {{ $inventory->identity->brand->brand }}
                                        </a>
                                    </div>
                                </div>
                                <div class="flex">Model :</div>
                                <div class="flex justify-end text-right">
                                    {{ $inventory->identity->model }}
                                </div>
                                <div class="flex">Serial Number :</div>
                                <div class="flex justify-end text-right">
                                    {{ $inventory->serial }}
                                </div>
                                <div class="flex">Ruangan :</div>
                                <div class="flex justify-end hover:text-purple-500 text-right">
                                    <a href="{{ route('inventory.param', ['parameter' => 'room', 'value' => $inventory->room_id]) }}">
                                        {{ $inventory->room->room_name }}
                                    </a>
                                </div>
                                <div class="flex">No. Label :</div>
                                @isset($inventory->latest_record)
                                    <div class="flex justify-end text-right">
                                        {{ $inventory->latest_record->label }}
                                    </div>
                                @endisset
                                <div class="flex">Status Kalibrasi :</div>
                                @isset($inventory->latest_record)
                                    <div class="flex justify-end text-right">
                                        @if ($inventory->latest_record->calibration_status == 'Terkalibrasi')
                                            <div class="rounded bg-green-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                Terkalibrasi
                                            </div>
                                        @elseif ($inventory->latest_record->calibration_status == 'Expired')
                                            <div class="rounded bg-red-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                Expired
                                            </div>
                                        @else
                                            <div class="rounded bg-yellow-300 text-gray-800 py-1 px-3 text-xs font-bold">
                                                Wajib Kalibrasi
                                            </div>
                                        @endif
                                    </div>
                                @endisset
                            </div>
                            <div class="px-6 py-4 mt-auto">
                                <div class="flex item-end justify-center">
                                    <a href="{{ route('inventory.show', ['id' => $inventory->id]) }}">
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </div>
                                    </a>
                                    @if (Auth::user()->role < 2)
                                        <a href="{{ route('inventory.edit', ['inventory' => $inventory->id]) }}">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </div>
                                        </a>
                                    @endif
                                    @if (Auth::user()->role < 1)
                                        <a href="{{ route('inventory.delete', ['inventory' => $inventory->id]) }}">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </div>
                                        </a>    
                                    @endif   
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function () {
            tippy(".aspak-verified", {
                content: "Item ini sudah terverifikasi ASPAK"
            })
        })
    </script>
</main>
@endsection