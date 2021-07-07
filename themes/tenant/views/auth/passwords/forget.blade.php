@extends('layouts.guest')

@section('content')
<main class="sm:grid sm:grid-cols-2 my-auto sm:mx-auto sm:h-4/5 sm:w-4/5 sm:shadow-lg">
    <div class="h-full w-full bg-gray-200 flex flex-col-reverse">
        <div class="flex justify-start">
            <img src="{{ asset('illust_2.png') }}" class="">
        </div>
        <div class="text-center flex-col mb-48">
            <img src="{{ asset(app('currentTenant')->vendor_id) }}" alt="logo" class="w-28 mt-6 h-12 mx-auto">
            <p class="text-sm text-gray-600">Inventory Website</p>
        </div>
    </div>
    <section class="flex flex-col break-words bg-white sm:border-1">

        <header class="px-6 py-5 font-semibold text-gray-700 bg-white sm:py-6 sm:px-8">
            {{ __('Forgot Password') }}
        </header>

        <form class="w-3/4 my-auto mx-auto space-y-6 sm:px-16 sm:space-y-8" method="POST" action="{{ route('user.password.email') }}">
            @csrf

            <div class="flex flex-wrap">
                <div class="relative h-10 w-full input-component mb-3">
                    <input required autofocus
                        id="email" 
                        type="email" 
                        name="email" 
                        class="h-full w-full border-gray-300 px-2 transition-all border-blue rounded-sm @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}"
                        />
                    <label for="email" class="absolute left-2 transition-all bg-white px-1">
                        {{ __('E-Mail Address') }}
                    </label>
                </div>
                @error('email')
                <p class="mt-4 text-xs italic text-red-500">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="flex flex-wrap">
                <button type="submit" class="block text-center text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black w-full">
                    {{ __('Send Link') }}
                </button>

                @if (Route::has('user.register'))
                <p class="w-full my-6 text-xs text-center text-gray-700 sm:text-sm sm:my-8">
                    {{ __("Don't have an account?") }}
                    <a class="text-blue-500 no-underline hover:text-blue-700 hover:underline" href="{{ route('user.register') }}">
                        {{ __('Register') }}
                    </a>
                </p>
                @endif
            </div>
        </form>
    </section>
</main>
{{-- <main class="sm:container sm:mx-auto sm:max-w-lg sm:mt-10">
    <div class="flex">
        <div class="w-full">

            @if (session('status'))
            <div class="px-5 py-6 text-sm text-green-700 bg-green-100 sm:rounded sm:border sm:border-green-400 sm:mb-6"
                role="alert">
                {{ session('status') }}
            </div>
            @endif

            <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">
                <header class="px-6 py-5 font-semibold text-gray-700 bg-gray-200 sm:py-6 sm:px-8 sm:rounded-t-md">
                    {{ __('Reset Password') }}
                </header>

                <form class="w-full px-6 space-y-6 sm:px-10 sm:space-y-8" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="flex flex-wrap">
                        <label for="email" class="block mb-2 text-sm font-bold text-gray-700 sm:mb-4">
                            {{ __('E-Mail Address') }}:
                        </label>

                        <input id="email" type="email"
                            class="form-input w-full @error('email') border-red-500 @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <p class="mt-4 text-xs italic text-red-500">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap items-center justify-center pb-6 space-y-6 sm:pb-10 sm:space-y-0 sm:justify-between">
                        <button type="submit"
                        class="w-full p-3 text-base font-bold leading-normal text-gray-100 no-underline whitespace-no-wrap bg-blue-500 rounded-lg select-none hover:bg-blue-700 sm:w-auto sm:px-4 sm:order-1">
                            {{ __('Send Password Reset Link') }}
                        </button>

                        <p class="mt-4 text-xs text-blue-500 no-underline whitespace-no-wrap hover:text-blue-700 hover:underline sm:text-sm sm:order-0 sm:m-0">
                            <a class="text-blue-500 no-underline hover:text-blue-700" href="{{ route('login') }}">
                                {{ __('Back to login') }}
                            </a>
                        </p>
                    </div>
                </form>
            </section>
        </div>
    </div>
</main> --}}
@endsection
