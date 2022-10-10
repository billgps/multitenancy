@extends('layouts.app')

@section('content')
<style>
    .custom-label input:checked + svg {
        display: block !important;
    }
</style>

<main class="flex sm:container sm:mx-auto sm:mt-10">
    <div class="mx-auto w-4/5 sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="flex flex-col break-words bg-white sm:border-1">

            <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                {{ __('Create New Maintenance') }}
            </header>

            <form class="sm:grid sm:grid-cols-12 sm:p-4 sm:m-2" method="POST"
                action="{{ route('maintenance.store') }}">
                @csrf
                <input required type="hidden" name="inventory_id" value="{{ $inventory->id }}">
                <div class="border border-gray-300 col-span-3 text-lg font-semibold flex items-center justify-center">
                    Pekerjaan
                </div>
                <div class="border border-gray-300 col-span-2 text-xs flex items-center justify-center">
                    Preventive Maintenance
                </div>
                <div class="border border-gray-300 col-span-4 flex text-lg font-semibold items-center justify-center">
                    NAMA ALAT
                </div>
                <div class="border border-gray-300 col-span-3 flex flex-col items-center">
                    <div class="text-xs border-gray-300 border-b w-full flex px-2">Date : <span class="ml-auto">{{ date('d-m-Y', strtotime(now())) }}</span></div>
                    <div class="flex items-center p-2">
                        <div>
                        <img width="100" height="50" src="{{ asset('gps_logo.png') }}">
                        </div>
                        @if (explode('.', $_SERVER['HTTP_HOST'])[0] == 'rsudkoja')  
                        <div style="padding-left: 5px">
                            <img width="140" height="50" src="{{ asset('logo Koja.png') }}">
                        </div>
                        @elseif ((explode('.', $_SERVER['HTTP_HOST'])[0] == 'rsudkramatjati'))
                        <div>
                            <img width="150" height="50" src="{{ asset('logo Kramat Jati.png') }}">
                        </div>
                        @endif
                    </div>
                </div>

                <div class="border border-gray-300 col-span-6 flex flex-col text-xs px-2">
                    <div class="my-1 grid grid-cols-2">
                        <p>Nama Rumah Sakit / Klinik</p>
                        <p>: {{ app('currentTenant')->name }}</p>
                    </div>
                    <div class="my-1 grid grid-cols-2">
                        <p>Lokasi</p>
                        <p>: {{ $inventory->room->room_name }}</p>
                    </div>
                    <div class="my-1 grid grid-cols-2">
                        <p>Merk</p>
                        <p>: {{ $inventory->identity->brand->brand }}</p>
                    </div>
                    <div class="my-1 grid grid-cols-2">
                        <p>Model / Tipe</p>
                        <p>: {{ $inventory->identity->model }}</p>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-6 flex flex-col text-xs px-2">
                    <div class="my-1 grid grid-cols-2">
                        <p>Nomor Inventory</p>
                        <p>: {{ $inventory->barcode }}</p>
                    </div>
                    <div class="my-1 grid grid-cols-2">
                        <p>S / N</p>
                        <p>: {{ $inventory->barcode }}/p>
                    </div>
                    <div class="my-1 grid grid-cols-2">
                        <p>Nomor Kalibrasi</p>
                        <p>: 
                            @if ($inventory->latest_record->label)
                                {{ $inventory->latest_record->label }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div class="my-1 grid grid-cols-2">
                        <p>Tanggal Kalibrasi</p>
                        <p>: 
                            @if ($inventory->latest_record->cal_date)
                                {{ date('d-m-Y', strtotime($inventory->latest_record->cal_date)) }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-6 flex flex-col text-xs">
                    <div class="text-sm border-gray-300 bg-gray-300 font-semibold border-b w-full px-2">Kondisi Lingkungan</div>
                    <div class="my-1 grid grid-cols-2 px-2 py-1">
                        <p class="flex items-center">Suhu Ruangan</p>
                        <p>:
                            <input required type="number" name="temperature" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600"> 
                            &#8451; <span class="ml-auto">( 21 - 25 )</span></p>
                    </div>
                    <div class="my-1 grid grid-cols-2 px-2 py-1">
                        <p class="flex items-center">Kelembaban</p>
                        <p>:
                            <input required type="number" name="humidity" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600"> 
                            % <span>( 50 - 60 )</span></p>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-6 flex flex-col text-xs">
                    <div class="text-sm border-gray-300 bg-gray-300 font-semibold border-b w-full px-2">Kondisi Kelistrikan</div>
                    <div class="my-1 grid grid-cols-2 px-2 py-1">
                        <p class="flex items-center">Tegangan Jala - Jala :
                            <input required type="number" name="voltage" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600"> 
                            V
                        </p>
                        <span class="flex items-center form-check">
                            <input onclick="toggleInput(this)" id="ups" name="is_ups" class="form-check-input appearance-none h-5 w-5 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label inline-block text-gray-800" for="flexCheckDefault">
                                UPS &nbsp;
                            </label>
                            <p id="upsNode" class="hidden items-center ml-auto"> : 
                                <input required type="number" name="ups" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600"> 
                                V
                            </p>
                        </span>
                    </div>
                    <div class="my-1 grid grid-cols-2 px-2 py-1">
                        <span class="flex form-check items-center col-start-2">
                            <input onclick="toggleInput(this)" id="stabilizer" name="is_stabilizer" class="form-check-input appearance-none h-5 w-5 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label inline-block text-gray-800" for="flexCheckDefault">
                                Stabilizer &nbsp;
                            </label>
                            <p id="stabilizerNode" class="hidden items-center ml-auto"> : 
                                <input required type="number" name="stabilizer" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600"> 
                                V
                            </p>
                        </span>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-6 row-span-2 flex flex-col text-xs">
                    <div class="text-sm border-gray-300 bg-gray-300 font-semibold border-b w-full px-2">Alat Kerja yang Digunakan</div>
                    <div class="w-full justify-evenly flex items-center py-1">
                        <table class="align-middle">
                            <tbody>
                                <tr>
                                    <td class="w-4">1. </td>
                                    <td class="w-32">ESA</td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input required type="checkbox" name="is_tools[]" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td class="w-4">6.<td>
                                    <td class="w-32">
                                        <input type="text" name="tools[]" class="w-full text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600"> 
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="checkbox" name="is_tools[]" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-4">2. </td>
                                    <td class="w-32">Thermohygrometer</td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input required type="checkbox" name="is_tools[]" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td class="w-4">7.<td>
                                    <td class="w-32">
                                        <input type="text" name="tools[]" class="w-full text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600"> 
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="checkbox" name="is_tools[]" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-4">3. </td>
                                    <td class="w-32">Toolset</td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input required type="checkbox" name="is_tools[]" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td class="w-4">8.<td>
                                    <td class="w-32">
                                        <input type="text" name="tools[]" class="w-full text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600"> 
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="checkbox" name="is_tools[]" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-4">4. </td>
                                    <td class="w-32">Cleaning Kit</td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input required type="checkbox" name="is_tools[]" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td class="w-4">9.<td>
                                    <td class="w-32">
                                        <input type="text" name="tools[]" class="w-full text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600"> 
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="checkbox" name="is_tools[]" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-4">5. </td>
                                    <td class="w-32">Multitester</td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input required type="checkbox" name="is_tools[]" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td class="w-4">10.<td>
                                    <td class="w-32">
                                        <input type="text" name="tools[]" class="w-full text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600"> 
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="checkbox" name="is_tools[]" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-6 flex flex-col text-xs">
                    <div class="text-sm border-gray-300 bg-gray-300 font-semibold border-b w-full px-2">Pemeriksaan Keamanan Lain</div>
                    <div class="my-1 grid grid-cols-5 px-2 py-1">
                        <p class="flex items-center col-span-2">Penempatan Alat : </p>
                        <label class="custom-label flex ml-3">
                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                <input type="radio" name="placement" value="good" class="hidden">
                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                            </div>
                            <span class="select-none">Baik</span>
                        </label>
                        <label class="custom-label flex ml-3">
                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                <input type="radio" name="placement" value="bad" class="hidden">
                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                            </div>
                            <span class="select-none">Tidak</span>
                        </label>
                        <label class="custom-label flex ml-3">
                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                <input type="radio" name="placement" value="none" class="hidden">
                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                            </div>
                            <span class="select-none">N / A</span>
                        </label>
                    </div>
                    <div class="my-1 grid grid-cols-5 px-2 py-1">
                        <p class="flex items-center col-span-2">Roda / Troli / Bracket : </p>
                        <label class="custom-label flex ml-3">
                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                <input type="radio" name="extra" value="good" class="hidden">
                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                            </div>
                            <span class="select-none">Baik</span>
                        </label>
                        <label class="custom-label flex ml-3">
                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                <input type="radio" name="extra" value="bad" class="hidden">
                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                            </div>
                            <span class="select-none">Tidak</span>
                        </label>
                        <label class="custom-label flex ml-3">
                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                <input type="radio" name="extra" value="none" class="hidden">
                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                            </div>
                            <span class="select-none">N / A</span>
                        </label>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-6 flex flex-col text-xs pb-2">
                    <div class="grid grid-cols-3 gap-y-2 w-full">
                        <div class="text-sm border-gray-300 bg-gray-300 font-semibold border-b border-x w-full px-2">Pemeriksaan Fisik</div>
                        <div class="flex text-sm border-gray-300 bg-gray-300 font-semibold border-b border-x w-full px-2">
                            <span class="ml-4">B</span>
                            <span class="ml-6">C/RR</span>
                            <span class="ml-6">RB</span>
                        </div>
                        <div class="flex justify-evenly text-sm border-gray-300 bg-gray-300 font-semibold border-b border-x w-full px-2">
                            <span>Bersih</span>
                            <span>Kotor</span>
                        </div>

                        <p class="flex items-center px-4">Main Unit </p>
                        <div class="flex justify-evenly">
                            <label class="custom-label flex ml-3">
                                <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                    <input type="radio" name="physic_main" value="0" class="hidden">
                                    <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                </div>
                            </label>
                            <label class="custom-label flex ml-3">
                                <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                    <input type="radio" name="physic_main" value="1" class="hidden">
                                    <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                </div>
                            </label>
                            <label class="custom-label flex ml-3">
                                <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                    <input type="radio" name="physic_main" value="2" class="hidden">
                                    <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                </div>
                            </label>
                        </div>
                        <div class="flex justify-evenly">
                            <label class="custom-label flex ml-3">
                                <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                    <input type="radio" name="condition_main" value="clean" class="hidden">
                                    <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                </div>
                            </label>
                            <label class="custom-label flex ml-3">
                                <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                    <input type="radio" name="condition_main" value="dirty" class="hidden">
                                    <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                </div>
                            </label>
                        </div>

                        <p class="flex items-center px-4">Roda / Troli / Bracket </p>
                        <div class="flex justify-evenly">
                            <label class="custom-label flex ml-3">
                                <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                    <input type="radio" name="physic_extra" value="0" class="hidden">
                                    <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                </div>
                            </label>
                            <label class="custom-label flex ml-3">
                                <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                    <input type="radio" name="physic_extra" value="1" class="hidden">
                                    <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                </div>
                            </label>
                            <label class="custom-label flex ml-3">
                                <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                    <input type="radio" name="physic_extra" value="2" class="hidden">
                                    <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                </div>
                            </label>
                        </div>
                        <div class="flex justify-evenly">
                            <label class="custom-label flex ml-3">
                                <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                    <input type="radio" name="condition_extra" value="clean" class="hidden">
                                    <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                </div>
                            </label>
                            <label class="custom-label flex ml-3">
                                <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                    <input type="radio" name="condition_extra" value="dirty" class="hidden">
                                    <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-6 flex flex-col text-xs">
                    <div class="text-sm border-gray-300 bg-gray-300 font-semibold border-b w-full px-2 flex">
                        Pemeriksaan Keamanan Listrik
                        <a onclick="addRow('electricity')" class="ml-auto text-green-500 hover:text-gray-500 cursor-pointer">
                            <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
                    <table class="align-middle my-3 mr-1">
                        <tbody id="elBody">
                            <tr>
                                <td class="w-64">
                                    <span class="ml-2 text-xs flex items-center">Tahanan hubungan pertanahan</span>
                                </td>
                                <td class="form-check">
                                    <input onclick="toggleInput(this)" id="el1" name="is_el[]" value="el1" class="form-check-input appearance-none h-5 w-5 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" id="flexCheckDefault">
                                </td>
                                <td class="flex justify-start pl-2">
                                    <p id="el1Node" class="hidden items-center col-span-2">
                                        <input type="number" name="el[]" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto"> 
                                        &nbsp;&#8804;0,2&#8486;&nbsp;&nbsp;&nbsp;
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-64">
                                    <span class="ml-2 pr-1 text-xs flex items-center break-normal">Arus bocor Casis dengan Pembumian</span>
                                </td>
                                <td>
                                    <input onclick="toggleInput(this)" id="el2" name="is_el[]" value="el2" class="form-check-input appearance-none h-5 w-5 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" id="flexCheckDefault">
                                </td>
                                <td class="flex justify-start pl-2">
                                    <p id="el2Node" class="hidden items-center col-span-2">
                                        <input required type="number" name="el[]" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto"> 
                                        &nbsp;&#8804;100&#xb5;A
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-64">
                                    <span class="ml-2 pr-1 text-xs col-span-3 flex items-center break-normal">Arus bocor Casis tanpa Pembumian</span>
                                </td>
                                <td>
                                    <input onclick="toggleInput(this)" id="el3" name="is_el[]" value="el3" class="form-check-input appearance-none h-5 w-5 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" id="flexCheckDefault">
                                </td>
                                <td class="flex justify-start pl-2">
                                    <p id="el3Node" class="hidden items-center col-span-2">
                                        <input required type="number" name="el[]" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto"> 
                                        &nbsp;&#8804;500&#xb5;A
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-64">
                                    <span class="ml-2 pr-1 text-xs col-span-3 flex items-center break-normal">Arus bocor Casis Polaritas terbalik dengan Pembumian</span>
                                </td>
                                <td>
                                    <input onclick="toggleInput(this)" id="el4" name="is_el[]" value="el4" class="form-check-input appearance-none h-5 w-5 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" id="flexCheckDefault">
                                </td>
                                <td class="flex justify-start pl-2">
                                    <p id="el4Node" class="hidden items-center col-span-2">
                                        <input required type="number" name="el[]" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto"> 
                                        &nbsp;&#8804;100&#xb5;A
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-64">
                                    <span class="ml-2 pr-1 text-xs col-span-3 flex items-center break-normal">Arus bocor Casis Polaritas terbalik tanpa Pembumian</span>
                                </td>
                                <td>
                                    <input onclick="toggleInput(this)" id="el5" name="is_el[]" value="el5" class="form-check-input appearance-none h-5 w-5 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="checkbox" id="flexCheckDefault">
                                </td>
                                <td class="flex justify-start pl-2">
                                    <p id="el5Node" class="hidden items-center col-span-2">
                                        <input required type="number" name="el[]" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto"> 
                                        &nbsp;&#8804;500&#xb5;A
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="border border-gray-300 col-span-6 row-span-2 flex flex-col text-xs">
                    <table class="text-sm border-gray-300 bg-gray-300 font-semibold border-b w-full px-2">
                        <tr>
                            <td class="w-48 pl-2">
                                Pemeriksaan Fungsi Alat
                            </td>
                            <td class="pl-4">
                                N / A
                            </td>
                            <td class="pl-7">
                                Baik
                            </td>
                            <td class="pl-6">
                                Tidak
                            </td>
                            <td>
                                <a onclick="addRow('function')" class="ml-auto text-green-500 hover:text-gray-500 cursor-pointer">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </td>
                        </tr>
                    </table>
                    <div class="px-2 py-1 my-1">
                        <table class="align-middle w-full">
                            <tbody id="funcBody">
                                <tr>
                                    <td class="w-48">
                                        <p class="flex items-center col-span-2">Display / Monitor</p>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="func[0]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="func[0]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="func[0]" value="2" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-48">
                                        <p class="flex items-center col-span-2">Switch On / Off</p>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="func[1]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="func[1]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="func[1]" value="2" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-48">
                                        <p class="flex items-center col-span-2">Control / Setting</p>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="func[2]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="func[2]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="func[2]" value="2" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-48">
                                        <p class="flex items-center col-span-2">Keypad</p>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="func[3]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="func[3]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="func[3]" value="2" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-48">
                                        <p class="flex items-center col-span-2">Timer</p>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="func[4]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="func[4]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="func[4]" value="2" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-6 flex flex-col text-xs">
                    <table class="text-sm border-gray-300 bg-gray-300 font-semibold border-b w-full px-2">
                        <tr>
                            <td class="w-48 pl-2">
                                Kelengkapan Alat
                            </td>
                            <td class="pl-4">
                                N / A
                            </td>
                            <td class="pl-7">
                                Baik
                            </td>
                            <td class="pl-6">
                                Tidak
                            </td>
                            <td>
                                <a onclick="addRow('complete')" class="ml-auto text-green-500 hover:text-gray-500 cursor-pointer">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </td>
                        </tr>
                    </table>
                    <div class="px-2 py-1 my-1">
                        <table class="align-middle w-full">
                            <tbody id="completeBody">
                                <tr>
                                    <td class="w-48">
                                        <p class="flex items-center col-span-2">Power Cord / Adaptor</p>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="complete[0]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="complete[0]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="complete[0]" value="2" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-12 flex flex-col text-xs">
                    <div class="text-sm border-gray-300 bg-gray-300 font-semibold border w-full px-2 flex items-center">
                        <span class="w-64">
                            Pemeriksaan Kinerja Alat
                        </span>
                        <span class="w-16 ml-4 text-center">
                            Setting
                        </span>
                        <span class="w-14 ml-10 text-center">
                            Terukur I
                        </span>
                        <span class="w-16 ml-10 text-center">
                            Terukur II
                        </span>
                        <span class="w-20 ml-9 text-center">
                            Nilai Acuan
                        </span>
                        <span class="w-16 ml-5 text-center">
                            Baik
                        </span>
                        <span class="w-16 ml-1 text-center">
                            Tidak
                        </span>
                        <span>
                            <a onclick="addRow('performance')" class="ml-auto text-green-500 cursor-pointer">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </span>
                    </div>
                    <div class="px-2 py-1 my-1">
                        <table class="align-middle w-full">
                            <tbody id="performBody">
                                <tr>
                                    <td class="w-64 border-gray-300 border-r">
                                        <span class="flex items-center col-span-2">
                                            <input required type="text" name="performanceParam[]" class="w-full text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                        </span>
                                    </td>
                                    <td class="border-gray-300 text-center border-r">
                                        <input required type="text" name="setting[]" class="w-16 text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                    </td>
                                    <td class="border-gray-300 text-center border-r">
                                        <input required type="number" name="value[0][]" class="w-16 text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                    </td>
                                    <td class="border-gray-300 text-center border-r">
                                        <input required type="number" name="value[1][]" class="w-16 text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                    </td>
                                    <td class="border-gray-300 text-center border-r">
                                        <input required type="text" name="reference[]" class="w-20 text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="performanceCondition[0]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="performanceCondition[0]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td class="">
                                        <a onclick="deleteRow(this)" class="text-red-500 hover:text-gray-500 cursor-pointer mx-1">
                                            <i class="fas fa-minus-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-sm border-gray-300 bg-gray-300 font-semibold border w-full px-2 flex items-center">
                        <span class="w-64">
                        </span>
                        <span class="w-20 ml-7 text-center">
                            Spesifikasi
                        </span>
                        <span class="w-14 ml-9 text-center">
                            Terukur I
                        </span>
                        <span class="w-16 ml-10 text-center">
                            Terukur II
                        </span>
                        <span class="w-20 ml-9 text-center">
                            Nilai Acuan
                        </span>
                        <span class="w-16 ml-1 text-center">
                            Baik
                        </span>
                        <span class="w-16 ml-1 text-center">
                            Tidak
                        </span>
                        <span>
                        </span>
                    </div>
                    <div class="px-2 py-1 my-1">
                        <table class="align-middle w-full">
                            <tbody id="performBody">
                                <tr>
                                    <td class="w-64 border-gray-300 border-r">
                                        <span class="flex items-center col-span-2">
                                            Battery
                                        </span>
                                    </td>
                                    <td class="border-gray-300 text-center border-r">
                                        <input required type="text" name="batterySetting[]" class="w-16 text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                        VDC
                                    </td>
                                    <td class="border-gray-300 text-center border-r">
                                        <input required type="number" name="battery[0][]" class="w-16 text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                    </td>
                                    <td class="border-gray-300 text-center border-r">
                                        <input required type="number" name="battery[1][]" class="w-16 text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                    </td>
                                    <td class="border-gray-300 text-center border-r">
                                        <div class="text-center w-20">
                                            &#8804;10%
                                        </div>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="batteryCondition[0]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="batteryCondition[0]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td class="w-7">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-12 flex flex-col text-xs">
                    <div class="text-sm border-gray-300 border w-full pr-2 flex items-center">
                        <span class="w-64 bg-gray-300 pl-2 font-semibold">
                            Hasil Pemeriksaan
                        </span>
                        <span class="flex items-center text-center mx-4">
                            <label class="custom-label flex ml-3">
                                <div class="bg-white shadow w-4 h-4 p-1 flex justify-center items-center mr-2">
                                    <input type="radio" name="inspectionResult" value="1" class="hidden">
                                    <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                </div>
                            </label>
                            <span class="select-none text-xs">Alat Bekerja dengan Baik</span>
                        </span>
                        <span class="flex items-center text-center ml-8">
                            <label class="custom-label flex ml-3">
                                <div class="bg-white shadow w-4 h-4 p-1 flex justify-center items-center mr-2">
                                    <input type="radio" name="inspectionResult" value="0" class="hidden">
                                    <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                </div>
                            </label>
                            <span class="select-none text-xs">Alat Tidak Bekerja dengan Baik</span>
                        </span>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-6 flex flex-col text-xs">
                    <table class="text-sm border-gray-300 bg-gray-300 font-semibold border-b w-full px-2">
                        <tr>
                            <td class="w-64 pl-2">
                                Pemeliharaan Alat
                            </td>
                            <td class="pl-2">
                                Dilakukan
                            </td>
                            <td class="pr-6">
                                Tidak
                            </td>
                        </tr>
                    </table>
                    <div class="px-2 py-6 my-1">
                        <table class="align-middle w-full">
                            <tbody>
                                <tr>
                                    <td class="w-64">
                                        <p class="flex items-center col-span-2">Pembersihan Main Unit</p>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="maintenance[0]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="maintenance[0]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-64">
                                        <p class="flex items-center col-span-2">Pembersihan Aksesoris / Kelengkapan alat</p>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="maintenance[1]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="maintenance[1]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-64">
                                        <p class="flex items-center col-span-2">Pemantauan fungsi alat</p>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="maintenance[2]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="maintenance[2]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-64">
                                        <p class="flex items-center col-span-2">Pemantauan kinerja alat</p>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="maintenance[3]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="maintenance[3]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="flex w-64">
                                        <p class="flex items-center col-span-2">Penggantian Consumable</p>
                                        <input required type="text" name="cons" class="text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="maintenance[4]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="maintenance[4]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-64">
                                        <p class="flex items-center col-span-2">Lubricating &/ Tighting</p>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="maintenance[5]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="maintenance[5]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-6 flex flex-col text-xs">
                    <table class="text-sm border-gray-300 bg-gray-300 font-semibold border-b w-full px-2">
                        <tr>
                            <td class="w-14 text-center pl-5">
                                Stok
                            </td>
                            <td class="w-56 text-center pl-6">
                                Konsumabel
                            </td>
                            <td class="pl-3">
                                Ada
                            </td>
                            <td class="pl-1">
                                Tidak
                            </td>
                            <td class="pl-1">
                                Habis
                            </td>
                        </tr>
                    </table>
                    <div class="px-2 py-1 my-1">
                        <table class="align-middle w-full">
                            <tbody id="consBody">
                                <tr>
                                    <td>
                                        <input required type="text" name="stock[]" class="w-14 text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                    </td>
                                    <td class="w-56">
                                        <span class="flex items-center col-span-2">
                                            <input required type="text" name="consumables[]" class="w-full text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                        </span>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[0]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[0]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[0]" value="2" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input required type="text" name="stock[]" class="w-14 text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                    </td>
                                    <td class="w-56">
                                        <span class="flex items-center col-span-2">
                                            <input required type="text" name="consumables[]" class="w-full text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                        </span>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[1]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[1]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[1]" value="2" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input required type="text" name="stock[]" class="w-14 text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                    </td>
                                    <td class="w-56">
                                        <span class="flex items-center col-span-2">
                                            <input required type="text" name="consumables[]" class="w-full text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                        </span>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[2]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[2]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[2]" value="2" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input required type="text" name="stock[]" class="w-14 text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                    </td>
                                    <td class="w-56">
                                        <span class="flex items-center col-span-2">
                                            <input required type="text" name="consumables[]" class="w-full text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                        </span>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[3]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[3]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[3]" value="2" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input required type="text" name="stock[]" class="w-14 text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                    </td>
                                    <td class="w-56">
                                        <span class="flex items-center col-span-2">
                                            <input required type="text" name="consumables[]" class="w-full text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                        </span>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[4]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[4]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[4]" value="2" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input required type="text" name="stock[]" class="w-14 text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                    </td>
                                    <td class="w-56">
                                        <span class="flex items-center col-span-2">
                                            <input required type="text" name="consumables[]" class="w-full text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                        </span>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[5]" value="0" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[5]" value="1" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="custom-label flex ml-3">
                                            <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                                                <input type="radio" name="consCondition[5]" value="2" class="hidden">
                                                <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-12 flex flex-col text-xs">
                    <div class="text-sm border-gray-300 border w-full pr-2 flex items-center">
                        <span class="w-64 bg-gray-300 pl-2 font-semibold">
                            Hasil Maintenance
                        </span>
                        <span class="flex items-center text-center mx-4">
                            <label class="custom-label flex ml-3">
                                <div class="bg-white shadow w-4 h-4 p-1 flex justify-center items-center mr-2">
                                    <input type="radio" name="maintenanceResult" value="1" class="hidden">
                                    <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                </div>
                            </label>
                            <span class="select-none text-xs">Alat Berfungsi dengan Baik</span>
                        </span>
                        <span class="flex items-center text-center ml-8">
                            <label class="custom-label flex ml-3">
                                <div class="bg-white shadow w-4 h-4 p-1 flex justify-center items-center mr-2">
                                    <input type="radio" name="maintenanceResult" value="0" class="hidden">
                                    <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                </div>
                            </label>
                            <span class="select-none text-xs">Alat Tidak Dapat Berfungsi dengan Baik</span>
                        </span>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-12 flex flex-col text-xs">
                    <div class="text-sm border-gray-300 border w-full pr-2 flex items-center">
                        <span class="w-64 h-full flex items-center bg-gray-300 pl-2 font-semibold">
                            Rekomendasi Hasil Maintenance
                        </span>
                        <div class="flex flex-col mx-4">
                            <span class="flex items-center text-center my-1">
                                <label class="custom-label flex ml-3">
                                    <div class="bg-white shadow w-4 h-4 p-1 flex justify-center items-center mr-2">
                                        <input type="radio" name="recommendation" value="0" class="hidden">
                                        <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                    </div>
                                </label>
                                <span class="select-none text-xs">Alat Dapat Digunakan</span>
                            </span>
                            <span class="flex items-center text-center my-1">
                                <label class="custom-label flex ml-3">
                                    <div class="bg-white shadow w-4 h-4 p-1 flex justify-center items-center mr-2">
                                        <input type="radio" name="recommendation" value="1" class="hidden">
                                        <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                    </div>
                                </label>
                                <span class="select-none text-xs">Alat Perlu Dikalibrasi</span>
                            </span>
                        </div>
                        <div class="flex flex-col ml-14">
                            <span class="flex items-center text-center my-1">
                                <label class="custom-label flex ml-3">
                                    <div class="bg-white shadow w-4 h-4 p-1 flex justify-center items-center mr-2">
                                        <input type="radio" name="recommendation" value="2" class="hidden">
                                        <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                    </div>
                                </label>
                                <span class="select-none text-xs">Alat Tidak Dapat Digunakan</span>
                            </span>
                            <span class="flex items-center text-center my-1">
                                <label class="custom-label flex ml-3">
                                    <div class="bg-white shadow w-4 h-4 p-1 flex justify-center items-center mr-2">
                                        <input type="radio" name="recommendation" value="3" class="hidden">
                                        <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                                    </div>
                                </label>
                                <span class="select-none text-xs">Alat Harus Dikalibrasi</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-12 flex flex-col text-xs">
                    <div class="text-sm border-gray-300 border bg-gray-300 w-full pr-2 flex items-center">
                        <span class="w-full flex items-center pl-2 font-semibold">
                            Catatan
                        </span>
                    </div>
                    <div class="w-full flex justify-center">
                        <textarea rows="15" name="notes" class="w-full my-1 text-xs shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600"></textarea>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-12 flex flex-col text-xs">
                    <div class="text-sm border-gray-300 border bg-gray-300 w-full pr-2 flex justify-evenly items-center">
                        <span class="w-full text-center justify-center flex items-center font-semibold">
                            Teknisi Pelaksana
                        </span>
                        <span class="w-full text-center justify-center flex items-center font-semibold">
                            Penanggung Jawab Alat / Ruangan
                        </span>
                        <span class="w-full text-center justify-center flex items-center font-semibold">
                            IPSRS
                        </span>
                    </div>
                    <div class="w-full flex">
                        <div class="h-36 w-72 border border-gray-300 flex flex-col items-center text-center text-sm">
                            {{-- <img src="{{ asset('stamp_submitted.png') }}" alt=""> --}}
                            <p class="self-end w-full text-center mb-1 mt-auto font-semibold">
                                {{ Auth::user()->name }}
                            </p>
                        </div>
                        <div class="h-36 w-72 border border-gray-300 flex flex-col items-center text-center text-sm">
                            {{-- <img src="{{ asset('stamp_approved.png') }}" alt="">
                            <p class="self-end w-full text-center mb-1 mt-auto font-semibold">User name</p> --}}
                        </div>
                        <div class="h-36 w-72 border border-gray-300 flex flex-col items-center text-center text-sm">
                            {{-- <img src="{{ asset('stamp_rejected.png') }}" alt="">
                            <p class="self-end w-full text-center mb-1 mt-auto font-semibold">User name</p> --}}
                        </div>
                    </div>
                </div>

                <div class="col-span-12 flex flex-wrap justify-end my-2">
                    <input role="submit" type="submit" value="{{ __('Submit') }}" class="block text-center cursor-pointer text-white bg-green-600 p-3 duration-300 rounded-sm hover:bg-green-800 w-full sm:w-32">
                </div>        
            </form>
        </section>
    </div>
</main>

<script>
    function toggleInput(el) {
        let key = null

        switch (el.id) {
            case 'ups':
                key = 'upsNode'
                break;

            case 'stabilizer':
                key = 'stabilizerNode'
                break;

            case 'el1':
                key = 'el1Node'
                break;

            case 'el2':
                key = 'el2Node'
                break;

            case 'el3':
                key = 'el3Node'
                break;

            case 'el4':
                key = 'el4Node'
                break;

            case 'el5':
                key = 'el5Node'
                break;
        
            default:
                console.log('key undefined');
                break;
        }

        if (el.parentNode.classList.contains('active')) {
            el.parentNode.classList.remove('active')

            showNode(key, false)
        } else {
            el.parentNode.classList.add('active')

            showNode(key, true)
        }
    }

    function showNode(key, value) {
        let node = document.getElementById(key)

        if (value) {
            node.classList.remove('hidden')
            node.querySelector('input').required = true
            node.classList.add('flex')
        } else {
            node.classList.remove('flex')
            node.querySelector('input').required = false
            node.classList.add('hidden')
        }
    }

    function addRow(type) {
        let table = null
        let row = null

        switch (type) {
            case 'electricity':
                table = document.getElementById('elBody')
                row = table.insertRow()
                row.innerHTML = '<td class="w-64 py-1">'+
                                    '<span class="ml-2 pr-1 text-xs col-span-3 flex items-center break-normal">'+
                                        '<a onclick="deleteRow(this)" class="text-red-500 hover:text-gray-500 cursor-pointer mx-1">'+
                                            '<i class="fas fa-minus-circle"></i>'+
                                        '</a>'+
                                        '<input required type="text" name="elParam[]" class="w-full text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">'+
                                    '</span>'+
                                '</td>'+
                                '<td>'+
                                '</td>'+
                                '<td colspan="2" class="flex justify-start pl-2 py-1">'+
                                    '<p id="el5Node" class="flex items-center col-span-2">'+
                                        '<input required type="number" name="el[]" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">'+ 
                                        '<input required type="text" name="elThreshold[]" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">'+
                                    '</p>'+
                                '</td>'
                break;
            case 'function':
                table = document.getElementById('funcBody')
                row = table.insertRow()
                row.innerHTML = '<td class="w-48">'+
                                    '<span class="flex items-center col-span-2">'+
                                        '<a onclick="deleteRow(this)" class="text-red-500 hover:text-gray-500 cursor-pointer mx-1">'+
                                            '<i class="fas fa-minus-circle"></i>'+
                                        '</a>'+
                                        '<input required type="text" name="funcParam[]" class="w-full text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">'+ 
                                    '</span>'+
                                '</td>'+
                                '<td>'+
                                    '<label class="custom-label flex ml-3">'+
                                        '<div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">'+
                                            '<input type="radio" name="func['+row.rowIndex+']" value="0" class="hidden">'+
                                            '<svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>'+
                                        '</div>'+
                                    '</label>'+
                                '</td>'+
                                '<td>'+
                                    '<label class="custom-label flex ml-3">'+
                                        '<div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">'+
                                            '<input type="radio" name="func['+row.rowIndex+']" value="1" class="hidden">'+
                                            '<svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>'+
                                        '</div>'+
                                    '</label>'+
                                '</td>'+
                                '<td>'+
                                    '<label class="custom-label flex ml-3">'+
                                        '<div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">'+
                                            '<input type="radio" name="func['+row.rowIndex+']" value="2" class="hidden">'+
                                            '<svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>'+
                                        '</div>'+
                                    '</label>'+
                                '</td>'
                break;
            case 'complete':
                table = document.getElementById('completeBody')
                row = table.insertRow()
                row.innerHTML = '<td class="w-48">'+
                                    '<span class="flex items-center col-span-2">'+
                                        '<a onclick="deleteRow(this)" class="text-red-500 hover:text-gray-500 cursor-pointer mx-1">'+
                                            '<i class="fas fa-minus-circle"></i>'+
                                        '</a>'+
                                        '<input required type="text" name="compParam[]" class="w-full text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">'+ 
                                    '</span>'+
                                '</td>'+
                                '<td>'+
                                    '<label class="custom-label flex ml-3">'+
                                        '<div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">'+
                                            '<input type="radio" name="complete['+row.rowIndex+']" value="0" class="hidden">'+
                                            '<svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>'+
                                        '</div>'+
                                    '</label>'+
                                '</td>'+
                                '<td>'+
                                    '<label class="custom-label flex ml-3">'+
                                        '<div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">'+
                                            '<input type="radio" name="complete['+row.rowIndex+']" value="1" class="hidden">'+
                                            '<svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>'+
                                        '</div>'+
                                    '</label>'+
                                '</td>'+
                                '<td>'+
                                    '<label class="custom-label flex ml-3">'+
                                        '<div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">'+
                                            '<input type="radio" name="complete['+row.rowIndex+']" value="2" class="hidden">'+
                                            '<svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>'+
                                        '</div>'+
                                    '</label>'+
                                '</td>'
                break;
            case 'performance':
                table = document.getElementById('performBody')
                row = table.insertRow()
                row.innerHTML = '<td class="w-64 border-gray-300 border-r">'+
                                    '<span class="flex items-center col-span-2">'+
                                        '<input required type="text" name="performanceParam[]" class="w-full text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">'+
                                    '</span>'+
                                '</td>'+
                                '<td class="border-gray-300 text-center border-r">'+
                                    '<input required type="text" name="setting[]" class="w-16 text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">'+
                                '</td>'+
                                '<td class="border-gray-300 text-center border-r">'+
                                    '<input required type="number" name="value[0][]" class="w-16 text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">'+
                                '</td>'+
                                '<td class="border-gray-300 text-center border-r">'+
                                    '<input required type="number" name="value[1][]" class="w-16 text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">'+
                                '</td>'+
                                '<td class="border-gray-300 text-center border-r">'+
                                    '<input required type="text" name="reference[]" class="w-20 text-xs rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">'+
                                '</td>'+
                                '<td>'+
                                    '<label class="custom-label flex ml-3">'+
                                        '<div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">'+
                                            '<input type="radio" name="performanceCondition['+row.rowIndex+']" value="1" class="hidden">'+
                                            '<svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>'+
                                        '</div>'+
                                    '</label>'+
                                '</td>'+
                                '<td>'+
                                    '<label class="custom-label flex ml-3">'+
                                        '<div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">'+
                                            '<input type="radio" name="performanceCondition['+row.rowIndex+']" value="2" class="hidden">'+
                                            '<svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>'+
                                        '</div>'+
                                    '</label>'+
                                '</td>'+
                                '<td class="">'+
                                    '<a onclick="deleteRow(this)" class="text-red-500 hover:text-gray-500 cursor-pointer mx-1">'+
                                        '<i class="fas fa-minus-circle"></i>'+
                                    '</a>'+
                                '</td>'
                break;
            default:
                console.log("table not found");
                break;
        }
    }

    function deleteRow(r) {
        let parent = r.parentNode.parentNode.parentNode.parentNode
        parent.removeChild(r.parentNode.parentNode.parentNode)
    }
</script>
@endsection