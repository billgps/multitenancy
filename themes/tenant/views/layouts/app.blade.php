<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js', 'themes/tenant') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css', 'themes/tenant') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

    <style>
        .modal {
          transition: opacity 0.25s ease;
        }
        body.modal-active {
          overflow-x: hidden;
          overflow-y: visible !important;
        }
        table.dataTable.no-footer {
            border-bottom: 0 !important;
        }
        #example_wrapper {
            display: none !important;
        }
    </style>

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <style>
        table.dataTable thead th {
            border-bottom: 0px !important;
        }
        
        table.dataTable tfoot th {
            border-top: 0px !important;
        }

        table.dataTable.no-footer {
            border-bottom: 0px !important;
        }
    </style>

    <style>
        .modal {
            transition: opacity 0.25s ease;
        }
        body.modal-active {
            overflow-x: hidden;
            overflow-y: visible !important;
        }
        table.dataTable.no-footer {
            border-bottom: 0 !important;
        }
        #example_wrapper {
            display: none !important;
        }
    </style>
</head>
<body class="h-screen font-sans antialiased leading-none bg-gray-200 sm:overflow-auto" x-data="{isClose: false}">
    @if ($errors->any())
        <div class="flex justify-center items-center m-1 font-medium py-1 px-2 rounded-md text-green-100 bg-red-700 border border-red-700 ">
            <div slot="avatar" class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon w-5 h-5 mx-2">
                    <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="text-xl font-normal  max-w-full flex-initial">
                <div class="py-2 ml-3">
                    @foreach ($errors->all() as $error)
                    <div class="text-xs font-base">{{ $error }}</div>
                    @endforeach
                </div>
            </div>
            <div class="flex flex-auto flex-row-reverse">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-red-400 rounded-full w-5 h-5 ml-2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </div>
            </div>
        </div>
    @elseif (session()->has('success'))
        <div class="flex justify-center items-center m-1 font-medium py-1 px-2 rounded-md text-green-100 bg-green-700 border border-green-700 ">
            <div slot="avatar" class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle w-5 h-5 mx-2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="text-xl font-normal  max-w-full flex-initial">
                <div class="py-2 ml-3">
                    <div class="text-xs font-base">{{ session()->get('success') }}</div>
                </div>
            </div>
            <div class="flex flex-auto flex-row-reverse">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-green-400 rounded-full w-5 h-5 ml-2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </div>
            </div>
        </div>      
    @endif
    <header class="bg-gray-100 text-gray-600 shadow-lg w-full h-14">
        <div class="flex mx-auto items-center py-3 px-6 sm:px-3">
            <div class="flex">
                <a href="#">
                    <img class="h-7" src="{{ asset('gps_logo.png') }}">
                </a>
            </div>
            <span class="ml-6 hover:text-purple-500">
                <i @click="isClose=!isClose" class="mr-3 cursor-pointer fas fa-bars"></i>
            </span>
            Dashboard
            <div class="ml-auto mr-6">
                {{ Auth::user()->name }}
            </div>
        </div>
    </header>
    <div id="app" class="flex w-full h-full overflow-auto">
        <aside id="sideBar" class="flex flex-col sticky top-0 w-64 h-screen bg-gray-800" :class="{'is-close': isClose, 'hidden': isClose, 'w-60': !isClose}">
            <nav class="pt-12 text-sm">
                <div>
                    <a href="{{ route('user.dashboard') }}" class="w-full flex justify-between items-center py-3 px-6 text-gray-100 cursor-pointer hover:bg-gray-700 hover:text-gray-100 focus:outline-none">
                        <span class="flex items-center">
                            <i class="fas fa-home"></i>
                            <span class="mx-4">Dashboard</span>
                        </span>
                    </a>
                </div>
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex justify-between items-center py-3 px-6 text-gray-100 cursor-pointer hover:bg-gray-700 hover:text-gray-100 focus:outline-none">
                        <span class="flex items-center">
                            <i class="fas fa-list fa-fw"></i>
                            <span class="mx-4">Inventori</span>
                        </span>

                        <span>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path x-show="! open" d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"></path>
                                <path x-show="open" d="M19 9L12 16L5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </span>
                    </button>

                    <div x-show="open" class="bg-gray-900">
                        <a class="py-2 px-16 block text-xs text-gray-100 hover:bg-gray-600 hover:text-white" href="{{ route('inventory.index') }}">
                            Data Inventaris
                        </a>
                        <a class="py-2 px-16 block text-xs text-gray-100 hover:bg-gray-600 hover:text-white" href="{{ route('asset.index') }}">
                            Data Aset
                        </a>
                        <a class="py-2 px-16 block text-xs text-gray-100 hover:bg-gray-600 hover:text-white" href="{{ route('consumable.index') }}">
                            Data Consumable
                        </a>
                        <a class="py-2 px-16 block text-xs text-gray-100 hover:bg-gray-600 hover:text-white" href="{{ route('record.index') }}">
                            Riwayat Kalibrasi
                        </a>
                        <a class="py-2 px-16 block text-xs text-gray-100 hover:bg-gray-600 hover:text-white" href="{{ route('condition.index') }}">
                            Riwayat Kondisi
                        </a>
                        <a class="py-2 px-16 block text-xs text-gray-100 hover:bg-gray-600 hover:text-white" href="{{ route('maintenance.index') }}">
                            Riwayat Maintenance
                        </a>
                    </div>
                </div>
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex justify-between items-center py-3 px-6 text-gray-100 cursor-pointer hover:bg-gray-700 hover:text-gray-100 focus:outline-none">
                        <span class="flex items-center">
                            <i class="fas fa-pencil-alt"></i>
                            <span class="mx-4">Administrasi</span>
                        </span>

                        <span>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path x-show="! open" d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"></path>
                                <path x-show="open" d="M19 9L12 16L5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </span>
                    </button>

                    <div x-show="open" class="bg-gray-900">
                        <a class="py-2 px-16 block text-xs text-gray-100 hover:bg-gray-600 hover:text-white" href="{{ route('device.index') }}">
                            Nama Alat
                        </a>
                        <a class="py-2 px-16 block text-xs text-gray-100 hover:bg-gray-600 hover:text-white" href="{{ route('room.index') }}">
                            Ruangan
                        </a>
                        <a class="py-2 px-16 block text-xs text-gray-100 hover:bg-gray-600 hover:text-white" href="{{ route('brand.index') }}">
                            Merk
                        </a>
                        <a class="py-2 px-16 block text-xs text-gray-100 hover:bg-gray-600 hover:text-white" href="{{ route('identity.index') }}">
                            Tipe Alat
                        </a>
                    </div>
                </div>
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex justify-between items-center py-3 px-6 text-gray-100 cursor-pointer hover:bg-gray-700 hover:text-gray-100 focus:outline-none">
                        <span class="flex items-center">
                            <i class="fas fa-exclamation"></i>
                            <span class="mx-4">Komplain</span>
                        </span>

                        <span>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path x-show="! open" d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"></path>
                                <path x-show="open" d="M19 9L12 16L5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </span>
                    </button>

                    <div x-show="open" class="bg-gray-900">
                        <a class="py-2 px-16 block text-xs text-gray-100 hover:bg-gray-600 hover:text-white" href="{{ route('complain.index') }}">
                            Komplain
                        </a>
                        {{-- <a class="py-2 px-16 block text-xs text-gray-100 hover:bg-gray-600 hover:text-white" href="">
                            Respon
                        </a> --}}
                    </div>
                </div>
                <div>
                    <form method="post" action="{{ route('user.logout') }}" class="w-full flex justify-between items-center py-3 px-6 text-gray-100 cursor-pointer hover:bg-gray-700 hover:text-gray-100 focus:outline-none">
                        @csrf
                        <span id="logoutBtn" class="flex items-center">
                            <i class="fas fa-power-off"></i>
                            <span class="mx-4">Logout</span>
                        </span>
                        <script>
                            $('#logoutBtn').on('click', function(e) {
                                e.preventDefault();
                                $(this).closest('form').submit();
                            });
                        </script>
                    </form>
                </div>
            </nav>

            <div class="flex justify-center mt-auto mb-6 text-xs text-gray-100">
                <span class="mx-aut text-center">
                    Provided by 
                    <br>
                    Global Promedika Services
                </span>
            </div>
        </aside>
        @yield('content')
    </div>
</body>
</html>
