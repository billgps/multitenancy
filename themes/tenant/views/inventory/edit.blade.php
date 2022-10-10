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
</style>

<script>
    function populate(data, select, param) {
        document.getElementById(select).innerHTML = ''
        
        for (let i = 0; i < data.length; i++) {
            let option
            if (param == 'model') {
                option = new Option(data[i].brand.brand + ' : ' + data[i].model, data[i].id, false, false);
            } else {
                option = new Option(data[i].brand.brand, data[i].id, false, false); 
            }
            $('#' + select).append(option).trigger('change');            
        }
    }
</script>

<main class="flex sm:container sm:mx-auto sm:mt-10">
    <div class="mx-auto w-4/5 sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="flex flex-col break-words bg-white sm:border-1">

            <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                {{ __('Edit Inventory') }}
            </header>
            
            <form class="w-3/5 mx-auto pb-6 my-6" method="POST"
                action="{{ route('inventory.update', ['inventory' => $inventory->id]) }}" enctype="multipart/form-data">
                @csrf
                <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-6">
                    <div class="col-span-2">
                        <label class="block text-sm text-gray-00" for="device_id">Device</label>
                        <div class="py-2 text-left flex">
                            <select style="width: 100%;" id="device_id" name="device_id" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4">
                                <option></option>
                                @foreach ($devices as $device)
                                    <option value="{{ $device->id }}">{{ $device->standard_name }}</option>
                                @endforeach
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#device_id').select2({
                                        placeholder: 'Select Device ID'
                                    });
                                });

                                $('#device_id').val({!! json_encode($inventory->device_id) !!})
                                $('#device_id').trigger('change')
                            </script>

                            <script>
                                $(document).ready(function() {
                                    let brandSelect = $('#device_id')
                                    $.ajax({
                                        type: "GET",
                                        url: "{{ route('identity.ajax') }}",
                                        data: {
                                            id: $('#device_id').select2('data')[0].id
                                        },
                                        success: function (data) {
                                            populate(data.data, 'identity_id', 'identity')
                                        },
                                        error: function (error) {
                                            console.log(error)
                                        }
                                    })
                                });
                            </script>
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="barcode">Barcode</label>
                        <div class="py-2 text-left">
                            <input value="{{ $inventory->barcode }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="barcode" name="barcode" type="text" required>
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="serial">Serial Number</label>
                        <div class="py-2 text-left">
                            <input value="{{ $inventory->serial }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="serial" name="serial" type="text" required>
                        </div>
                    </div>
                    {{-- <div class="col-span-2">
                        <label class="block text-sm text-gray-00" for="brand_id">Merk</label>
                        <div class="py-2 text-left flex">
                            <select style="width: 100%;" id="brand_id" name="brand_id" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4">
                                <option></option>
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#brand_id').select2({
                                        placeholder: 'Select Brand ID'
                                    });
                                });

                                $('#brand_id').val({!! json_encode($inventory->brand_id) !!})
                                $('#brand_id').trigger('change')
                                let shit = document.getElementById('brand_id').selectedIndex
                            </script>

                            <script>
                                $(document).ready(function() {
                                    brandSelect = $('#device_id')
                                    brandSelect.on('change', function () {
                                        $.ajax({
                                            type: "GET",
                                            url: "{{ route('brand.ajax') }}",
                                            data: {
                                                id: $('#device_id').select2('data')[0].id
                                            },
                                            success: function (data) {
                                                console.log(data.data);
                                                populate(data.data, 'brand_id', 'brand')
                                            },
                                            error: function (error) {
                                                console.log(error)
                                            }
                                        })
                                    })
                                });
                            </script>

                            <script>
                                $(document).ready(function() {
                                    let shit = document.getElementById('brand_id')
                                    console.log(shit.selectedIndex);
                                    $.ajax({
                                        type: "GET",
                                        url: "{{ route('identity.ajax') }}",
                                        data: {
                                            // id: $('#brand_id').select2('data')[0].id
                                        },
                                        success: function (data) {
                                            console.log(data.data);
                                            // populate(data.data, 'identity_id', 'model')
                                        },
                                        error: function (error) {
                                            console.log(error)
                                        }
                                    })
                                });
                            </script>
                        </div>
                    </div> --}}
                    <div class="col-span-2">
                        <label class="block text-sm text-gray-00" for="identity_id">Tipe Alat</label>
                        <div class="py-2 text-left flex">
                            <select style="width: 100%;" id="identity_id" name="identity_id" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4">
                                <option></option>
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#identity_id').select2({
                                        placeholder: 'Select Type ID'
                                    });
                                });

                                $('#identity_id').val({!! json_encode($inventory->identity_id) !!})
                                $('#identity_id').trigger('change')
                            </script>

                            <script>
                                $(document).ready(function() {
                                    typeSelect = $('#device_id')
                                    typeSelect.on('change', function () {
                                        $.ajax({
                                            type: "GET",
                                            url: "{{ route('identity.ajax') }}",
                                            data: {
                                                id: $('#device_id').select2('data')[0].id
                                            },
                                            success: function (data) {
                                                // console.log(data.data);
                                                populate(data.data, 'identity_id', 'model')
                                            },
                                            error: function (error) {
                                                console.log(error)
                                            }
                                        })
                                    })
                                });
                            </script>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm text-gray-00" for="room_id">Ruangan</label>
                        <div class="py-2 text-left flex">
                            <select style="width: 100%;" id="room_id" name="room_id" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4">
                                <option></option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                                @endforeach
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#room_id').select2({
                                        placeholder: 'Select Room ID'
                                    });
                                });

                                $('#room_id').val({!! json_encode($inventory->room_id) !!})
                                $('#room_id').trigger('change')
                            </script>
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="vendor">Vendor</label>
                        <div class="py-2 text-left">
                            <input value="{{ $inventory->Vendor }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="vendor" name="vendor" type="text">
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="price">Harga</label>
                        <div class="py-2 text-left">
                            <input value="{{ $inventory->price }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price" name="price" type="text">
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="penyusutan">Penyusutan</label>
                        <div class="py-2 text-left">
                            <input value="{{ $inventory->penyusutan}}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="penyusutan" name="penyusutan" type="text">
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="year_purchased">Tahun Perolehan Alat</label>
                        <div class="py-2 text-left">
                            <input value="{{ $inventory->year_purchased }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="year_purchased" name="year_purchased" type="text">
                        </div>
                    </div>
                    <div class="flex flex-col col-span-2">
                        <label class="block mb-2 text-sm text-gray-00" for="picture">Foto Alat</label>
                        <div class="py-2 text-left">
                            <input class="" id="picture" name="picture" type="file" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap justify-center mt-12">
                    <input type="submit" value="{{ __('Update') }}" class="block text-center text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-48">
                </div>        
            </form>

        </section>
    </div>
</main>


@endsection