@extends('layouts.app')

@section('content')

<main class="mx-auto px-2 sm:container sm:mx-auto mt-6 overflow-scroll">
    <div class="w-full sm:px-6">
        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="flex flex-col break-words bg-white sm:border-1 sm:shadow overflow-scroll">
            <header class="px-6 py-5 font-semibold text-gray-700 bg-gray-200 sm:py-6 sm:px-8">
                Update Nomenclature
            </header>
            <div class="w-full p-3">
                <form class="w-full" enctype="multipart/form-data" method="POST"
                    action="{{ route('nomenclature.update', ['nomenclature' => $nomenclature->id]) }}">
                    @csrf
                    <div class="w-3/5 sm:px-20 mx-auto">
                        <div class="flex flex-col px-2 mb-4">
                            <label for="name" class="input-label text-base mb-2">Nama</label>
                            <label class="input-field inline-flex items-baseline border-none shadow-md bg-gray-100 py-2 px-6 ml-2">
                                <div class="flex-1 leading-none">
                                    <input value="{{ $nomenclature->standard_name }}" id="name" type="text" class="bg-gray-100 w-full px-2 py-1 outline-none border-none focus:ring-0 text-sm" name="standard_name" placeholder="Name">
                                </div>
                            </label>
                        </div>
                        <div class="flex flex-col px-2 mb-4">
                            <label for="code" class="input-label text-base mb-2">Kode ASPAK</label>
                            <label class="input-field inline-flex items-baseline border-none shadow-md bg-gray-100 py-2 px-6 ml-2">
                                <div class="flex-1 leading-none">
                                    <input value="{{ $nomenclature->aspak_code }}" id="code" type="tel" class="bg-gray-100 w-full px-2 py-1 outline-none border-none focus:ring-0 text-sm" name="aspak_code" placeholder="Kode ASPAK">
                                </div>
                            </label>
                        </div>

                        <div class="flex flex-col px-2 mb-4">
                            <label for="code" class="input-label text-base mb-2">Risk Level</label>
                            <label class="input-field inline-flex items-baseline border-none shadow-md bg-gray-100 py-2 px-6 ml-2">
                                <div class="flex-1 leading-none">
                                    <select class="bg-gray-100 w-full px-2 py-1 outline-none border-none focus:ring-0 text-sm" name="risk_level">
                                        <option value="{{ $nomenclature->risk_level }}">{{ $nomenclature->risk_level }}</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    {{-- <input id="code" type="tel" class="bg-gray-100 w-full px-2 py-1 outline-none border-none focus:ring-0 text-sm" name="risk_level" placeholder="Risk Level"> --}}
                                </div>
                            </label>
                        </div>

                        <div class="flex flex-col px-2 mb-4">
                            <label for="address" class="input-label text-base mb-2">Keyword 
                                <span id="keyword" class="material-icons">
                                    info
                                </span>
                            </label>
                            <label class="input-field inline-flex items-baseline border-none shadow-md bg-gray-100 py-2 px-6 ml-2">
                                <div class="flex-1 leading-none">
                                    <textarea id="address" type="text" class="bg-gray-100 w-full px-2 py-1 outline-none border-none focus:ring-0 text-sm" name="keywords" placeholder="Keyword">{{ $nomenclature->keywords }}</textarea>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="flex flex-wrap justify-center w-full sm:w-56 mx-auto">
                        <input type="submit" value="{{ __('Update') }}" class="block text-center text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-80">
                    </div>        
                </form>
            </div>
        </section>
    </div>
</main>

<script>
    $(document).ready(function () {
        tippy("#keyword", {
            content: "Tambahkan nama lain dari alat ini, pisahkan dengan ';'"
        })
    })
</script>
@endsection