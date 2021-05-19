@extends('layouts.app')

@section('content')
<main class="mx-auto px-2 sm:container sm:mx-auto mt-6">
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="flex flex-col break-words bg-white sm:border-1 sm:shadow">
            <header class="px-6 py-5 font-semibold text-gray-700 bg-gray-200 sm:py-6 sm:px-8">
                Create New Tenant
            </header>
            <div class="w-full sm:p-6">
                <form class="w-full space-y-6 sm:px-10 sm:space-y-8" method="POST"
                    action="#">
                    @csrf
                    <div class="w-1/2 sm:px-20 mx-auto">
                        <div class="flex flex-col px-2 mb-4">
                            <label for="name" class="input-label text-base mb-2">Name</label>
                            <label class="input-field inline-flex items-baseline border-none shadow-md bg-gray-100 py-2 px-6 ml-2">
                                <div class="flex-1 leading-none">
                                    <input readonly id="name" type="text" class="bg-gray-100 w-full px-2 py-1 outline-none border-none focus:ring-0 text-sm" name="name" placeholder="Name" value="{{ $tenant->name }}">
                                </div>
                                {{-- <span class="flex-none text-dusty-blue-darker select-none leading-none mx-2">.localhost</span> --}}
                            </label>
                        </div>
                        <div class="flex flex-col px-2 mb-4">
                            <label for="database" class="input-label text-base mb-2">Database</label>
                            <label class="input-field inline-flex items-baseline border-none shadow-md bg-gray-100 py-2 px-6 ml-2">
                                <div class="flex-1 leading-none">
                                    <input disabled id="database" type="text" class="bg-gray-100 w-full px-2 py-1 outline-none border-none focus:ring-0 text-sm" name="database" placeholder="Database" value="{{ $tenant->database }}">
                                </div>
                                {{-- <span class="flex-none text-dusty-blue-darker select-none leading-none mx-2">.localhost</span> --}}
                            </label>
                        </div>
                        <div class="flex flex-col px-2 mb-4">
                            <label for="domain" class="input-label text-base mb-2">Domain</label>
                            <div>
                                <label class="input-field inline-flex items-baseline border-none shadow-md bg-gray-100 py-2 px-6 ml-2">
                                    <div class="flex-1 leading-none">
                                        <input readonly id="domain" type="text" class="bg-gray-100 w-full px-2 py-1 outline-none border-none focus:ring-0 text-sm" name="domain" placeholder="Domain" value="{{ substr($tenant->domain, 0, -10) }}">
                                    </div>
                                    <span class="flex-none text-dusty-blue-darker select-none leading-none mx-2">.localhost</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap justify-center w-full sm:w-56 mx-auto">
                        <input type="submit" value="{{ __('Add') }}" class="block text-center text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-80">
                    </div>        
                </form>
            </div>
        </section>
    </div>
</main>
@endsection