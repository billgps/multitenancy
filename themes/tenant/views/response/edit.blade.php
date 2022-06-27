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
                {{ __('Edit Response') }}
                <div class="text-xs mt-3">
                    {{ __('Complain ID : '.$response->complain_id) }}
                </div>
            </header>

            <form class="w-3/5 mx-auto pb-6 my-6" method="POST"
                action="{{ route('response.update', ['response' => $response]) }}"enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="complain_id" value="{{ $response->complain->id }}">
                <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-6">
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="progress_status">Status Respon</label>
                        <div class="py-2 text-left">
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="progress_status" id="progress_status" required>
                                <option value="Pending">Pending</option>
                                <option value="Replied">Replied</option>
                                <option value="Finished">Finished</option>
                            </select>
                        </div>
                        <div class="row-start-2">
                            <label class="block mb-2 text-sm text-gray-00" for="status">Status</label>
                            <div class="py-2 text-left">
                                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="status" id="status" required>
                                    <option value="Maintenance">Maintenance</option>
                                    <option value="Consumable">Consumable</option>
                                    <option value="Rusak">Rusak</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <div class="py-2 text-left">
                                <label class="block mb-2 text-sm text-gray-00" for="resPic">Upload Foto</label>
                                <div class="py-2 text-left">
                                    <input class="" id="resPic" name="resPic" type="file" accept="image/*">
                                    <p style="font-size:10px;font-style:italic;color:red;">max size: 2MB</p>
                                </div>
                            </div>
                        </div>

                        <script>
                            let status = {!! json_encode($response->progress_status) !!}
                            let select = document.getElementById('progress_status')
                            for (let i = 0; i < select.options.length; i++) {
                                if (select.options[i].value == status) {
                                    select.selectedIndex = i
                                }
                            }
                        </script>
                    </div>
                    <div class="col-span-2">
                        <label class="block mb-2 text-sm text-gray-00" for="description">Deskripsi</label>
                        <div class="py-2 text-left">
                            <textarea rows="4" cols="16" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" type="number" required>{{ $response->description }}</textarea>
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