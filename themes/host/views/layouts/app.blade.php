<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js', 'themes/host') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css', 'themes/host') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons">

    {{-- sidebar --}}
    <style>
        #sideBar {
            transition: all 0.5s;
        }
    
        .is-close {
            text-align: center;
        }
        .is-close .hidden-item {
            display: none;
        }
    </style>

    {{-- input --}}
    {{-- <style>
        label {
          top: 0%;
          transform: translateY(-50%);
          font-size: 11px;
          color: rgba(37, 99, 235, 1);
        }
        .empty input:not(:focus) + label {
          top: 50%;
          transform: translateY(-50%);
          font-size: 14px;
        }
        input:not(:focus) + label {
          color: rgba(70, 70, 70, 1);
        }
        input {
          border-width: 1px;
        }
        input:focus {
          outline: none;
          border-color: rgba(37, 99, 235, 1);
        }
    </style> --}}
</head>
<body class="h-screen font-sans antialiased leading-none bg-gray-100 sm:overflow-hidden" x-data="{isClose: false}">
    <header class="bg-white shadow w-full h-14">
        <div class="flex mx-auto py-4 px-6 sm:px-3">
            <span class="ml-6 hover:text-purple-500">
                <i @click="isClose=!isClose" class="mr-3 cursor-pointer fi-rr-menu-burger"></i>
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
                    <a href="{{ route('administrator.dashboard') }}" class="w-full flex justify-between items-center py-3 px-6 text-gray-100 cursor-pointer hover:bg-gray-700 hover:text-gray-100 focus:outline-none">
                        <span class="flex items-center">
                            <i class="material-icons">home</i>
                            <span class="mx-4">Dashboard</span>
                        </span>
                    </a>
                </div>
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex justify-between items-center py-3 px-6 text-gray-100 cursor-pointer hover:bg-gray-700 hover:text-gray-100 focus:outline-none">
                        <span class="flex items-center">
                            <i class="material-icons">person_pin</i>
                            <span class="mx-4">Tenants</span>
                        </span>

                        <span>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path x-show="! open" d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"></path>
                                <path x-show="open" d="M19 9L12 16L5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </span>
                    </button>

                    <div x-show="open" class="bg-gray-700">
                        <a class="py-2 pl-14 block text-sm text-gray-100 hover:bg-gray-600 hover:text-white" href="{{ route('tenant.create') }}">
                            <span class="flex">
                                <i class="material-icons mr-2">person_add_alt</i>
                                New Tenant
                            </span>
                        </a>
                    </div>
                </div>
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex justify-between items-center py-3 px-6 text-gray-100 cursor-pointer hover:bg-gray-700 hover:text-gray-100 focus:outline-none">
                        <span class="flex items-center">
                            <i class="material-icons">ios_share</i>
                            <span class="mx-4">ASPAK</span>
                        </span>

                        <span>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path x-show="! open" d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"></path>
                                <path x-show="open" d="M19 9L12 16L5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </span>
                    </button>

                    <div x-show="open" class="bg-gray-700">
                        <a class="py-2 pl-14 block text-sm text-gray-100 hover:bg-gray-600 hover:text-white" href="{{ route('tenant.create') }}">
                            <span class="flex">
                                <i class="material-icons mr-2">star_border</i>
                                Map Code
                            </span>
                        </a>
                    </div>
                    <div x-show="open" class="bg-gray-700">
                        <a class="py-2 pl-14 block text-sm text-gray-100 hover:bg-gray-600 hover:text-white" href="{{ route('tenant.create') }}">
                            <span class="flex">
                                <i class="material-icons mr-2">queue</i>
                                Queue Sync
                            </span>
                        </a>
                    </div>
                </div>
                <div>
                    <form method="post" action="{{ route('administrator.logout') }}" class="w-full flex justify-between items-center py-3 px-6 text-gray-100 cursor-pointer hover:bg-gray-700 hover:text-gray-100 focus:outline-none">
                        @csrf
                        <span id="logoutBtn" class="flex items-center">
                            <i class="material-icons">power_settings_new</i>
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

            {{-- <div class="flex justify-center mt-auto mb-6 text-xs text-gray-100">
                <span class="mx-aut text-center">
                    Provided by 
                    <br>
                    Global Promedika Services
                </span>
            </div> --}}
        </aside>
        @yield('content')
    </div>
</body>
</html>
