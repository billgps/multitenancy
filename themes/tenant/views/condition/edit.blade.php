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

<main class="flex sm:container sm:mx-auto sm:mt-10">
    <div class="mx-auto w-4/5 sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="flex flex-col break-words bg-white sm:border-1">

            <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                {{ __('Edit Condition') }}
            </header>

            <form class="w-3/5 mx-auto pb-6 my-6" method="POST"
                action="{{ route('condition.update', ['condition' => $condition->id]) }}" enctype="multipart/form-data">
                @csrf
                <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-6">
                    <div class="col-span-2">
                        <label class="block text-sm text-gray-00" for="device_id">ID Inventory</label>
                        <div class="py-2 text-left flex">
                            <select style="width: 100%;" id="inventory_id" name="inventory_id" class="text-sm bg-gray-200 border-2 border-gray-100 focus:outline-none block w-full py-2 px-4">
                                <option></option>
                                @foreach ($inventories as $inventory)
                                    <option value="{{ $inventory->id }}">{{ $inventory->barcode.': '.$inventory->device->standard_name }}</option>
                                @endforeach
                            </select>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#inventory_id').select2({
                                        placeholder: 'Select Inventory ID'
                                    });
                                });

                                $('#inventory_id').val({!! json_encode($condition->inventory_id) !!})
                                $('#inventory_id').trigger('change')
                            </script>
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="event">Detail Kejadian</label>
                        <div class="py-2 text-left">
                            <textarea rows="4" cols="16" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="event" name="event" required>{{ $condition->event }}</textarea>
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="event_date">Tanggal Kejadian</label>
                        <div class="py-2 text-left">
                            <input value="{{ $condition->event_date }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="event_date" name="event_date" type="date" required>
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="status">Status Alat</label>
                        <div class="py-2 text-left">
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="status" id="status" required>
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </div>

                        <script>
                            let status = document.getElementById('status')
                            for (let i = 0; i < status.options.length; i++) {
                                if ({!! json_encode($condition->status) !!} == status.options[i].value) {
                                    status.options[i].selected = true
                                }                                
                            }
                        </script>
                    </div>
                    <div></div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="worksheet">Lembar Kerja</label>
                        <div class="py-2 text-left">
                            <input class="" id="worksheet" name="worksheet" type="file">
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