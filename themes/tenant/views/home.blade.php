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
        let expired = {!! json_encode($expired) !!}
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
                        let wajibChart = new Chart(wajib, {
                            type: 'doughnut',
                            data: {
                                labels: ['Terkalibrasi', 'Segera Kalibrasi', 'Expired', 'Belum Update'],
                                datasets: [{
                                    data: [calibrated, scheduled, expired, total - (scheduled + calibrated + expired)],
                                    backgroundColor: [
                                        'rgba(52, 211, 153, 1)',
                                        'rgba(251, 191, 135, 1)',
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

                        $('#wajib_chart').click(function(event){
                            activePoints = wajibChart.getElementsAtEvent(event)

                            if (activePoints[0]) {
                                let chartData = activePoints[0]['_chart'].config.data;
                                let idx = activePoints[0]['_index'];

                                let label = chartData.labels[idx];

                                if (label == 'Segera Kalibrasi') {
                                    window.location.href = "{{ route('inventory.param', ['parameter' => 'calibration_status', 'value' => 'Segera Dikalibrasi']) }}"
                                }

                                else if (label == 'Expired') {
                                    window.location.href = "{{ route('inventory.param', ['parameter' => 'calibration_status', 'value' => 'Expired']) }}"
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
                        let laik_chart = new Chart(rusak, {
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

                        $('#rusak_chart').click(function(event){
                            activePoints = laik_chart.getElementsAtEvent(event)

                            if (activePoints[0]) {
                                let chartData = activePoints[0]['_chart'].config.data;
                                let idx = activePoints[0]['_index'];

                                let label = chartData.labels[idx];

                                if (label == 'Tidak Laik') {
                                    window.location.href = "{{ route('record.param', ['param' => 'Tidak_Laik']) }}"
                                }

                                else if (label == 'Laik') {
                                    window.location.href = "{{ route('record.param', ['param' => 'Laik']) }}"
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
                        let baik_chart = new Chart(laik, {
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

                        $('#laik_chart').click(function(event){
                            activePoints = baik_chart.getElementsAtEvent(event)

                            if (activePoints[0]) {
                                let chartData = activePoints[0]['_chart'].config.data;
                                let idx = activePoints[0]['_index'];

                                let label = chartData.labels[idx];

                                if (label == 'Rusak') {
                                    window.location.href = "{{ route('condition.param', ['param' => 'Rusak']) }}"
                                }

                                else if (label == 'Baik') {
                                    window.location.href = "{{ route('condition.param', ['param' => 'Baik']) }}"
                                }
                            }
                        })
                    </script>  
                </div>
            </div>

            <div class="col-span-4 w-full p-4 bg-white">
                <div class="text-md flex text-left text-gray-600">
                    Kerusakan Alat
                </div>
                <div class="flex flex-col mt-6">
                    <div class="w-full h-full">
                        <canvas id="line-chart" class="text-sm text-gray-700"></canvas>
                    </div>        
                    <script>
                        var array1 = {!! json_encode($statistic)  !!};
                        var months = []
                        let data = []
                        for (var property in array1) {
                            months.unshift(property)
                        }

                        for (let i = 0; i < months.length; i++) {
                            data.push(array1[months[i]].length)
                        }

                        var chart = new Chart(document.getElementById("line-chart"), {
                            type: 'line',
                            data: {
                                    labels: months,
                                    datasets: [{
                                    backgroundColor: 'rgba(239, 68, 68, 1)',
                                    borderColor: 'rgba(239, 68, 68, 1)',
                                    data: data,
                                    fill: false
                                }]
                            },
                            options: {
                                responsive: true,
                                // scales: {
                                //     xAxes: [{
                                //         type: 'time',
                                //         time: {
                                //             unit: 'month'
                                //         }
                                //     }]
                                // },
                                legend: {
                                    display: false,
                                }
                            }
                        });            
                        // console.log(months);
                        // new Chart(document.getElementById("line-chart"), {
                        //     type: 'line',
                        //     data: {
                        //         labels: months,
                        //         // datasets: [
                        //         //     { 
                        //         //         data: [86,114,106,106,107,111,133,221,783,2478],
                        //         //         label: "Africa",
                        //         //         borderColor: "#3e95cd",
                        //         //         fill: false
                        //         //     }, 
                        //         // ],
                        //     },
                        // });
                    </script>  
                </div>
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
                                        @elseif ($inventory->latest_record->calibration_status == 'Expired')
                                            <div class="rounded bg-red-400 text-gray-800 py-1 px-3 text-xs font-bold">
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
