@extends('layouts.guest')

@section('content')
{{-- <main class="sm:container sm:mx-auto sm:max-w-lg sm:mt-10">
    <div class="flex">
        <div class="w-full">
            <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

                <header class="px-6 py-5 font-semibold text-gray-700 bg-gray-200 sm:py-6 sm:px-8 sm:rounded-t-md">
                    {{ __('Reset Password') }}
                </header>

                <form class="w-full px-6 space-y-6 sm:px-10 sm:space-y-8" method="POST" action="{{ route('user.password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ request()->token }}">

                    <div class="flex flex-wrap">
                        <label for="email" class="block mb-2 text-sm font-bold text-gray-700">
                            {{ __('E-Mail Address') }}:
                        </label>

                        <input id="email" type="email"
                            class="form-input w-full @error('email') border-red-500 @enderror" name="email"
                            value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <p class="mt-4 text-xs italic text-red-500">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap">
                        <label for="password" class="block mb-2 text-sm font-bold text-gray-700">
                            {{ __('Password') }}:
                        </label>

                        <input id="password" type="password"
                            class="form-input w-full @error('password') border-red-500 @enderror" name="password"
                            required autocomplete="new-password">

                        @error('password')
                        <p class="mt-4 text-xs italic text-red-500">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap">
                        <label for="password-confirm" class="block mb-2 text-sm font-bold text-gray-700">
                            {{ __('Confirm Password') }}:
                        </label>

                        <input id="password-confirm" type="password" class="w-full form-input"
                            name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="flex flex-wrap pb-8 sm:pb-10">
                        <button type="submit"
                        class="w-full p-3 text-base font-bold leading-normal text-gray-100 no-underline whitespace-no-wrap bg-blue-500 rounded-lg select-none hover:bg-blue-700 sm:py-4">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </form>

            </section>
        </div>
    </div>
</main> --}}
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
            {{ __('Reset Password') }}
        </header>

        <form class="w-3/4 my-auto mx-auto space-y-6 sm:px-16 sm:space-y-8" method="POST" action="{{ route('user.password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ request()->token }}">

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
                <div class="relative h-10 w-full input-component mb-3">
                    <input required autofocus
                        id="password" 
                        type="password" 
                        name="password" 
                        class="h-full w-full border-gray-300 px-2 transition-all border-blue rounded-sm @error('email') border-red-500 @enderror"
                        value="{{ old('password') }}"
                        />
                    <label for="password" class="absolute left-2 transition-all bg-white px-1">
                        {{ __('Password') }}
                    </label>
                </div>
                @error('password')
                <p class="mt-4 text-xs italic text-red-500">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="flex flex-wrap">
                <div class="relative h-10 w-full input-component mb-3">
                    <input required autofocus
                        id="password_confirmation" 
                        type="password" 
                        name="password_confirmation" 
                        class="h-full w-full border-gray-300 px-2 transition-all border-blue rounded-sm @error('email') border-red-500 @enderror"
                        value="{{ old('password_confirmation') }}"
                        />
                    <label for="password_confirmation" class="absolute left-2 transition-all bg-white px-1">
                        {{ __('E-Mail Address') }}
                    </label>
                </div>
                @error('password_confirmation')
                <p class="mt-4 text-xs italic text-red-500">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="flex flex-wrap">
                <button type="submit" class="block text-center text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black w-full">
                    {{ __('Submit') }}
                </button>
            </div>
        </form>
    </section>
</main>
@endsection
