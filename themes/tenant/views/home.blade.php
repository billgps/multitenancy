@extends('layouts.app')

@section('content')
<style>
    canvas {
        width: 100%;
        height: 100%;
    }
</style>
<main class="sm:container sm:mx-auto sm:mt-10">
    <script>
        let scheduled = {!! json_encode($scheduled) !!}
        let calibrated = {!! json_encode($calibrated) !!}
        let good = {!! json_encode($good) !!}
        let broken = {!! json_encode($broken) !!}
        let passed = {!! json_encode($passed) !!}
        let failed = {!! json_encode($failed) !!}
        let total = {!! json_encode($total) !!}
    </script>
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="sm:grid sm:grid-cols-6 sm:gap-2 break-words">
            <div class="col-span-2 flex h-24 w-full p-4 bg-white">
                <div class="w-full justify-center">
                    <div class="text-md text-gray-600">
                        Wajib Kalibrasi
                    </div>
                    <div class="mt-4 text-2xl text-center text-yellow-500">
                        {{ $scheduled }}
                    </div>
                </div>
            </div>
            <div class="col-span-2 flex h-24 w-full p-4 bg-white">
                <div class="w-full justify-center">
                    <div class="text-md text-gray-600">
                        Laik
                    </div>
                    <div class="mt-4 text-2xl text-center text-green-500">
                        {{ $passed }}
                    </div>
                </div>
            </div>
            <div class="col-span-2 flex h-24 w-full p-4 bg-white">
                <div class="w-full justify-center">
                    <div class="text-md text-gray-600">
                        Baik
                    </div>
                    <div class="mt-4 text-2xl text-center text-green-500">
                        {{ $good }}
                    </div>
                </div>
            </div>
            
            <div class="col-span-2 bg-white p-3">
                <div class="flex flex-col">
                    <div class="w-full">
                        <canvas id="wajib_chart" class="mx-auto my-auto p-3 text-sm text-gray-700"></canvas>
                    </div>        
                    <script>
                        let wajib = document.getElementById('wajib_chart')
                        console.log(total);
                        let myChart = new Chart(wajib, {
                            type: 'doughnut',
                            data: {
                                labels: ['Terkalibrasi', 'Segera Kalibrasi', 'Belum Update'],
                                datasets: [{
                                    data: [calibrated, scheduled, total - (scheduled + calibrated)],
                                    backgroundColor: [
                                        'rgba(52, 211, 153, 1)',
                                        'rgba(251, 191, 135, 1)',
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
            <div class="col-span-2 bg-white p-3">
                <div class="flex flex-col">
                    <div class="w-full">
                        <canvas id="rusak_chart" class="mx-auto my-auto p-3 text-sm text-gray-700"></canvas>
                    </div>        
                    <script>
                        let rusak = document.getElementById('rusak_chart')
                        myChart = new Chart(rusak, {
                            type: 'doughnut',
                            data: {
                                labels: ['Laik', 'Tidak Laik', 'Belum Update'],
                                datasets: [{
                                    data: [passed, failed, total - (passed + failed)],
                                    backgroundColor: [
                                        'rgba(52, 211, 153, 1)',
                                        'rgba(239, 68, 68, 1)',
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
            <div class="col-span-2 bg-white p-3">
                <div class="flex flex-col">
                    <div class="w-full">
                        <canvas id="laik_chart" class="mx-auto my-auto p-3 text-sm text-gray-700"></canvas>
                    </div>        
                    <script>
                        let laik = document.getElementById('laik_chart')
                        myChart = new Chart(laik, {
                            type: 'doughnut',
                            data: {
                                labels: ['Baik', 'Rusak', 'Belum Update'],
                                datasets: [{
                                    data: [good, broken, total - (good + broken)],
                                    backgroundColor: [
                                        'rgba(52, 211, 153, 1)',
                                        'rgba(239, 68, 68, 1)',
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

            <div class="col-span-4 flex w-full p-4 bg-white">
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
            <div class="col-span-2 flex overflow-y-auto w-full p-4 bg-white">
                <div class="w-full justify-center text-gray-600">
                    <div class="text-md">
                        Kalibrasi Terbaru
                    </div>
                    <table id="records" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6">Nama Alat</th>
                                <th class="py-3 px-6">Tanggal Kalibrasi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($records as $record)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6">
                                        {{ $record->inventory->device->standard_name }}
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

            <div class="col-span-3 flex overflow-y-auto w-full p-4 bg-white">
                <div class="w-full justify-center text-gray-600">
                    <div class="text-md">
                        Inventori Baru
                    </div>
                    <table id="records" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6">Nama</th>
                                <th class="py-3 px-6">Ruangan</th>
                                <th class="py-3 px-6">Merk</th>
                                <th class="py-3 px-6">Status Kalibrasi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($inventories as $inventory)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6">
                                        {{ $inventory->device->standard_name }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $inventory->room->room_name }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $inventory->brand->brand }}
                                    </td>
                                    <td class="py-3 px-6">
                                        @if ($inventory->latest_record->calibration_status == 'Terkalibrasi')
                                            <div class="rounded bg-green-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                {{ $inventory->latest_record->calibration_status }}
                                            </div>
                                        @else
                                            <div class="rounded bg-yellow-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                {{ $inventory->latest_record->calibration_status }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-span-3 flex overflow-y-auto w-full p-4 bg-white">
                <div class="w-full justify-center text-gray-600">
                    <div class="text-md">
                        Wajib Kalibrasi
                    </div>
                    <table id="records" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6">Nama</th>
                                <th class="py-3 px-6">Tanggal Kalibrasi</th>
                                <th class="py-3 px-6">Tenggang</th>
                                <th class="py-3 px-6">Kondisi Alat</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($pending as $item)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6">
                                        {{ $item->device->standard_name }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $item->latest_record->cal_date }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $item->latest_record->updated_at }}
                                    </td>
                                    {{-- <td class="py-3 px-6">
                                        @if ($item->latest_record->calibration_status == 'Terkalibrasi')
                                            <div class="rounded bg-green-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                {{ $item->latest_record->calibration_status }}
                                            </div>
                                        @else
                                            <div class="rounded bg-yellow-400 text-gray-800 py-1 px-3 text-xs font-bold">
                                                {{ $item->latest_record->calibration_status }}
                                            </div>
                                        @endif
                                    </td> --}}
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
