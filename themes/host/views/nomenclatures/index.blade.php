@extends('layouts.app')

@section('content')
<main class="sm:container sm:mx-auto mt-6">
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="flex flex-col break-words bg-white sm:border-1 sm:shadow">
            <header class="px-6 py-5 font-semibold text-gray-700 bg-gray-200 sm:py-6 sm:px-8">
                Nomenklatur Alat
            </header>
            <div class="w-full sm:p-6 overflow-x-scroll sm:overflow-x-auto">
                <table id="tenants" class="min-w-max w-full table-auto text-center">
                    <thead class="shadow">
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6">ID</th>
                            <th class="py-3 px-6">Nama Alat</th>
                            <th class="py-3 px-6">Kode ASPAK</th>
                            <th class="py-3 px-6">Risk Level</th>
                            <th class="py-3 px-6">Created at</th>
                            <th class="py-3 px-6">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($nomenclatures as $nom)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6">
                                    {{ $nom->id }}
                                </td>
                                <td class="py-3 px-6">
                                    {{ $nom->standard_name }}
                                </td>
                                <td class="py-3 px-6">
                                    {{ $nom->aspak_code }}
                                </td>
                                <td class="py-3 px-6">
                                    {{ $nom->risk_level }}
                                </td>
                                <td class="py-3 px-6">
                                    {{ $nom->created_at }}
                                </td>
                                <td class="py-3 px-6 text-center">
                                    {{-- <div class="flex item-center justify-center">
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <a href="http://{{ $tenant->domain }}" target="blank_">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <a href="{{ route('tenant.show', ['tenant' => $tenant->id]) }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <a href="{{ route('tenant.delete', ['tenant' => $tenant->id]) }}"
                                                onclick="return confirm('Are you sure you want to delete this tenant? Deleted data cannot be recovered!')">
                                                <i class="delete fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </div> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</main>
@endsection
