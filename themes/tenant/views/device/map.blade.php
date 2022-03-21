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
                <form method="POST" enctype="multipart/form-data" action="{{ route('device.map') }}">
                    @csrf
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
                            <tbody id="deviceBody" class="text-gray-600 text-sm font-light">
                                @foreach ($devices as $device)
                                    <tr class="hover:bg-gray-100">
                                        <td class="py-3 px-6 text-left w-80 break-normal">
                                            {{ $device['nama_alat'] }}
                                            <input type="hidden" name="standard_name[]" value="{{ $device['nama_alat'] }}">
                                            <input type="hidden" name="isNewKeyword[]" value="0">
                                        </td>
                                        <td>
                                            <a onclick="getIndex(this.parentNode.parentNode)" href="#map" rel="modal:open">
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
                                                <input type="hidden" name="nomenclature_id[]" value="null">
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> 
                    </div>
                    <div class="flex w-full justify-end py-2 px-6">
                        <input type="submit" value="{{ __('Import') }}" class="block text-center text-white bg-green-600 p-3 duration-300 rounded-sm hover:bg-black cursor-pointer w-full sm:w-24 mx-2">
                    </div>
                </form>
            </div>
        </section>
    </div>
</main>

<script>
    function mapRow(nom) {
        let deviceIndex = document.getElementById('row-index').value
        let deviceBody  = document.getElementById('deviceBody')
        let notFound = deviceBody.rows[deviceIndex - 1].querySelector('.not-found')
        if (notFound != null) {
            let currentRow = notFound.parentNode
            currentRow.removeChild(notFound)
            currentRow.innerHTML += populateRow(nom)
            addKeyword(currentRow)
        } else {
            let cellId = deviceBody.rows[deviceIndex - 1].querySelector('.nom-id')
            let cellName = deviceBody.rows[deviceIndex - 1].querySelector('.nom-name')
            let cellRisk = deviceBody.rows[deviceIndex - 1].querySelector('.nom-risk')
            let currentRow = cellId.parentNode
            currentRow.removeChild(cellId)
            currentRow.removeChild(cellName)
            currentRow.removeChild(cellRisk)
            currentRow.innerHTML += populateRow(nom)
            addKeyword(currentRow)
        }   

        let standard_name = deviceBody.rows[deviceIndex - 1].querySelector('input[name="standard_name[]"]').value        
    }

    function getIndex(i) {
        // reset innerHTML for device name
        document.getElementById('deviceName').innerHTML = ""
        let rowPlaceholder = document.getElementById('row-index');
        rowPlaceholder.value = i.rowIndex

        let standardName = i.querySelector('input[name="standard_name[]"]').value
        
        // set name in modal
        document.getElementById('deviceName').innerHTML = standardName
    }

    function addKeyword(row) {
        row.querySelector('input[name="isNewKeyword[]"]').value = 1
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': "{{ csrf_token() }}"
        //     }
        // });

        // $.ajax({
        //     url    : '/ajax/keyword/' + nomenclature_id + '/store',
        //     data   : {
        //         'standard_name': standard_name
        //     },
        //     type   : "post",
        //     success: function(data) {
        //         console.log('succeed');
        //     },
        //     error: function (error) {
        //         console.log(error);
        //     }
        // })
    }

    function populateRow(nom) {
        let riskClass = ''
        let riskText = ''
        console.log(nom.risk_level);

        switch (nom.risk_level) {
            case '1':
                riskClass = 'bg-green-400'
                riskText = '12 Bulan (Low)'
                break;

            case '2':
                riskClass = 'bg-yellow-400'
                riskText = '6 Bulan (Medium)'
                break;
        
            default:
                riskClass = 'bg-red-400'
                riskText = '4 Bulan (High)'
                break;
        }

        return '<td class="nom-id w-8 font-semibold">'+nom.id+
                    '<input type="hidden" name="nomenclature_id[]" value="'+nom.id+'">'+
                '</td>'+
                '<td class="nom-name break-normal w-96 text-justify">'+nom.standard_name+
                '</td>'+
                '<td class="nom-risk flex w-full h-16 justify-center items-center">'+
                    '<div class="rounded '+riskClass+' text-gray-800 py-1 px-3 text-xs font-bold">'+riskText+
                    '</div>'+
                '</td>'
    }
</script>

<div id="map" style="max-width: fit-content;" class="modal text-gray-600 w-1/2 flex items-center justify-center">
    <div class="flex justify-between items-center pb-3 text-lg">
        Find Nomenclature for <span id="deviceName"></span>
        <input type="hidden" id="row-index" value="">
    </div>
    <div class="flex relative mx-auto w-full">
        <input class="h-8 rounded-r-none text-xs text-gray-800 w-full px-2 rounded-md focus:ring-0 border-none" id="searchTerm" type="text" placeholder="Search..." name="search" />
        <button disabled type="button" class="h-8 rounded-l-none w-20 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:text-gray-800 hover:bg-gray-400 active:bg-gray-900 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">
            Search
        </button>
    </div>
    <div class="text-xs h-3/4 overflow-auto no-scrollbar py-3">
        <table class="rounded-t-lg mx-auto bg-white-200 text-gray-600" id="productsTable">
            <thead>
                <tr class="text-left border-b-2 border-gray-300">
                    <th class="px-4 text-sm text-center py-3">Nama Alat</th>
                    <th class="px-4 text-sm text-center py-3">Kode ASPAK</th>
                    <th class="px-4 text-sm py-3 text-center">Risk Level</th>
                    <th class="px-4 text-sm py-3"></th>
                </tr>
            </thead>
            <tbody class="text-base">
                @foreach ($nomenclatures as $nom)
                    <tr>
                        <td class="w-96 break-normal px-2 py-1 text-left ">{{ $nom->standard_name }}</td>
                        <td class="px-2 py-1 text-center ">{{ $nom->aspak_code }}</td>
                        <td class="px-2 py-1 text-center ">{{ $nom->risk_level }}</td>
                        <td class="">
                            <a href="#" rel="modal:close" onclick="mapRow({{ $nom }})" class="text-green-500 hover:text-gray-400">
                                <i class="fas fa-badge-check"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready( function () {
            let table = $('#productsTable').DataTable({
                dom: 'lrt',
                scrollY: "450px",
                // scrollCollapse: true,
                paging: false,
                info: false,
                lengthChange: false,
                order: [],
                columnDefs: [
                    {targets: [2, 3], orderable: false},
                ]
            });

            $('#searchTerm').keyup(function(){
                table.search($(this).val()).draw()
            })
        });
    </script>
</div>  
@endsection