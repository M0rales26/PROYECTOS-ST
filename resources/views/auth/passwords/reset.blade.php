@extends('layouts.app')
@section('title', 'Reestablecer Contraseña')

@section('content')
    <main class="flex items-center justify-center text-center w-full h-screen flex-1">
        <div class="flex items-center justify-center w-full sm:w-4/5 lg:w-8/12 sm:px-6 lg:px-0 px-3">
            <div class="bg-white rounded-2xl shadow-2xl sm:w-full lg:w-full xl:w-3/5 w-full">
                <div class="p-5 h-full">
                    <div class="text-left text-xl font-bold">
                        <span class="text-primary">Sol</span>Tiend
                    </div>
                    <div class="flex flex-col">
                        <div class="my-6">
                            <h2 class="text-3xl font-bold text-primary mb-1">Restablecer Contraseña</h2>
                            <div class="border-2 w-10 border-primary inline-block mb-2"></div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('password.update') }}" class="flex flex-col items-center">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="flex flex-col items-center gap-4 sm:w-[100%] mb-2 w-full">
                            <div class="w-full flex flex-col items-center justify-center">
                                <div class="w-[90%] bg-gray-200 flex items-center rounded-xl">
                                    <img src="{{ asset('iconos/email.svg') }}" class="nav ml-4">
                                    <input type="email" name="email" class="w-full outline-none px-3 pr-5 py-2 bg-transparent placeholder:text-black @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" autocomplete="off">
                                </div>
                                @error('email')
                                    <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="w-full flex flex-col items-center justify-center">
                                <div class="w-[90%] bg-gray-200 flex items-center rounded-xl">
                                    <img src="{{ asset('iconos/lock.svg') }}" class="nav ml-4">
                                    <input type="password" name="password" class="w-full outline-none px-3 pr-5 py-2 bg-transparent placeholder:text-black @error('password') is-invalid @enderror" placeholder="Contraseña" autocomplete="off" id="password1">
                                    <img src="{{ asset('iconos/show.svg') }}" onclick="togglePassword()" class="mr-2 cursor-pointer" id="icon">
                                </div>
                                @error('password')
                                    <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="w-full flex flex-col items-center justify-center">
                                <div class="w-[90%] bg-gray-200 flex items-center rounded-xl">
                                    <img src="{{ asset('iconos/lock.svg') }}" class="nav ml-4">
                                    <input type="password" name="password_confirmation" class="w-full outline-none px-3 pr-5 py-2 bg-transparent placeholder:text-black" placeholder="Confirmar Contraseña" autocomplete="off" id="password2">
                                    <img src="{{ asset('iconos/show.svg') }}" onclick="togglePassword2()" class="mr-2 cursor-pointer" id="icon2">
                                </div>
                                @error('password_confirmation')
                                    <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full flex justify-center items-center">
                            <button type="submit" class="mt-3 border-2 border-primary gap-2 text-white rounded-full px-12 py-1 flex font-semibold bg-primary hover:scale-105 duration-300 items-center justify-center">
                                <img src="{{ asset('iconos/reset.svg') }}" class="nav"> Restablecer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
        function togglePassword() {
            var password = document.getElementById("password1");
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
