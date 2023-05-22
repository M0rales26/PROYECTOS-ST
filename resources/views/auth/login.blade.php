@extends('layouts.applog')
@section('title', 'Inicio de Sesión')

@section('content')
    <main class="flex items-center justify-center text-center w-full h-screen flex-1">
        <div class="flex items-center justify-center w-full sm:w-4/5 lg:w-8/12 sm:px-6 lg:px-0 px-3">
            <div class="bg-white rounded-2xl shadow-2xl sm:w-full lg:w-full xl:w-3/5 w-full">
                <div class="w-full h-full p-5 flex flex-col gap-8">
                    <div class="text-left text-xl font-bold">
                        <span class="text-primary">Sol</span>Tiend
                    </div>
                    <div class="flex flex-col">
                        <div class="my-6">
                            <h2 class="text-3xl font-bold text-primary mb-1">Inicio de Sesión</h2>
                            <div class="border-2 w-10 border-primary inline-block mb-2"></div>
                        </div>
                        <form method="POST" class="flex flex-col items-center">
                            @csrf
                            <div class="flex flex-col items-center gap-4 sm:w-[80%] mb-2 w-full">
                                <div class="sm:w-[90%] w-full bg-gray-200 flex items-center rounded-xl">
                                    <img src="{{ asset('iconos/email.svg') }}" class="nav ml-4">
                                    <input type="email" name="email" class="w-full outline-none px-3 pr-5 py-2 bg-transparent placeholder:text-black" placeholder="Correo Electrónico" autocomplete="off">
                                </div>
                                <div class="sm:w-[90%] w-full bg-gray-200 flex items-center rounded-xl">
                                    <img src="{{ asset('iconos/lock.svg') }}" class="nav ml-4">
                                    <input type="password" name="password" class="w-full outline-none px-3 pr-5 py-2 bg-transparent placeholder:text-black" placeholder="Contraseña" id="password" autocomplete="off">
                                    <img src="{{ asset('iconos/show.svg') }}" onclick="togglePassword()" class="mx-2 cursor-pointer" id="icon">
                                </div>
                            </div>
                            <div class="">
                                @error('message')
                                    <p class="text-sm text-red-600 font-semibold mt-3">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-center justify-end mt-3 mb-2 w-[75%]">
                                <a href="{{route('password.request')}}" class="text-primary hover:underline duration-300">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                            <div class="w-full flex justify-center items-center">
                                <button type="submit" class="mt-3 border-2 border-primary gap-2 text-white rounded-full px-12 py-1 flex font-semibold bg-primary hover:scale-105 duration-300 items-center justify-center">
                                    <img src="{{ asset('iconos/login.svg') }}"> Iniciar Sesión
                                </button>
                            </div>
                        </form>
                        <div class="flex items-center justify-center gap-2 mt-5">
                            <p>¿No Tienes Cuenta?</p>
                            <a href="{{route('register.index')}}" class="text-primary hover:underline duration-300">
                                Registrarme
                            </a>
                        </div>
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
    </script>
@endsection