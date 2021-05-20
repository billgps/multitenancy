@extends('layouts.guest')

@section('content')
<main class="sm:container mx-auto sm:max-w-lg my-auto z-10">
    <div class="flex">
        <div class="w-full">
            <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

                <header class="px-6 py-5 font-semibold text-gray-700 bg-gray-200 sm:py-6 sm:px-8 sm:rounded-t-md">
                    {{ __('Administrator Login') }}
                </header>

                <form class="w-full px-6 space-y-6 sm:px-10 sm:space-y-8" method="POST" action="{{ route('administrator.login') }}">
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
                        <div class="relative h-10 w-full input-component mb-3">
                            <input required
                                id="password" 
                                type="password" 
                                name="password" 
                                class="h-full w-full border-gray-300 px-2 transition-all border-blue rounded-sm @error('email') border-red-500 @enderror"
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

                    <div class="flex items-center">
                        {{-- <label class="inline-flex items-center text-sm text-gray-700" for="remember">
                            <input type="checkbox" name="remember" id="remember" class="form-checkbox"
                                {{ old('remember') ? 'checked' : '' }}>
                            <span class="ml-2">{{ __('Remember Me') }}</span>
                        </label> --}}

                        @if (Route::has('administrator.password.request'))
                        <a class="ml-auto text-sm text-blue-500 no-underline whitespace-no-wrap hover:text-blue-700 hover:underline"
                            href="{{ route('administrator.password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                        @endif
                    </div>

                    <div class="flex flex-wrap">
                        <button type="submit" class="block text-center text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black w-full">
                            {{ __('Login') }}
                        </button>
                        {{-- <button type="submit"
                        class="w-full p-3 text-base font-bold leading-normal text-gray-100 no-underline whitespace-no-wrap bg-blue-500 rounded-lg select-none hover:bg-blue-700 sm:py-4">
                            {{ __('Login') }}
                        </button> --}}

                        @if (Route::has('administrator.register'))
                        <p class="w-full my-6 text-xs text-center text-gray-700 sm:my-8">
                            {{-- {{ __("Don't have an account?") }}
                            <a class="text-blue-500 no-underline hover:text-blue-700 hover:underline" href="{{ route('administrator.register') }}">
                                {{ __('Register') }}
                            </a> --}}
                            Provided by Global Promedika Services
                        </p>
                        @endif
                    </div>
                </form>

            </section>
        </div>
    </div>
</main>
@endsection
