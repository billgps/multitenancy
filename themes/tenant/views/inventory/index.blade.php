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
            <div class="col-span-6 h-12 flex items-center py-2 px-4 bg-gray-200" x-data="{ dropdownOpen: false }">
                @if (Auth::user()->role < 2)
                    <a class="mx-2 text-green-600 hover:text-gray-400" href="{{ route('inventory.create') }}">
                        <i class="fas fa-plus"></i>
                    </a>
                @endif
                @if (Auth::user()->hasRole(['admin', 'staff']))
                    <a href="#image" rel="modal:open" class="mx-2 text-yellow-600 hover:text-gray-400">
                        <i class="fas fa-images"></i>
                    </a>  
                    <div id="image" style="background-color: rgb(31, 41, 55);" class="modal text-gray-200 flex items-center justify-center">
                        <div class="flex justify-between items-center pb-3 text-lg">
                            Upload Images to Inventory
                        </div>
                        <form action="{{ route('inventory.image') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="text-xs">
                                <div>
                                    <label class="block mb-2 text-sm text-gray-00" for="file">Images</label>
                                    <div class="py-2 text-left">
                                        <input id="file" name="file[]" type="file" multiple="multiple">
                                    </div>
                                </div>
                                <div class="flex w-full justify-end pt-2">
                                    <input type="submit" value="{{ __('Upload') }}" class="block text-center text-white bg-green-600 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
                                </div>
                            </div>
                        </form>
                    </div>

                    <a href="#import" rel="modal:open" class="mx-2 text-blue-600 hover:text-gray-400 import-toggle">
                        <i class="fas fa-file-upload"></i>
                    </a> 
                    <div id="import" style="background-color: rgb(31, 41, 55);" class="modal text-gray-200 flex items-center justify-center">
                        <div class="flex justify-between items-center pb-3 text-lg">
                            Import Excel to Inventory
                        </div>
                        <form action="{{ route('inventory.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="text-xs">
                                <div>
                                    <label class="block mb-2 text-sm text-gray-00" for="file">Inventories</label>
                                    <div class="py-2 text-left">
                                        <input id="fuck" name="fuck" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    </div>
                                </div>
                                <div class="flex w-full justify-end pt-2">
                                    <input type="submit" value="{{ __('Import') }}" class="block text-center text-white bg-green-600 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
                                </div>
                            </div>
                        </form>
                    </div>
                @endif   
                <button @click="dropdownOpen = !dropdownOpen" class="relative z-10 block mx-2 text-blue-600 hover:text-gray-400">
                    <i class="fas fa-download"></i>
                </button>
                <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

                <div x-show="dropdownOpen" class="absolute top-28 left-48 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                    <a @click="dropdownOpen = false" href="{{ route('inventory.export') }}" class="w-full text-left block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-400 hover:text-white">
                        Recap
                    </a>       
                    <a @click="dropdownOpen = false"  href="{{ route('inventory.raw') }}" class="w-full text-left block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-400 hover:text-white">
                        Raw
                    </a>       
                </div> 
                <div class="ml-auto my-auto text-xs">
                    <form action="{{ route('inventory.search') }}" method="post" class="flex">
                        @csrf
                        <input class="h-8 rounded-r-none text-xs text-gray-800 w-full px-2 rounded-md focus:ring-0 border-none" id="search_" type="text" placeholder="Search..." name="search" />
                        <input type="submit" value="Search" class="h-8 rounded-l-none w-20 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:text-gray-800 hover:bg-gray-400 active:bg-gray-900 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">
                    </form>
                </div>
            </div>
            <div class="col-span-6 flex w-full p-4 bg-gray-200">
                <div class="w-full justify-center text-gray-600">
                    <div class="text-md">
                        Data Inventaris
                    </div>
            
                    <div id="display" class="flex flex-col lg:grid lg:grid-cols-4 gap-2 w-full justify-center">
                        @foreach ($inventories as $inventory)
                            <div x-data="{ dropdownOpen: false }" class="max-w-xs flex flex-col rounded overflow-hidden bg-gray-100 my-2">
                                <div class="w-full h-48 text-sm relative">
                                    <div @click="dropdownOpen = !dropdownOpen" class="hover:text-purple-500 cursor-pointer absolute transform hover:scale-110 top-0 right-0 mr-2 mt-2" href="">
                                        <i class="fas fa-cog fa-lg"></i>
                                    </div>

                                    <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

                                    <div x-show="dropdownOpen" class="absolute right-0 mt-8 py-2 bg-white rounded-md shadow-xl z-20">
                                        <a href="{{ route('maintenance.create', ['inventory' => $inventory->id]) }}" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                                            <i class="fas fa-tools mr-4"></i>
                                            Preventive Maintenance
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                                            <i class="fas fa-tachometer-alt-slowest mr-4"></i>
                                            Riwayat Kalibrasi
                                        </a>
                                    </div>
                                    
                                    <img class="object-cover h-48 w-full" src="{{ asset($inventory->picture) }}"onerror="this.src = '/images/no_image.jpg';">
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
                                                    <div class="rounded bg-green-400 text-gray-800 py-1 px-2 text-xs font-bold">
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
                                    <div class="flex">Vendor :</div>
                                    <div class="flex justify-end text-right">
                                        {{ $inventory->supplier }}
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
                                    <div class="flex">Tahun Perolehan Alat :</div>
                                    <div class="flex justify-end text-right">
                                        {{ $inventory->year_purchased }}
                                    </div>
                                    <div class="flex">Harga :</div>
                                    <div class="flex justify-end text-right">
                                        {{ $inventory->price }}
                                    </div>
                                    <div class="flex">Penyusutan :</div>
                                    <div class="flex justify-end text-right">
                                        {{ $inventory->penyusutan }}
                                    </div>
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
                    <div class="mt-3 w-full h-20 flex justify-center text-sm p-2" id="page">
                        {{ $inventories->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<script>
    $(document).ready(function () {
        tippy(".aspak-verified", {
            content: "Item ini sudah terverifikasi ASPAK"
        })
    })
</script>
@endsection