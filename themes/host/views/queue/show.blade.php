@extends('layouts.app')

@section('content')
<style>
    /* CHECKBOX TOGGLE SWITCH */
    /* @apply rules for documentation, these do not work as inline style */
    .toggle-checkbox:checked {
      @apply: right-0 border-green-400;
      right: 0;
      border-color: #68D391;
    }
    .toggle-checkbox:checked + .toggle-label {
      @apply: bg-green-400;
      background-color: #68D391;
    }
</style>

<main class="mx-auto px-2 sm:container sm:mx-auto mt-6 overflow-scroll">
    <div class="w-full sm:px-6">
        @if (session('status'))
            <div class="px-3 py-4 mb-4 text-sm text-green-700 bg-green-100 border border-t-8 border-green-600 rounded" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="flex flex-col break-words bg-white sm:border-1 sm:shadow overflow-auto">
            <header class="px-6 py-5 font-semibold text-gray-700 bg-gray-200 sm:py-6 sm:px-8">
                Detail Queue
            </header>
            <div class="w-full p-3">
                <form class="w-full" enctype="multipart/form-data" method="POST"
                    action="{{ route('tenant.store') }}">
                    @csrf
                    <div class="w-full sm:px-6 mx-auto flex">
                        <div class="w-1/4">
                            queue details
                        </div>
                        <div class="w-full">
                            this is list of payload
                        </div>
                    </div>       
                </form>
            </div>
        </section>
    </div>
</main>
@endsection