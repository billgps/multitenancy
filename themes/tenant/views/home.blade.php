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
                        {{ $scheduled + $expired }}
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
                                        'rgba(52, 211, 153, 0.7)',
                                        'rgba(251, 191, 135, 0.7)',
                                        'rgba(239, 68, 68, 0.7)',
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
                        let rusak_chart = new Chart(rusak, {
                            type: 'doughnut',
                            data: {
                                labels: ['Laik', 'Tidak Laik', 'Belum Update'],
                                datasets: [{
                                    data: [passed, failed, total - (passed + failed)],
                                    backgroundColor: [
                                        'rgba(52, 211, 153, 0.7)',
                                        'rgba(239, 68, 68, 0.7)',
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
                            activePoints = rusak_chart.getElementsAtEvent(event)

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
                        let laik_chart = new Chart(laik, {
                            type: 'doughnut',
                            data: {
                                labels: ['Baik', 'Rusak', 'Belum Update'],
                                datasets: [{
                                    data: [good, broken, total - (good + broken)],
                                    backgroundColor: [
                                        'rgba(52, 211, 153, 0.7)',
                                        'rgba(239, 68, 68, 0.7)',
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
                            activePoints = laik_chart.getElementsAtEvent(event)

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
                    Diagram Data Inventory
                </div>
                <div style="background-image: {{ public_path('grid.png') }}" class="flex flex-col mt-6">
                    <div class="w-full h-full">
                        <canvas id="polarChart" class="text-sm text-gray-700"></canvas>
                    </div>        
                </div>
            </div>

            <div style="height: 437px;" class="col-span-2 flex flex-col w-full">
                <div class="w-full">
                    <ul id="tabBar" class='flex cursor-pointer'>
                      <li onclick="toggleTab(0)" class='tab py-2 active px-4 text-sm text-gray-600 bg-white rounded-t-lg'>Ruangan</li>
                      <li onclick="toggleTab(1)" class='tab py-2 px-4 text-sm rounded-t-lg text-gray-600 bg-gray-300'>Nama Alat</li>
                    </ul>
                </div>
                <div class='w-full h-full mx-auto bg-white p-4 flex flex-col no-scrollbar overflow-hidden'>
                    <div id="legend" class="h-full overflow-y-auto no-scrollbar"></div>
                    Total alat : {{ $total }}
                </div>
            </div>

            <script>
                Chart.defaults.global.legend.display = false; 
                const colors = []
                const data = {
                    labels: [],
                    datasets: [
                        {
                            label: '',
                            data: [],
                            backgroundColor: []                        
                        }
                    ]
                };

                const ctx = document.getElementById('polarChart').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'pie',
                    data: data,
                    options: {
                        legendCallback: function (chart) {
                            let text = [];
                            text.push('<ul>');
                            for (let i = 0; i < chart.data.datasets[0].data.length; i++) {
                                text.push('<li class="flex items-center">');
                                text.push('<div style="background-color:' + chart.data.datasets[0].backgroundColor[i] + '" class="w-6 h-3 mr-6 my-1"></div>');
                                if (chart.data.labels[i]) {
                                    text.push('<p class="text-sm text-left">' + chart.data.labels[i] + '</p>');
                                }
                                text.push('<span class="ml-auto">' + chart.data.datasets[0].data[i] + '</span>')
                                text.push('</li>');
                            }
                            text.push('</ul>');

                            return text.join("");
                        }
                    },
                })

                toggleTab(0)

                function toggleTab(el) {
                    let tabs = document.getElementsByClassName('tab')
                    for (let i = 0; i < tabs.length; i++) {
                        if (i == el) {
                            fetchData(el)
                            if (!tabs[i].classList.contains('active')) {
                                tabs[i].classList.remove('bg-gray-300')
                                tabs[i].classList.add('active', 'bg-white')
                            }
                        } else {
                            tabs[i].classList.remove('active', 'bg-white')
                            if (!tabs[i].classList.contains('bg-gray-300')) {
                                tabs[i].classList.add('bg-gray-300')
                            }
                        }
                    }
                }

                function fetchData(index) {
                    let params = ['room', 'device']

                    $.ajax({
                        url: '/ajax/pie/' + params[index],
                        type: 'get',
                        success: function (res) {
                            let e = JSON.parse(res)

                            for(let i = 0;i < e.datasets.length; i++){
                                const randomNum = () => Math.floor(Math.random() * (235 - 52 + 1) + 52);
                                const randomRGB = () => `rgba(${randomNum()}, ${randomNum()}, ${randomNum()}, 0.5)`;

                                colors.push(randomRGB());
                            }

                            myChart.data.labels = e.labels
                            myChart.data.datasets[0].data = e.datasets
                            myChart.data.datasets[0].backgroundColor = colors
                            myChart.update()

                            document.getElementById('legend').innerHTML = myChart.generateLegend()
                        }
                    })
                }
            </script>

            <div class="col-span-2 flex overflow-y-auto w-full px-4 pb-4 no-scrollbar bg-white">
                <div class="w-full h-96 justify-center text-gray-600">
                    <div class="text-md w-full bg-white sticky top-0 pt-4 pb-2">
                        Kalibrasi Terbaru
                    </div>
                    <table id="records" class="min-w-max mt-3 w-full table-auto text-center">
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($records as $record)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left">
                                        <a href="{{ route('inventory.show', ['id' => $record->inventory->id]) }}">
                                            <div class="text-sm">
                                                {{ $record->inventory->device->standard_name }}
                                            </div>
                                            <div class="text-xs flex items-center">
                                                {{ $record->created_at }}
                                                @if ($record->result == 'Laik')
                                                    <div class="rounded bg-green-400 text-gray-800 py-1 px-3 mx-2 text-xs font-bold">
                                                        {{ $record->result }}
                                                    </div>
                                                @elseif ($record->result == 'Tidak Laik')
                                                    <div class="rounded bg-red-400 text-gray-800 py-1 px-3 mx-2 text-xs font-bold">
                                                        {{ $record->result }}
                                                    </div>
                                                @else
                                                    <div class="rounded bg-yellow-400 text-gray-800 py-1 px-3 mx-2 text-xs font-bold">
                                                        {{ $record->result }}
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="height: 437px;" class="col-span-4 flex overflow-y-auto w-full p-4 no-scrollbar bg-white">
                <div class="overflow-auto w-full justify-center text-gray-600">
                    <div class="text-md">
                        Wajib Kalibrasi
                    </div>
                    <table id="records" class="min-w-max mt-3 w-full table-auto text-center">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6">Nama</th>
                                <th class="py-3 px-6">Tanggal Kalibrasi</th>
                                <th class="py-3 px-6">Tenggang</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($must_calibrates as $i)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left">
                                        <a href="{{ route('inventory.show', ['id' => $i->id]) }}">
                                            {{ $i->device->standard_name }}
                                        </a>
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $i->latest_record->cal_date }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $i->latest_record->updated_at }}
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
