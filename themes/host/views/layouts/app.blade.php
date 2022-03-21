<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="refresh" content="time; URL=new_url" />

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ url('favicon.png') }}">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js', 'themes/host') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css', 'themes/host') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">

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
        
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
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
<body class="h-screen font-sans antialiased leading-none bg-gray-200 sm:overflow-auto" x-data="{isClose: false, notification: false}">
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
    @elseif (session()->has('error'))
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
                    <div class="text-xs font-base">{{ session()->get('error') }}</div>
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
    @endif
    <header class="bg-white shadow w-full h-14">
        <div class="flex mx-auto py-4 px-6 sm:px-3">
            <span class="ml-6 hover:text-purple-500">
                <i @click="isClose=!isClose" class="mr-3 cursor-pointer fi-rr-menu-burger"></i>
            </span>
            Dashboard
            <div class="ml-auto mr-6 flex">
                <span class="mx-2 lg:mx-6">
                    <button onclick="markAsRead()" @click="notification = !notification" class="relative z-10 hover:text-purple-500 focus:outline-none">
                        @if(Session::get('notifications'))
                            <span id="badge" class="badge pl-1 bg-red-800 rounded-full text-center text-white text-xs mr-1">
                                @if (Session::get('notifications')->count() < 99)
                                    {{ Session::get('notifications')->count() }}
                                @else
                                    99+
                                @endif
                            </span>
                        @endif
                        <i class="fas fa-bell"></i>
                    </button>
                    <div x-show="notification" @click="notification = false" class="fixed inset-0 h-full w-full z-10"></div>
    
                    <div x-show="notification" class="absolute top-9 right-28 mt-2 py-2 px-2 w-64 h-96 overflow-auto bg-white rounded-md shadow-xl z-20">
                        @if(Session::get('notifications'))
                            @foreach (Session::get('notifications') as $notification)
                                <div class="flex flex-col">
                                    <div class="text-sm mt-3">
                                        {{ $notification->data['title'] }}
                                    </div>
                                    <div class="text-xs mt-1">
                                        {{ $notification->data['message'] }}
                                    </div>
                                    <div class="flex justify-center mt-1 py-1 w-full hover:text-purple-500 border-b border-gray-500 border-opacity-60">
                                        <a href="{{ $notification->data['url'] }}">
                                            <i class="fas fa-eye fa-xs"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-sm w-full flex justify-center">
                                No new notifications
                            </div>
                        @endif

                        <div class="w-full flex mt-6 justify-center text-xs hover:text-purple-500">
                            <a href="">
                                See all
                            </a>
                        </div>
                    </div>
                </span>

                <script>
                    function markAsRead() {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('notification.ajax') }}",
                            success: function (data) {
                                console.log(data);
                            },
                            error: function (error) {
                                console.log(error)
                            }
                        })
                    }
                </script>

                <span class="hidden lg:block">
                    {{ Auth::user()->name }}
                </span>
            </div>
        </div>
    </header>
    <div id="app" class="flex w-full h-full overflow-auto no-scrollbar">
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
                <div>
                    <a href="{{ route('nomenclature.index') }}" class="w-full flex justify-between items-center py-3 px-6 text-gray-100 cursor-pointer hover:bg-gray-700 hover:text-gray-100 focus:outline-none">
                        <span class="flex items-center">
                            <i class="material-icons">screenshot_monitor</i>
                            <span class="mx-4">Nomenklatur</span>
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

                    {{-- <div x-show="open" class="bg-gray-700">
                        <a class="py-2 pl-14 block text-sm text-gray-100 hover:bg-gray-600 hover:text-white" href="{{ route('tenant.create') }}">
                            <span class="flex">
                                <i class="material-icons mr-2">star_border</i>
                                Map Code
                            </span>
                        </a>
                    </div> --}}
                    <div x-show="open" class="bg-gray-700">
                        <a class="py-2 pl-14 block text-sm text-gray-100 hover:bg-gray-600 hover:text-white" href="{{ route('queue.index') }}">
                            <span class="flex">
                                <i class="material-icons mr-2">queue</i>
                                Queue
                            </span>
                        </a>
                    </div>
                    <div x-show="open" class="bg-gray-700">
                        <a class="py-2 pl-14 block text-sm text-gray-100 hover:bg-gray-600 hover:text-white" href="{{ route('log.index') }}">
                            <span class="flex">
                                <i class="material-icons mr-2">history</i>
                                Log
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
