@extends('layouts.app')

@section('content')
<main class="flex sm:container sm:mx-auto sm:mt-10">
    <div class="mx-auto w-4/5 sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="flex flex-col break-words bg-white sm:border-1">

            <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                {{ __('Create Activity') }}
            </header>

            <form class="w-3/5 mx-auto pb-6 my-6" method="POST"
                action="{{ route('activity.store') }}">
                @csrf
                <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-6">
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="brand">Nomor PO</label>
                        <div class="py-2 text-left">
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="order_no" name="order_no" type="text" required>
                        </div>
                    </div>
                    <div class="row-start-2">
                        <label class="block mb-2 text-sm text-gray-00" for="origin">Tanggal Mulai</label>
                        <div class="py-2 text-left">
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="started_at" name="started_at" type="date" required>
                        </div>
                    </div>
                    <div class="row-start-2">
                        <label class="block mb-2 text-sm text-gray-00" for="origin">Tanggal Selesai</label>
                        <div class="py-2 text-left">
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="finished_at" name="finished_at" type="date" required>
                        </div>
                    </div>
                    <div class="row-start-2">
                        <label class="block mb-2 text-sm text-gray-00" for="origin">Tahun Aktif</label>
                        <div class="py-2 text-left">
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="active_at" name="active_at" type="number" required>
                        </div>
                    </div>
                    <div class="">
                        <label class="block mb-2 text-sm text-gray-00" for="status">Status</label>
                        <div class="py-2 text-left">
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="status" id="status" required>
                                <option value="on going">On Going</option>
                                <option value="queued">Waiting List</option>
                                <option value="on hold">On Hold</option>
                                <option value="finished">Finished</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap justify-center mt-12">
                    <input type="submit" value="{{ __('Submit') }}" class="block text-center text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-48">
                </div>        
            </form>

        </section>
    </div>
</main>
@endsection