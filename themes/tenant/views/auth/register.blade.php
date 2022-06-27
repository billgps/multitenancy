@extends('layouts.guest')

@section('content')
<main class="my-auto mx-auto sm:h-4/5 sm:w-3/4 sm:shadow-lg">
    <div class="flex">
        <div class="w-full">
            <section class="flex flex-col break-words bg-white sm:border-1">

                <header class="px-6 py-5 font-semibold text-gray-700 bg-gray-200 sm:py-6 sm:px-8">
                    {{ __('Register') }}
                </header>

                <form class="w-3/4 mx-auto my-auto space-y-6 sm:px-10 sm:space-y-8" method="POST"
                    action="{{ route('user.register') }}">
                    @csrf
                    <div class="sm:grid sm:grid-cols-2 sm:gap-2 sm:px-16">
                        <div class="flex flex-wrap">
                            <div class="relative h-10 w-full input-component mb-3">
                                <input required autofocus
                                    id="name" 
                                    type="name" 
                                    name="name" 
                                    class="h-full w-full border-gray-300 px-2 transition-all border-blue rounded-sm"
                                    value="{{ old('name') }}"
                                    />
                                <label for="name" class="absolute left-2 transition-all bg-white px-1">
                                    {{ __('Name') }}
                                </label>
                            </div>
                        </div>
    
                        <div class="flex flex-wrap">
                            <div class="relative h-10 w-full input-component mb-3">
                                <input required
                                    id="email" 
                                    type="email" 
                                    name="email" 
                                    class="h-full w-full border-gray-300 px-2 transition-all border-blue rounded-sm"
                                    value="{{ old('email') }}"
                                    />
                                <label for="email" class="absolute left-2 transition-all bg-white px-1">
                                    {{ __('E-Mail Address') }}
                                </label>
                            </div>
                        </div>
    
                        <div class="flex flex-wrap">
                            <div class="relative h-10 w-full input-component mb-3">
                                <input required
                                    id="password" 
                                    type="password" 
                                    name="password" 
                                    class="h-full w-full border-gray-300 px-2 transition-all border-blue rounded-sm"
                                    />
                                <label for="password" class="absolute left-2 transition-all bg-white px-1">
                                    {{ __('Password') }}
                                </label>
                            </div>
                        </div>
    
                        <div class="flex flex-wrap">
                            <div class="relative h-10 w-full input-component mb-3">
                                <input required
                                    id="password-confirm" 
                                    type="password" 
                                    name="password_confirmation" 
                                    class="h-full w-full border-gray-300 px-2 transition-all border-blue rounded-sm"
                                    />
                                <label for="password-confirm" class="absolute left-2 transition-all bg-white px-1">
                                    {{ __('Confirm Password') }}
                                </label>
                            </div>
                        </div>
    
                        <div class="flex flex-wrap">
                            <div class="relative h-10 w-full input-component mb-3">
                                <select name="role" id="role"
                                class="h-full w-full border-gray-300 px-2 transition-all border-blue rounded-sm text-xs"
                                >
                                    {{-- <option value="0">Admin</option> --}}
                                    <option value="1">Teknisi</option>
                                    <option value="3">Perawat</option>
                                    <option value="2">Visitor</option>
                                </select>
                                <label for="role" class="absolute left-2 transition-all bg-white px-1">
                                    {{ __('Role') }}
                                </label>
                            </div>
                        </div>
    
                        <div class="flex flex-wrap sm:row-start-4">
                            <div class="relative h-10 w-full input-component mb-3">
                                <input required
                                    id="phone"
                                    type="tel" 
                                    name="phone" 
                                    class="h-full w-full border-gray-300 px-2 transition-all border-blue rounded-sm"
                                    />
                                <label for="phone" class="absolute left-2 transition-all bg-white px-1">
                                    {{ __('No Telp') }}
                                </label>
                            </div>
                        </div>

                        <div class="flex flex-wrap sm:row-start-4">
                            <div class="relative h-10 w-full input-component mb-3">
                                <input required
                                    id="nip"
                                    type="tel" 
                                    name="nip" 
                                    class="h-full w-full border-gray-300 px-2 transition-all border-blue rounded-sm"
                                    />
                                <label for="nip" class="absolute left-2 transition-all bg-white px-1">
                                    {{ __('NIP') }}
                                </label>
                            </div>
                        </div>

                        <div class="flex flex-wrap sm:row-start-5">
                            <div class="relative h-10 w-full input-component mb-3">
                                <input required
                                    id="group"
                                    type="text" 
                                    name="group" 
                                    class="h-full w-full border-gray-300 px-2 transition-all border-blue rounded-sm"
                                    />
                                <label for="group" class="absolute left-2 transition-all bg-white px-1">
                                    {{ __('Golongan') }}
                                </label>
                            </div>
                        </div>

                        <div class="flex flex-wrap sm:row-start-5">
                            <div class="relative h-10 w-full input-component mb-3">
                                <input required
                                    id="position"
                                    type="text" 
                                    name="position" 
                                    class="h-full w-full border-gray-300 px-2 transition-all border-blue rounded-sm"
                                    />
                                <label for="position" class="absolute left-2 transition-all bg-white px-1">
                                    {{ __('Jabatan') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap justify-center">
                        <input type="submit" value="{{ __('Register') }}" class="block text-center text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black w-full sm:w-80">
                        <p class="w-full my-6 text-xs text-center text-gray-700 sm:text-sm sm:my-8">
                            {{ __('Already have an account?') }}
                            <a class="text-blue-500 no-underline hover:text-blue-700 hover:underline" href="{{ route('user.login') }}">
                                {{ __('Login') }}
                            </a>
                        </p>
                    </div>        
                </form>

            </section>
        </div>
    </div>
</main>
@endsection
