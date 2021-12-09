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
                Create New Tenant
            </header>
            <div class="w-full sm:p-6">
                <form class="w-full p-12" enctype="multipart/form-data" method="POST"
                    action="{{ route('tenant.store') }}">
                    @csrf
                    <div class="w-1/2 sm:px-20 mx-auto">
                        <div class="flex flex-col px-2 mb-4">
                            <label for="name" class="input-label text-base mb-2">Name</label>
                            <label class="input-field inline-flex items-baseline border-none shadow-md bg-gray-100 py-2 px-6 ml-2">
                                <div class="flex-1 leading-none">
                                    <input id="name" type="text" class="bg-gray-100 w-full px-2 py-1 outline-none border-none focus:ring-0 text-sm" name="name" placeholder="Name">
                                </div>
                                {{-- <span class="flex-none text-dusty-blue-darker select-none leading-none mx-2">.localhost</span> --}}
                            </label>
                        </div>
                        <div class="flex flex-col px-2 mb-4">
                            <label for="code" class="input-label text-base mb-2">Code</label>
                            <label class="input-field inline-flex items-baseline border-none shadow-md bg-gray-100 py-2 px-6 ml-2">
                                <div class="flex-1 leading-none">
                                    <input id="code" type="tel" class="bg-gray-100 w-full px-2 py-1 outline-none border-none focus:ring-0 text-sm" name="code" placeholder="Code">
                                </div>
                                {{-- <span class="flex-none text-dusty-blue-darker select-none leading-none mx-2">.localhost</span> --}}
                            </label>
                        </div>
                        <div class="flex flex-col px-2 mb-4">
                            <label for="code" class="input-label text-base mb-2">Code ASPAK</label>
                            <label class="input-field inline-flex items-baseline border-none shadow-md bg-gray-100 py-2 px-6 ml-2">
                                <div class="flex-1 leading-none">
                                    <input id="code" type="tel" class="bg-gray-100 w-full px-2 py-1 outline-none border-none focus:ring-0 text-sm" name="public_code" placeholder="Code ASPAK">
                                </div>
                                {{-- <span class="flex-none text-dusty-blue-darker select-none leading-none mx-2">.localhost</span> --}}
                            </label>
                        </div>
                        <div class="flex flex-col px-2 mb-4">
                            <label for="address" class="input-label text-base mb-2">Address</label>
                            <label class="input-field inline-flex items-baseline border-none shadow-md bg-gray-100 py-2 px-6 ml-2">
                                <div class="flex-1 leading-none">
                                    <textarea id="address" type="text" class="bg-gray-100 w-full px-2 py-1 outline-none border-none focus:ring-0 text-sm" name="address" placeholder="Address"></textarea>
                                </div>
                                {{-- <span class="flex-none text-dusty-blue-darker select-none leading-none mx-2">.localhost</span> --}}
                            </label>
                        </div>
                        <div class="flex flex-col px-2 mb-4">
                            <label for="database" class="input-label text-base mb-2">Database</label>
                            <label class="input-field inline-flex items-baseline border-none shadow-md bg-gray-100 py-2 px-6 ml-2">
                                <div class="flex-1 leading-none">
                                    <input id="database" type="text" class="bg-gray-100 w-full px-2 py-1 outline-none border-none focus:ring-0 text-sm" name="database" placeholder="Database">
                                </div>
                                {{-- <span class="flex-none text-dusty-blue-darker select-none leading-none mx-2">.localhost</span> --}}
                            </label>
                        </div>
                        <div class="flex flex-col px-2 mb-4">
                            <label for="domain" class="input-label text-base mb-2">Domain</label>
                            <div>
                                <label class="input-field inline-flex items-baseline border-none shadow-md bg-gray-100 py-2 px-6 ml-2">
                                    <div class="flex-1 leading-none">
                                        <input id="domain" type="text" class="bg-gray-100 w-full px-2 py-1 outline-none border-none focus:ring-0 text-sm" name="domain" placeholder="Domain">
                                    </div>
                                    <span class="flex-none text-dusty-blue-darker select-none leading-none mx-2">.localhost</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex flex-col px-2 mb-4">
                            <label for="vendor_id" class="input-label text-base mb-2">Logo</label>
                            <label class="input-field inline-flex items-baseline border-none shadow-md bg-gray-100 py-2 px-6 ml-2">
                                <div class="flex-1 leading-none">
                                    <input id="vendor_id" type="file" accept="image/*" class="bg-gray-100 w-full px-2 py-1 outline-none border-none focus:ring-0 text-sm" name="vendor_id">
                                </div>
                                {{-- <span class="flex-none text-dusty-blue-darker select-none leading-none mx-2">.localhost</span> --}}
                            </label>
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