@extends('layouts.applog')
@section('title', 'Restablecer Contraseña')

@section('content')
    <main class="flex items-center justify-center text-center w-full h-screen flex-1">
        <div class="flex items-center justify-center w-full sm:w-4/5 lg:w-8/12 sm:px-6 lg:px-0 px-3">
            <div class="bg-white rounded-2xl shadow-2xl sm:w-full lg:w-full xl:w-3/5 w-full">
                <div class="w-full h-full p-5 flex flex-col gap-8">
                    <div class="text-left text-xl font-bold">
                        <span class="text-primary">Sol</span>Tiend
                    </div>
                    <div class="flex flex-col">
                        <div class="mb-4">
                            <h2 class="text-3xl font-bold text-primary mb-1">Restablecer Contraseña</h2>
                            <div class="border-2 w-10 border-primary inline-block mb-2"></div>
                        </div>
                        <form method="POST" action="{{ route('contraseña.update') }}" class="flex flex-col items-center">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="flex flex-col items-center gap-4 sm:w-[80%] mb-4 w-full">
                                <div class="sm:w-[90%] w-full bg-gray-200 flex items-center rounded-xl">
                                    <img src="{{ asset('iconos/email.svg') }}" class="nav ml-4">
                                    <input type="text" name="email" class="w-full outline-none px-3 pr-5 py-2 bg-transparent placeholder:text-black" placeholder="Correo Electrónico" value="{{ old('email') }}" autocomplete="off">
                                </div>
                                <div class="sm:w-[90%] w-full bg-gray-200 flex items-center rounded-xl">
                                    <img src="{{ asset('iconos/lock.svg') }}" class="nav ml-4">
                                    <input type="password" name="password" class="w-full outline-none px-3 pr-5 py-2 bg-transparent placeholder:text-black" placeholder="Contraseña" id="password" autocomplete="off">
                                    <img src="{{ asset('iconos/show.svg') }}" onclick="togglePassword()" class="mx-2 cursor-pointer" id="icon">
                                </div>
                                <div class="sm:w-[90%] w-full bg-gray-200 flex items-center rounded-xl">
                                    <img src="{{ asset('iconos/lock.svg') }}" class="nav ml-4">
                                    <input type="password" name="password_confirmation" class="w-full outline-none px-3 pr-5 py-2 bg-transparent placeholder:text-black" placeholder="Confirmar Contraseña" id="password2" autocomplete="off">
                                    <img src="{{ asset('iconos/show.svg') }}" onclick="togglePassword2()" class="mx-2 cursor-pointer" id="icon2">
                                </div>
                            </div>
                            <div class="mb-2">
                                @error('email')
                                    <p class="text-sm text-red-600 font-semibold mt-3 mb-4">{{ $message }}</p>
                                @enderror
                                @error('password')
                                    <p class="text-sm text-red-600 font-semibold mt-3 mb-4">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex gap-2 sm:gap-5 w-full items-center justify-center mt-4">
                                <button type="submit" class="text-white rounded-full px-7 sm:px-12 py-2 font-semibold bg-primary hover:scale-105 duration-300 flex items-center justify-center">
                                    <img src="{{ asset('iconos/reset.svg') }}" class="nav mr-1"> Restablecer
                                </button>
                                <a href="{{route('login.index')}}" class="text-white rounded-full px-7 sm:px-12 py-2 font-semibold bg-gray-500 hover:scale-105 duration-300 cursor-pointer flex items-center justify-center">
                                    <img src="{{ asset('iconos/x.svg') }}" class="nav mr-1"> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        function togglePassword() {
            var password = document.getElementById("password");
            var passwordIcon = document.getElementById("icon");
            if (password.type === "password") {
                password.type = "text";
                passwordIcon.src = "{{ asset('iconos/hide.svg') }}";
            } else {
                password.type = "password";
                passwordIcon.src = "{{ asset('iconos/show.svg') }}";
            }
        }
        function togglePassword2() {
            var password = document.getElementById("password2");
            var passwordIcon = document.getElementById("icon2");
            if (password.type === "password") {
                password.type = "text";
                passwordIcon.src = "{{ asset('iconos/hide.svg') }}";
            } else {
                password.type = "password";
                passwordIcon.src = "{{ asset('iconos/show.svg') }}";
            }
        }
    </script>
@endsection