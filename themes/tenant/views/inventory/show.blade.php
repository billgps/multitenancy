@extends('layouts.app')

@section('content')
<style>
    .select2-results__option, .select2-search__field {
        color: black;
        font-size: 0.75rem !important;
        line-height: 1rem !important;
    }

    .select2-container--default .select2-selection--single {
        --tw-text-opacity: 1 !important;
        color: rgba(55, 65, 81, var(--tw-text-opacity)) !important;
        padding-left: 1.25rem !important;
        padding-right: 1.25rem !important;
        padding-top: 0.25rem !important;
        padding-bottom: 0.25rem !important;
        outline: 2px solid transparent !important;
        outline-offset: 2px !important;
        border-style: none !important;
        border-radius: 0.25rem !important;
        --tw-bg-opacity: 1 !important;
        background-color: rgba(229, 231, 235, var(--tw-bg-opacity)) !important;
    }

    .select2-selection__rendered {
        text-align: left !important;
    }

    /* select {
        width: 50%;
    } */
</style>

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
                    <a href="{{ route('inventory.edit', ['inventory' => $inventory->id]) }}" class="mx-2 text-gray-600 hover:text-gray-400 modal-open image-toggle">
                        <i class="fas fa-edit"></i>
                    </a>   
                @endif
                @if (Auth::user()->role < 1)
                    <a href="{{ route('inventory.delete', ['inventory' => $inventory->id]) }}" class="mx-2 text-gray-600 hover:text-gray-400 modal-open image-toggle">
                        <i class="fas fa-trash-alt"></i>
                    </a>     
                @endif
                <a href="{{ route('inventory.excel', ['inventory' => $inventory->id]) }}" class="mx-2 text-gray-600 hover:text-gray-400 modal-open image-toggle">
                    <i class="fas fa-file-download"></i>
                </a>   
                {{-- <div class="ml-auto my-auto flex text-xs">
                    <input class="h-8 rounded-r-none text-xs text-gray-800 w-full px-2 rounded-md focus:ring-0 border-none" id="search_" type="text" placeholder="Search..." name="search" />
                    <button type="button" class="h-8 rounded-l-none w-20 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:text-gray-800 hover:bg-gray-400 active:bg-gray-900 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">
                        Search
                    </button>
                </div> --}}
            </div>
            <div class="bg-white">
                <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                    Detail Inventory
                    <div class="text-xs">
                        {{ $inventory->barcode }}
                    </div>
                </header>
    
                <div class="w-full flex mr-auto pb-6 px-6 my-6">
                    <div class="md:grid grid-cols-2 gap-3 sm:px-6">
                        <div>
                            <div class="flex flex-wrap mb-3">
                                <label class="block text-sm text-gray-00" for="standard_name">Nama Alat</label>
                                <div class="py-2 text-left w-full">
                                    <input disabled value="{{ $inventory->device->standard_name }}" id="standard_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                                </div>
                            </div>
                            <div class="flex flex-wrap mb-3">
                                <label class="block text-sm text-gray-00" for="standard_name">Merk</label>
                                <div class="py-2 text-left w-full">
                                    <input disabled value="{{ $inventory->identity->brand->brand }}" id="standard_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                                </div>
                            </div>
                            <div class="flex flex-wrap mb-3">
                                <label class="block text-sm text-gray-00" for="standard_name">Tipe Alat</label>
                                <div class="py-2 text-left w-full">
                                    <input disabled value="{{ $inventory->identity->model }}" id="standard_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                                </div>
                            </div>
                            <div class="flex flex-wrap mb-3">
                                <label class="block text-sm text-gray-00" for="standard_name">Nomor Seri</label>
                                <div class="py-2 text-left w-full">
                                    <input disabled value="{{ $inventory->serial }}" id="standard_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                                </div>
                            </div>
                            <div class="flex flex-wrap mb-3">
                                <label class="block text-sm text-gray-00" for="standard_name">Penyusutan Alat</label>
                                <div class="py-2 text-left w-full">
                                    <input disabled value="{{$inventory->penyusutan }}" id="penyusutan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flex flex-wrap mb-3">
                                <label class="block text-sm text-gray-00" for="standard_name">Ruangan</label>
                                <div class="py-2 text-left w-full">
                                    <input disabled value="{{ $inventory->room->room_name }}" id="standard_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                                </div>
                            </div>
                            <div class="flex flex-wrap mb-3">
                                <label class="block text-sm text-gray-00" for="standard_name">Tahun Perolehan Alat</label>
                                <div class="py-2 text-left w-full">
                                    <input disabled value="{{ $inventory->year_purchased }}" id="standard_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                                </div>
                                </div>
                                <div class="flex flex-wrap mb-3">
                                <label class="block text-sm text-gray-00" for="standard_name">Harga</label>
                                <div class="py-2 text-left w-full">
                                    <input disabled value="{{ 'Rp. '.$inventory->price }}" id="standard_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                                </div>
                            </div>
                            <div class="flex flex-wrap mb-3">
                                <label class="block text-sm text-gray-00" for="standard_name">Vendor</label>
                                <div class="py-2 text-left w-full">
                                    <input disabled value="{{$inventory->supplier}}" id="supplier" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text">
                                </div>
                            </div>
                        </div>
                    </div>    
                    <div class="ml-auto my-auto p-6 flex flex-col justify-center">
                        <div class="text-xs text-right my-2">
                            {{ __('Created at : '.$inventory->created_at) }}
                        </div>
                            {{-- <img onclick="toggleModal(this, 'image-toggle', 'image-modal')" class="modal-open image-toggle h-96 w-96 object-cover object-center" src="{{ asset($inventory->picture) }}" alt=""> --}}
                            <a href="#image" rel="modal:open">
                                <img class="h-96 w-96 object-cover object-center" src="{{ asset($inventory->picture) }}" alt="">
                            </a>
                    </div>
                </div>
            </div>
        </section>

        @isset($asset->id)
            <section class="flex flex-col mt-3 break-words bg-white sm:border-1">
                <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                    Data Aset
                    {{-- @if (Auth::user()->role < 2)
                        <span>
                            <a class="mx-2 text-green-600 hover:text-gray-400" href="{{ route('maintenance.create', ['inventory' => $inventory->id]) }}">
                                <i class="fas fa-plus"></i>
                            </a>
                        </span>
                    @endif --}}
                </header>

                <div class="w-full px-6 py-3">
                    <table id="conditions" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6">Nama Alat</th>
                                <th class="py-3 px-6">Harga</th>
                                <th class="py-3 px-6">Tahun Pembelian</th>
                                <th class="py-3 px-6">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6">
                                    {{ $inventory->device->standard_name }}
                                </td>
                                <td class="py-3 px-6">
                                    {{ $asset->price }}
                                </td>
                                <td class="py-3 px-6">
                                    {{ $asset->year_purchased }}
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        @if (Auth::user()->role < 2)
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('asset.edit', ['asset' => $asset->id]) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        @endif
                                        @if (Auth::user()->role < 1)
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('asset.delete', ['asset' => $asset->id]) }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </section>
        @endisset

        @isset($records)
            <section class="flex flex-col mt-3 break-words bg-white sm:border-1">
                <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                    Riwayat Kalibrasi
                    @if (Auth::user()->role < 2)
                        <span class="text-graan-500">
                            <a class="mx-2 text-green-600 hover:text-gray-400" href="{{ route('record.create', ['inventory' => $inventory->id]) }}">
                                <i class="fas fa-plus"></i>
                            </a>
                        </span>
                    @endif
                </header>

                <div class="w-full px-6 py-3">
                    <table id="records" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6">Tanggal Kalibrasi</th>
                                <th class="py-3 px-6">Nomor Label</th>
                                <th class="py-3 px-6">Status Kalibrasi</th>
                                <th class="py-3 px-6">Hasil</th>
                                <th class="py-3 px-6">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($records as $record)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6">
                                        {{ $record->cal_date }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $record->label }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $record->calibration_status }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $record->result }}
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            @if (Auth::user()->role < 2)
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <a href="{{ route('record.edit', ['record' => $record->id]) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('record.download.report', ['record' => $record->id]) }}">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            </div>
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('record.download.certificate', ['record' => $record->id]) }}">
                                                    <i class="fas fa-award"></i>
                                                </a>
                                            </div>
                                            @if (Auth::user()->role < 1)
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <a href="{{ route('record.delete', ['record' => $record->id]) }}">
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
            </section>
        @endisset

        @isset($conditions)   
            <section class="flex flex-col mt-3 break-words bg-white sm:border-1">
                <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                    Riwayat Kondisi
                    @if (Auth::user()->role < 2)
                        <span>
                            <a class="mx-2 text-green-600 hover:text-gray-400" href="{{ route('condition.create', ['inventory' => $inventory->id]) }}">
                                <i class="fas fa-plus"></i>
                            </a>
                        </span>
                    @endif
                </header>

                <div class="w-full px-6 py-3">
                    <table id="conditions" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6">Tanggal Kejadian</th>
                                <th class="py-3 px-6">Status Alat</th>
                                <th class="py-3 px-6">Lembar Kerja</th>
                                <th class="py-3 px-6">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($conditions as $condition)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6">
                                        {{ $condition->event_date }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $condition->status }}
                                    </td>
                                    <td class="py-3 px-6">
                                        <a href="{{ route('condition.download.worksheet', ['condition' => $condition->id]) }}">
                                            {{ $condition->worksheet }}
                                        </a>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('condition.show', ['condition' => $condition->id]) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                            @if (Auth::user()->role < 2)
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <a href="{{ route('condition.edit', ['condition' => $condition->id]) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            @endif
                                            @if (Auth::user()->role < 1)
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <a href="{{ route('condition.delete', ['condition' => $condition->id]) }}">
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
            </section>
        @endisset

        @isset($maintenances)
            <section class="flex flex-col mt-3 break-words bg-white sm:border-1">
                <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                    Riwayat Maintenance
                    @if (Auth::user()->role < 2)
                        <span>
                            <a class="mx-2 text-green-600 hover:text-gray-400" href="{{ route('maintenance.create', ['inventory' => $inventory->id]) }}">
                                <i class="fas fa-plus"></i>
                            </a>
                        </span>
                    @endif
                </header>

                <div class="w-full px-6 py-3">
                    <table id="conditions" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th></th>
                                <th class="py-3 px-6">Nama Alat</th>
                                <th class="py-3 px-6">Tanggal Pengerjaan</th>
                                <th class="py-3 px-6">Petugas</th>
                                <th class="py-3 px-6">Hasil</th>
                                <th class="py-3 px-6">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($maintenances as $m)
                                <tr class="hover:bg-gray-100">
                                    <td class="dt-control"></td>
                                    <td class="py-3 px-3 text-left flex-nowrap">
                                        {{ $m->inventory->device->standard_name }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $m->created_at }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $m->user->name }}
                                    </td>
                                    <td>
                                        @if ($m->result == 'Alat Bekerja dengan Baik')
                                            <div class="rounded w-max bg-green-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                {{ $m->result }}
                                            </div>
                                        @else
                                            <div class="rounded w-max bg-red-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                {{ $m->result }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('inventory.show', ['id' => $m->inventory_id]) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('maintenance.download', ['maintenance' => $m->id]) }}">
                                                    <i class="fas fa-file-alt"></i>
                                                </a>
                                            </div>
                                            @if (Auth::user()->role < 2)
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <a href="{{ route('maintenance.edit', ['maintenance' => $m->id]) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            @endif
                                            @if (Auth::user()->role < 1)
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <a href="{{ route('maintenance.delete', ['maintenance' => $m->id]) }}">
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
            </section>
        @endisset
    </div>
</main>

<div id="image" style="width: fit-content; height:fit-content; padding: 0px;" class="modal text-gray-200 flex items-center justify-center">
    <img class="object-cover object-center" src="{{ asset($inventory->picture) }}" onerror="this.src = '/images/no_image.jpg';" >
</div>
@endsection