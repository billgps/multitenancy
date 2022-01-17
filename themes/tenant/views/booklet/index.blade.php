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
            {{-- <div class="col-span-6 h-12 flex items-center py-2 px-4 bg-gray-200" x-data="{ dropdownOpen: false }">
                @if (Auth::user()->role < 2)
                    <a class="mx-2 text-green-600 hover:text-gray-400" href="{{ route('maintenance.create') }}">
                        <i class="fas fa-plus"></i>
                    </a>
                @endif
                @if (Auth::user()->role < 1)
                    <button onclick="toggleModal(this, 'import-toggle', 'import-modal')" class="mx-2 text-blue-600 hover:text-gray-400 modal-open import-toggle">
                        <i class="fas fa-file-upload"></i>
                    </button>    
                @endif    
                <div class="ml-auto my-auto flex text-xs">
                    <input class="h-8 rounded-r-none text-xs text-gray-800 w-full px-2 rounded-md focus:ring-0 border-none" id="search_" type="text" placeholder="Search..." name="search" />
                    <button type="button" class="h-8 rounded-l-none w-20 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:text-gray-800 hover:bg-gray-400 active:bg-gray-900 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">
                        Search
                    </button>
                </div>
            </div> --}}
            <div class="flex flex-col sm:col-span-6 break-words bg-white sm:border-1">

                <header class="px-6 py-5 font-semibold text-gray-700 sm:py-6 sm:px-8">
                    {{ __('Booklet Tersedia') }}
                </header>   
                <div class="w-full px-6 py-3 grid grid-cols-4">
                    @foreach ($chunks as $i => $ch)
                        <div class="w-full px-4 my-3">
                            <div class="bg-white rounded-lg overflow-hidden mb-10m shadow-lg">
                                <div class="w-full text-center flex justify-center">
                                    <img
                                        src="{{ asset('/booklet_icon.jpg') }}"
                                        alt="image"
                                        class="w-32 h-32"
                                    />
                                </div>
                                <div class="p-6 text-center">
                                    <h3 class="font-semibold mb-3 text-lg">
                                        Booklet Serie {{ $i + 1 }}
                                    </h3>
                                    <p class="text-xs text-body-color text-left leading-relaxed mb-7">
                                        Berisi data inventory dari nomor ID {{ $ch->first()->id }} - {{ $ch->last()->id }}
                                    </p>
                                    <div class="w-full flex justify-center text-center">
                                        <a href="{{ route('booklet.generate', ['offset' => $i]) }}">
                                            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- <script>
                        $(document).ready(function() {
                            var table = $('#record').DataTable({
                                "pageLength": 15,
                                "ordering": true,
                                "info":     false,
                                "lengthChange": false,
                                "searching": true,
                                "paging":   true,
                                columnDefs: [
                                    { orderable: false, targets: -1 }
                                ],
                                "dom": 'lrtip'
                            });

                            drawPaginate()
            
                            $('#search_').keyup(function(){
                                table.search($(this).val()).draw()
                            })
            
                            $("#page").append($(".dataTables_paginate"));
            
                            $('#record').on( 'draw.dt', function () {
                                drawPaginate()
                            })

                            function drawPaginate() {
                                let prev = document.getElementsByClassName('previous')[0]
                                prev.classList.add('mr-3', 'cursor-pointer', 'hover:text-purple-500')
                                prev.innerHTML = '<i class="fas fa-chevron-left"></i>'
                
                                let next = document.getElementsByClassName('next')[0]
                                next.classList.add('ml-3', 'cursor-pointer', 'hover:text-purple-500')
                                next.innerHTML = '<i class="fas fa-chevron-right"></i>'
                
                                let page = document.getElementById('record_paginate').getElementsByTagName('span')[0].getElementsByClassName('paginate_button')
                                for (let i = 0; i < page.length; i++) {
                                    if (page[i].classList.contains('current')) {
                                        page[i].classList.add('mx-1', 'text-purple-500')                    
                                    }
                                    page[i].classList.add('mx-1', 'cursor-pointer', 'hover:text-purple-500')                    
                                }
                            }
                        })
                    </script> --}}
                    <div class="mt-3 w-full h-20 flex justify-center text-sm p-2" id="page"></div>
                </div>
            </div>
        </section>
    </div>
</main>

@endsection