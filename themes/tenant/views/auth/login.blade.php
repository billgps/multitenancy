@extends('layouts.guest')

@section('content')
<main class="sm:grid sm:grid-cols-2 my-auto sm:mx-auto sm:h-4/5 sm:w-4/5 sm:shadow-lg">
    <div class="h-full w-full bg-gray-200 flex flex-col-reverse">
        <div class="flex justify-start">
            <img src="{{ asset('illust_2.png') }}" class="">
        </div>
        <div class="text-center flex-col mb-48">
            <script>
                function getScale(img) {
                    let height = img.naturalHeight
                    let width = img.naturalWidth
                    let threshold = height * (10 / 100)

                    if (width > (height + threshold)) {
                        img.classList.add('w-28', 'h-12')
                    }

                    else if (width < (height - threshold)) {
                        img.classList.add('w-12', 'h-28')
                    }

                    else {
                        img.classList.add('w-24', 'h-24')
                    }
                }
            </script>
            {{-- <img onload="getScale(this)" id="logo_front" src="{{ asset(app('currentTenant')->vendor_id) }}" alt="logo" class="mt-6 mx-auto"> --}}
            <img onload="getScale(this)" id="logo_front" src="{{ asset('gps_logo.png') }}" alt="logo" class="mt-6 mx-auto">
            <p class="text-xs text-gray-600">Inventory Website</p>
        </div>
    </div>
    <section class="flex flex-col break-words bg-white sm:border-1">

        <header class="px-6 py-5 font-semibold text-gray-700 bg-white sm:py-6 sm:px-8">
            {{ __('User Login') }}
        </header>

        <form class="w-3/4 my-auto mx-auto space-y-6 sm:px-16 sm:space-y-8" method="POST" action="{{ route('user.login') }}">
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

                @if (Route::has('user.password.request'))
                <a class="ml-auto text-sm text-blue-500 no-underline whitespace-no-wrap hover:text-blue-700 hover:underline"
                    href="{{ route('user.password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
                @endif
            </div>

            <div class="flex flex-wrap">
                <button type="submit" class="block text-center text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black w-full">
                    {{ __('Login') }}
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
@endsection
