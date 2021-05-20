@extends('layouts.app')

@section('content')
<style>
    canvas {
        width: 100%;
        height: 100%;
    }
</style>
<main class="sm:container sm:mx-auto sm:mt-10">
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="sm:grid sm:grid-cols-6 sm:gap-2 break-words">
            <div class="col-span-2 flex h-24 w-full p-4 bg-gray-100">
                <div class="w-full justify-center">
                    <div class="text-md text-gray-600">
                        Wajib Kalibrasi
                    </div>
                    <div class="mt-4 text-2xl text-center text-yellow-500">
                        1
                    </div>
                </div>
            </div>
            <div class="col-span-2 flex h-24 w-full p-4 bg-gray-100">
                <div class="w-full justify-center">
                    <div class="text-md text-gray-600">
                        Laik
                    </div>
                    <div class="mt-4 text-2xl text-center text-green-500">
                        1
                    </div>
                </div>
            </div>
            <div class="col-span-2 flex h-24 w-full p-4 bg-gray-100">
                <div class="w-full justify-center">
                    <div class="text-md text-gray-600">
                        Baik
                    </div>
                    <div class="mt-4 text-2xl text-center text-purple-500">
                        1
                    </div>
                </div>
            </div>
            
            <div class="col-span-2 bg-gray-100 p-3">
                <div class="flex flex-col">
                    <div class="w-full">
                        <canvas id="wajib_chart" class="mx-auto my-auto p-3 text-sm text-gray-700"></canvas>
                    </div>        
                    <script>
                        let wajib = document.getElementById('wajib_chart')
                        let myChart = new Chart(wajib, {
                            type: 'doughnut',
                            data: {
                                labels: ['Terkalibrasi', 'Segera Kalibrasi'],
                                datasets: [{
                                    data: [100, 50],
                                    backgroundColor: [
                                        'rgba(52, 211, 153, 1)',
                                        'rgba(209, 213, 219, 0.3)',
                                    ],
                                }]
                            },
                            options: {
                                responsive: false,
                                maintainAspectRatio: false,
                                legend: {
                                    display: false,
                                }
                            }
                        })
                    </script>  
                </div>
            </div>
            <div class="col-span-2 bg-gray-100 p-3">
                <div class="flex flex-col">
                    <div class="w-full">
                        <canvas id="rusak_chart" class="mx-auto my-auto p-3 text-sm text-gray-700"></canvas>
                    </div>        
                    <script>
                        let rusak = document.getElementById('rusak_chart')
                        myChart = new Chart(rusak, {
                            type: 'doughnut',
                            data: {
                                labels: ['Terkalibrasi', 'Segera Kalibrasi'],
                                datasets: [{
                                    data: [100, 50],
                                    backgroundColor: [
                                        'rgba(52, 211, 153, 1)',
                                        'rgba(209, 213, 219, 0.3)',
                                    ],
                                }]
                            },
                            options: {
                                responsive: false,
                                maintainAspectRatio: false,
                                legend: {
                                    display: false,
                                }
                            }
                        })
                    </script>  
                </div>
            </div>
            <div class="col-span-2 bg-gray-100 p-3">
                <div class="flex flex-col">
                    <div class="w-full">
                        <canvas id="laik_chart" class="mx-auto my-auto p-3 text-sm text-gray-700"></canvas>
                    </div>        
                    <script>
                        let laik = document.getElementById('laik_chart')
                        myChart = new Chart(laik, {
                            type: 'doughnut',
                            data: {
                                labels: ['Terkalibrasi', 'Segera Kalibrasi'],
                                datasets: [{
                                    data: [100, 50],
                                    backgroundColor: [
                                        'rgba(52, 211, 153, 1)',
                                        'rgba(209, 213, 219, 0.3)',
                                    ],
                                }]
                            },
                            options: {
                                responsive: false,
                                maintainAspectRatio: false,
                                legend: {
                                    display: false,
                                }
                            }
                        })
                    </script>  
                </div>
            </div>

            <div class="col-span-4 flex w-full p-4 bg-gray-100">
                <div class="text-md text-gray-600">
                    Statistik Kerusakan Alat
                </div>
                {{-- <div class="flex flex-col mt-6">
                    <div class="w-full">
                        <canvas id="line_chart" class="mx-auto my-auto p-3 text-sm text-gray-700"></canvas>
                    </div>        
                    <script>
                        let line = document.getElementById('line_chart')
                        myChart = new Chart(line, {
                            type: 'doughnut',
                            data: {
                                labels: ['Terkalibrasi', 'Segera Kalibrasi'],
                                datasets: [{
                                    data: [100, 50],
                                    backgroundColor: [
                                        'rgba(52, 211, 153, 1)',
                                        'rgba(209, 213, 219, 0.3)',
                                    ],
                                }]
                            },
                            options: {
                                responsive: false,
                                maintainAspectRatio: false,
                                legend: {
                                    display: false,
                                }
                            }
                        })
                    </script>  
                </div> --}}
            </div>
            <div class="col-span-2 flex overflow-y-auto w-full p-4 bg-gray-100">
                <div class="w-full justify-center text-gray-600">
                    <div class="text-md">
                        Kalibrasi Terbaru
                    </div>
                    <table id="records" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal border-b border-gray-600">
                                <th class="py-3 px-6">Nama Alat</th>
                                <th class="py-3 px-6">Tanggal Kalibrasi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($records as $record)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6">
                                        {{ $record->inventory->device->name }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $record->created_at }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-span-3 flex overflow-y-auto w-full p-4 bg-gray-100">
                <div class="w-full justify-center text-gray-600">
                    <div class="text-md">
                        Alat Kesehatan Baru
                    </div>
                    <table id="records" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal border-b border-gray-600">
                                <th class="py-3 px-6">Nama</th>
                                <th class="py-3 px-6">Ruangan</th>
                                <th class="py-3 px-6">Merk</th>
                                <th class="py-3 px-6">Status Kalibrasi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($records as $record)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6">
                                        {{ $record->inventory->device->name }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $record->created_at }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-span-3 flex overflow-y-auto w-full p-4 bg-gray-100">
                <div class="w-full justify-center text-gray-600">
                    <div class="text-md">
                        Wajib Kalibrasi
                    </div>
                    <table id="records" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal border-b border-gray-600">
                                <th class="py-3 px-6">Nama</th>
                                <th class="py-3 px-6">Tanggal Kalibrasi</th>
                                <th class="py-3 px-6">Tenggang</th>
                                <th class="py-3 px-6">Kondisi Alat</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($records as $record)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6">
                                        {{ $record->inventory->device->name }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $record->created_at }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection
