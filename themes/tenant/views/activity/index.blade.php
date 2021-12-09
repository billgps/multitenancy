@extends('layouts.app')

@section('content')
<main class="sm:container sm:mx-auto sm:mt-6 overflow-y-auto">
    <div class="w-full sm:px-6">

        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="sm:grid sm:grid-cols-6 sm:gap-2 break-words">
            <div class="col-span-6 px-2 sm:px-6 md:px-2 py-3 my-3">
                <div class="grid grid-cols-12 gap-3">
                    <!-- Meta Column -->
                    <div class="col-span-0 sm:col-span-2 items-center text-center flex">        
                        <!-- Answer Counts -->
                        <a href="#" class="text-green-500 flex flex-col mx-auto py-1 w-4/5 2lg:w-3/5">
                            <div class="inline-block font-medium text-5xl">
                                12
                            </div>
    
                            <div class="inline-block font-medium mx-1 text-xs">
                                Entries
                            </div>
                        </a>
                    </div>
        
                    <!-- Summary Column -->
                    <div class="col-span-12 sm:col-start-3 sm:col-end-13 px-3 sm:px-0">
                        <div class="flex justify-between items-center">
                            <span class="font-light text-gray-600">
                                created_at
                            </span>
                            <span class="flex mr-2">
                                <div class="flex item-center justify-center">
                                    @if (Auth::user()->role < 2)
                                        <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <a href="">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    @endif 
                                </div>
                            </span>
                        </div>
        
                        <div class="mt-2">
                            <span>
                                <a href="{{ route('user.dashboard') }}" class="sm:text-sm md:text-md lg:text-lg text-gray-700 font-bold hover:underline">
                                    customer name
                                </a>

                                <a href="#" class="inline-block rounded-full text-white 
                                    bg-red-400 hover:bg-red-500 duration-300 
                                    text-xs font-bold 
                                    mx-2 mb-2 px-2 md:px-4 py-1 
                                    opacity-90 hover:opacity-100">
                                    Caching
                                </a>
                            </span>
        
                            <p class="mt-1 text-gray-600 text-xs">
                                Nomor PO : 
                            </p>
                            <p class="mt-1 text-gray-600 text-xs">
                                Tanggal Mulai Pekerjaan : 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-6 h-12 flex items-center py-2 px-4 bg-gray-200" x-data="{ dropdownOpen: false }">
                @if (Auth::user()->role < 2)
                    <a class="mx-2 text-green-600 hover:text-gray-400" href="{{ route('condition.create') }}">
                        <i class="fas fa-plus"></i>
                    </a>
                @endif   
            </div>
            <div class="flex flex-col sm:col-span-6 break-words bg-white sm:border-1">

                <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                    {{ __('Riwayat Kegiatan Kalibrasi') }}
                </header>   
                <div class="w-full px-6 py-3">
                    <div class="col-span-6 bg-gray-100 mx-auto border-gray-500 border rounded-sm text-gray-700 mb-0.5 h-30">
                        <div class="flex p-3 border-l-8 border-yellow-600">
                        <div class="space-y-1 border-r-2 pr-3">
                                <div class="text-sm leading-5 font-semibold"><span class="text-xs leading-4 font-normal text-gray-500"> Release #</span> LTC08762304</div>
                                <div class="text-sm leading-5 font-semibold"><span class="text-xs leading-4 font-normal text-gray-500 pr"> BOL #</span> 10937</div>
                                <div class="text-sm leading-5 font-semibold">JUN 14. 9:30 PM</div>
                        </div>
                        <div class="flex-1">
                                <div class="ml-3 space-y-1 border-r-2 pr-3">
                                    <div class="text-base leading-6 font-normal">KROGER MEMPHIS</div>
                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Carrier</span> PAPER TRANSPORT INC.</div>
                                    <div class="text-sm leading-4 font-normal"><span class="text-xs leading-4 font-normal text-gray-500"> Destination</span> WestRock Jacksonville - 9469 Eastport Rd, Jacksonville, FL 32218</div>
                                </div>
                        </div>
                        <div class="border-r-2 pr-3">
                                <div >
                                    <div class="ml-3 my-3 border-gray-200 border-2 bg-gray-300 p-1">
                                        <div class="uppercase text-xs leading-4 font-medium">Trailer</div>
                                        <div class="text-center text-sm leading-4 font-semibold text-gray-800">89732</div>
                                    </div>
                                </div>
                        </div>
                        <div>
                                <div class="ml-3 my-5 bg-yellow-600 p-1 w-20">
                                    <div class="uppercase text-xs leading-4 font-semibold text-center text-yellow-100">Loaded</div>
                                </div>
                        </div>
                        <div>
                                <button class="text-gray-100 rounded-sm my-5 ml-2 focus:outline-none bg-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                        </div>
                        </div>
                    </div>
                    <div class="mt-3 w-full h-20 flex justify-center text-sm p-2" id="page"></div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection