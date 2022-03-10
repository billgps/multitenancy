@extends('layouts.app')

@section('content')
<style>
    .select2-results__option, .select2-search__field, .select2-selection__rendered {
        color: black;
        font-size: 0.875rem;
        line-height: 1.25rem;
    }

    .select2-selection__rendered {
        text-align: left !important;
    }

    .select2-selection, .select2-selection--single {
        height: 32px !important;
    }

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
                <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">
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
                    <div class="text-xs border-gray-300 border-b w-full px-2">Date : </div>
                    <div class="flex items-center p-2">
                        <img width="100" height="50" src="{{ asset('gps_logo.png') }}">
                    </div>
                </div>

                <div class="border border-gray-300 col-span-6 flex flex-col text-xs px-2">
                    <div class="my-1 grid grid-cols-2">
                        <p>Nama Rumah Sakit / Klinik</p>
                        <p>: RSUD Matraman</p>
                    </div>
                    <div class="my-1 grid grid-cols-2">
                        <p>Lokasi</p>
                        <p>: Parkiran</p>
                    </div>
                    <div class="my-1 grid grid-cols-2">
                        <p>Merk</p>
                        <p>: Samsung</p>
                    </div>
                    <div class="my-1 grid grid-cols-2">
                        <p>Model / Tipe</p>
                        <p>: Vios Limo</p>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-6 flex flex-col text-xs px-2">
                    <div class="my-1 grid grid-cols-2">
                        <p>Nomor Inventory</p>
                        <p>: 6724938273492</p>
                    </div>
                    <div class="my-1 grid grid-cols-2">
                        <p>S / N</p>
                        <p>: B 24551 KL</p>
                    </div>
                    <div class="my-1 grid grid-cols-2">
                        <p>Nomor Kalibrasi</p>
                        <p>: 899234</p>
                    </div>
                    <div class="my-1 grid grid-cols-2">
                        <p>Tanggal Kalibrasi</p>
                        <p>: 12 Maret 2019</p>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-6 flex flex-col text-xs">
                    <div class="text-sm border-gray-300 bg-gray-300 font-semibold border-b w-full px-2">Kondisi Lingkungan</div>
                    <div class="my-1 grid grid-cols-2 px-2 py-1">
                        <p class="flex items-center">Suhu Ruangan</p>
                        <p>:
                            <input type="number" name="temperature" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600"> 
                            &#8451; <span class="ml-auto">( 21 - 25 )</span></p>
                    </div>
                    <div class="my-1 grid grid-cols-2 px-2 py-1">
                        <p class="flex items-center">Kelembaban</p>
                        <p>:
                            <input type="number" name="humidity" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600"> 
                            % <span>( 50 - 60 )</span></p>
                    </div>
                </div>

                <div class="border border-gray-300 col-span-6 flex flex-col text-xs">
                    <div class="text-sm border-gray-300 bg-gray-300 font-semibold border-b w-full px-2">Kondisi Kelistrikan</div>
                    <div class="my-1 grid grid-cols-2 px-2 py-1">
                        <p class="flex items-center">Tegangan Jala - Jala :
                            <input type="number" name="voltage" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600"> 
                            V
                        </p>
                        <span class="flex">
                            <label for="ups" class="flex items-center cursor-pointer">
                                <span class="relative">
                                    <span class="block w-10 h-6 bg-gray-400 rounded-full shadow-inner"></span>
                                    <span class="absolute block w-4 h-4 mt-1 ml-1 bg-white rounded-full shadow inset-y-0 left-0 focus-within:shadow-outline transition-transform duration-300 ease-in-out">
                                        <input onclick="toggleInput(this)" id="ups" name="is_ups" type="checkbox" class="absolute opacity-0 w-0 h-0" />
                                    </span>
                                </span>
                                <span class="ml-2 text-xs">UPS &nbsp;</span>
                            </label>
                            <p id="upsNode" class="hidden items-center ml-auto"> : 
                                <input type="number" name="ups" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600"> 
                                V
                            </p>
                        </span>
                    </div>
                    <div class="my-1 grid grid-cols-2 px-2 py-1">
                        <span class="flex col-start-2">
                            <label for="stabilizer" class="flex items-center cursor-pointer">
                                <span class="relative">
                                    <span class="block w-10 h-6 bg-gray-400 rounded-full shadow-inner"></span>
                                    <span class="absolute block w-4 h-4 mt-1 ml-1 bg-white rounded-full shadow inset-y-0 left-0 focus-within:shadow-outline transition-transform duration-300 ease-in-out">
                                        <input onclick="toggleInput(this)" id="stabilizer" name="is_stabilizer" type="checkbox" class="absolute opacity-0 w-0 h-0" />
                                    </span>
                                </span>
                                <span class="ml-2 text-xs">Stabilizer &nbsp;</span>
                            </label>
                            <p id="stabilizerNode" class="hidden items-center ml-auto"> : 
                                <input type="number" name="stabilizer" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600"> 
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
                                                <input type="checkbox" name="is_tools[]" class="hidden">
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
                                                <input type="checkbox" name="is_tools[]" class="hidden">
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
                                                <input type="checkbox" name="is_tools[]" class="hidden">
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
                                                <input type="checkbox" name="is_tools[]" class="hidden">
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
                                                <input type="checkbox" name="is_tools[]" class="hidden">
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
                        <div class="flex justify-evenly text-sm border-gray-300 bg-gray-300 font-semibold border-b border-x w-full px-2">
                            <span>B</span>
                            <span>C/RR</span>
                            <span>RB</span>
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
                        <a href="#addElectric" rel="modal:open" class="ml-auto text-green-500 cursor-pointer">
                            <i class="fas fa-plus-circle"></i>
                        </a>

                        <div id="addElectric" style="background-color: rgb(31, 41, 55);" class="modal text-gray-200 flex items-center justify-center">
                            {{-- <div class="flex justify-between items-center pb-3 text-lg">
                                Import Excel to Inventory
                            </div> --}}
                            <div class="text-xs">
                                <div class="grid grid-cols-6 gap-y-2 w-full">
                                    <p class="col-span-2 flex justify-center items-center">
                                        Parameter
                                    </p>
                                    <div></div>
                                    <div></div>
                                    <p class="flex justify-center items-center">
                                        Nilai
                                    </p>
                                    <p class="flex justify-center items-center text-center">
                                        Ambang Batas
                                    </p>

                                    <span class="ml-2 pr-1 text-xs col-span-3 flex items-center break-normal">
                                        <input type="text" id="elParam" class="w-64 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto"> 
                                    </span>
                                    <label for="elToggle" class="flex items-center cursor-pointer">
                                        <span class="relative">
                                            <span class="block w-10 h-6 bg-gray-400 rounded-full shadow-inner"></span>
                                            <span class="absolute block w-4 h-4 mt-1 ml-1 bg-white rounded-full shadow inset-y-0 left-0 focus-within:shadow-outline transition-transform duration-300 ease-in-out">
                                                <input onclick="toggleInput(this)" id="elToggle" type="checkbox" class="absolute opacity-0 w-0 h-0" />
                                            </span>
                                        </span>
                                    </label>
                                    <p class="flex items-center col-span-2">
                                        <input type="number" id="elValue" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                        <input type="text" id="elThreshold" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">
                                    </p>
                                </div>
                                <div class="flex w-full justify-end mt-4">
                                    <a onclick="addElectric()" href="#" rel="modal:close" class="block text-center text-white bg-green-600 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-24 mx-2">
                                        Add
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="align-middle my-3 mr-1">
                        <tbody id="elBody">
                            <tr>
                                <td class="w-64">
                                    <span class="ml-2 text-xs flex items-center">Tahanan hubungan pertanahan</span>
                                </td>
                                <td>
                                    <label for="el1" class="flex items-center cursor-pointer">
                                        <span class="relative">
                                            <span class="block w-10 h-6 bg-gray-400 rounded-full shadow-inner"></span>
                                            <span class="absolute block w-4 h-4 mt-1 ml-1 bg-white rounded-full shadow inset-y-0 left-0 focus-within:shadow-outline transition-transform duration-300 ease-in-out">
                                                <input onclick="toggleInput(this)" id="el1" name="is_el[]" type="checkbox" class="absolute opacity-0 w-0 h-0" />
                                            </span>
                                        </span>
                                    </label>
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
                                    <label for="el2" class="flex items-center cursor-pointer">
                                        <span class="relative">
                                            <span class="block w-10 h-6 bg-gray-400 rounded-full shadow-inner"></span>
                                            <span class="absolute block w-4 h-4 mt-1 ml-1 bg-white rounded-full shadow inset-y-0 left-0 focus-within:shadow-outline transition-transform duration-300 ease-in-out">
                                                <input onclick="toggleInput(this)" id="el2" name="is_el[]" type="checkbox" class="absolute opacity-0 w-0 h-0" />
                                            </span>
                                        </span>
                                    </label>
                                </td>
                                <td class="flex justify-start pl-2">
                                    <p id="el2Node" class="hidden items-center col-span-2">
                                        <input type="number" name="el[]" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto"> 
                                        &nbsp;&#8804;100&#xb5;A
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-64">
                                    <span class="ml-2 pr-1 text-xs col-span-3 flex items-center break-normal">Arus bocor Casis tanpa Pembumian</span>
                                </td>
                                <td>
                                    <label for="el3" class="flex items-center cursor-pointer">
                                        <span class="relative">
                                            <span class="block w-10 h-6 bg-gray-400 rounded-full shadow-inner"></span>
                                            <span class="absolute block w-4 h-4 mt-1 ml-1 bg-white rounded-full shadow inset-y-0 left-0 focus-within:shadow-outline transition-transform duration-300 ease-in-out">
                                                <input onclick="toggleInput(this)" id="el3" name="is_el[]" type="checkbox" class="absolute opacity-0 w-0 h-0" />
                                            </span>
                                        </span>
                                    </label>
                                </td>
                                <td class="flex justify-start pl-2">
                                    <p id="el3Node" class="hidden items-center col-span-2">
                                        <input type="number" name="el[]" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto"> 
                                        &nbsp;&#8804;500&#xb5;A
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-64">
                                    <span class="ml-2 pr-1 text-xs col-span-3 flex items-center break-normal">Arus bocor Casis Polaritas terbalik dengan Pembumian</span>
                                </td>
                                <td>
                                    <label for="el4" class="flex items-center cursor-pointer">
                                        <span class="relative">
                                            <span class="block w-10 h-6 bg-gray-400 rounded-full shadow-inner"></span>
                                            <span class="absolute block w-4 h-4 mt-1 ml-1 bg-white rounded-full shadow inset-y-0 left-0 focus-within:shadow-outline transition-transform duration-300 ease-in-out">
                                                <input onclick="toggleInput(this)" id="el4" name="is_el[]" type="checkbox" class="absolute opacity-0 w-0 h-0" />
                                            </span>
                                        </span>
                                    </label>
                                </td>
                                <td class="flex justify-start pl-2">
                                    <p id="el4Node" class="hidden items-center col-span-2">
                                        <input type="number" name="el[]" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto"> 
                                        &nbsp;&#8804;100&#xb5;A
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-64">
                                    <span class="ml-2 pr-1 text-xs col-span-3 flex items-center break-normal">Arus bocor Casis Polaritas terbalik tanpa Pembumian</span>
                                </td>
                                <td>
                                    <label for="el5" class="flex items-center cursor-pointer">
                                        <span class="relative">
                                            <span class="block w-10 h-6 bg-gray-400 rounded-full shadow-inner"></span>
                                            <span class="absolute block w-4 h-4 mt-1 ml-1 bg-white rounded-full shadow inset-y-0 left-0 focus-within:shadow-outline transition-transform duration-300 ease-in-out">
                                                <input onclick="toggleInput(this)" id="el5" name="is_el[]" type="checkbox" class="absolute opacity-0 w-0 h-0" />
                                            </span>
                                        </span>
                                    </label>
                                </td>
                                <td class="flex justify-start pl-2">
                                    <p id="el5Node" class="hidden items-center col-span-2">
                                        <input type="number" name="el[]" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto"> 
                                        &nbsp;&#8804;500&#xb5;A
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- <div class="flex flex-wrap justify-center mt-12">
                    <input type="submit" value="{{ __('Submit') }}" class="block text-center text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-48">
                </div>         --}}
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
            el.parentNode.classList.remove('bg-purple-600', 'transform', 'translate-x-full', 'active')
            el.parentNode.classList.add('bg-white')   

            showNode(key, false)
        } else {
            el.parentNode.classList.remove('bg-white')   
            el.parentNode.classList.add('bg-purple-600', 'transform', 'translate-x-full', 'active')

            showNode(key, true)
        }
    }

    function showNode(key, value) {
        let node = document.getElementById(key)

        if (value) {
            node.classList.remove('hidden')
            node.classList.add('flex')
        } else {
            node.classList.remove('flex')
            node.classList.add('hidden')
        }
    }

    function addElectric() {
        let param = document.getElementById('elParam').value
        let toggle = document.getElementById('elToggle').checked
        let value = document.getElementById('elValue').value
        let threshold = document.getElementById('elThreshold').value
        let table = document.getElementById('elBody')
        let checked = ''
        let checkedClass = 'bg-white'

        if (toggle) {
            checked = 'checked'
            checkedClass = 'bg-purple-600 transform translate-x-full active'
        }

        let row = table.insertRow()
        row.innerHTML = '<td class="w-64">'+
                            '<span class="ml-2 pr-1 text-xs col-span-3 flex items-center break-normal">'+param+'</span>'+
                            '<input type="hidden" name="elParam[]" value="'+param+'">'+
                        '</td>'+
                        '<td>'+
                            '<label class="flex items-center cursor-pointer">'+
                                '<span class="relative">'+
                                    '<span class="block w-10 h-6 bg-gray-400 rounded-full shadow-inner"></span>'+
                                    '<span class="absolute block w-4 h-4 mt-1 ml-1 '+checkedClass+' rounded-full shadow inset-y-0 left-0 focus-within:shadow-outline transition-transform duration-300 ease-in-out">'+
                                        '<input onclick="return false" '+checked+' name="is_el[]" type="checkbox" class="absolute opacity-0 w-0 h-0" />'+
                                    '</span>'+
                                '</span>'+
                            '</label>'+
                        '</td>'+
                        '<td class="flex justify-start pl-2">'+
                            '<p class="items-center">'+
                                '<input type="number" name="el[]" value="'+value+'" class="w-16 text-sm rounded shadow border-0 focus:ring-2 focus:ring-blue-400 mx-1 text-gray-600 ml-auto">&nbsp;'+threshold+
                                '<input type="hidden" name="elThrehold[]" value="'+threshold+'">'+
                            '</p>'+
                        '</td>'
    }
</script>
@endsection