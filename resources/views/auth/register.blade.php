@extends('layouts.applog')
@section('title', 'Registro de Usuario')

@section('content')
    <main class="flex items-center justify-center text-center w-full h-screen flex-1">
        <div class="flex items-center justify-center w-full sm:w-11/12 lg:w-10/12 sm:px-6 lg:px-0 px-3">
            <div class="bg-white rounded-2xl shadow-2xl sm:w-full lg:w-full xl:w-3/5 w-full">
                <div class="p-5 h-full">
                    <div class="text-left text-xl font-bold">
                        <span class="text-primary">Sol</span>Tiend
                    </div>
                    <div class="my-6">
                        <h2 class="text-3xl font-bold text-primary mb-1">Registro de Usuario</h2>
                        <div class="border-2 w-10 border-primary inline-block mb-2"></div>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col items-center justify-center gap-3">
                            <div class="flex flex-col items-center gap-3 w-full">
                                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:px-4">
                                    <div class="w-full sm:w-1/2">
                                        <div class="bg-gray-200 flex items-center rounded-xl">
                                            <img src="{{ asset('iconos/user.svg') }}" class="ml-4">
                                            <input type="text" name="name" class="outline-none px-3 py-2 bg-transparent placeholder:text-black w-full" placeholder="Nombre" value="{{ old('name') }}" autocomplete="off">
                                        </div>
                                        @error('name')
                                            <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="w-full sm:w-1/2">
                                        <div class="bg-gray-200 flex items-center rounded-xl">
                                            <img src="{{ asset('iconos/email.svg') }}" class="ml-4">
                                            <input type="text" name="email" class="outline-none px-3 py-2 border-none bg-transparent placeholder:text-black w-full" placeholder="Correo Electrónico" value="{{ old('email') }}" autocomplete="off">
                                        </div>
                                        @error('email')
                                            <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:px-4">
                                    <div class="w-full sm:w-1/2">
                                        <div class="bg-gray-200 flex items-center rounded-xl">
                                            <img src="{{ asset('iconos/group.svg') }}" class="ml-4">
                                            <select name="rol_id" class="outline-none px-3 py-2 bg-transparent w-[83%] appearance-none">
                                                <option value="" class="bg-gray-200">Elegir Rol</option>
                                                @foreach ($roles as $rol)
                                                    <option value="{{$rol->id_rol}}" class="bg-gray-200">{{$rol->rol}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('rol_id')
                                            <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="w-full sm:w-1/2">
                                        <div class="bg-gray-200 flex items-center rounded-xl">
                                            <img src="{{ asset('iconos/location.svg') }}" class="ml-4">
                                            <input type="text" name="direccion" class="outline-none px-3 py-2 border-none bg-transparent placeholder:text-black w-full" placeholder="Dirección" value="{{ old('direccion') }}" autocomplete="off">
                                        </div>
                                        @error('direccion')
                                            <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:px-4">
                                    <div class="w-full sm:w-1/2">
                                        <div class="bg-gray-200 flex items-center rounded-xl">
                                            <img src="{{ asset('iconos/lock.svg') }}" class="ml-4">
                                            <input type="password" name="password" class="outline-none px-3 py-2 border-none bg-transparent placeholder:text-black w-full" placeholder="Contraseña" autocomplete="off" id="password1">
                                            <img src="{{ asset('iconos/show.svg') }}" onclick="togglePassword()" class="mr-2 cursor-pointer" id="icon">
                                        </div>
                                        @error('password')
                                            <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="w-full sm:w-1/2">
                                        <div class="bg-gray-200 flex items-center rounded-xl">
                                            <img src="{{ asset('iconos/lock.svg') }}" class="ml-4">
                                            <input type="password" name="password_confirmation" class="outline-none px-3 py-2 border-none bg-transparent placeholder:text-black w-full" placeholder="Confirmar Contraseña" autocomplete="off" id="password2">
                                            <img src="{{ asset('iconos/show.svg') }}" onclick="togglePassword2()" class="mr-2 cursor-pointer" id="icon2">
                                        </div>
                                        @error('password_confirmation')
                                            <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="bg-gray-200 flex items-center rounded-xl">
                                    <img src="{{ asset('iconos/image.svg') }}" class="ml-4">
                                    <input type="file" name="fotop" class="outline-none px-3 py-2 border-none bg-transparent w-full" accept=".jpg,.png,.jpeg">
                                </div>
                                @error('fotop')
                                    <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full flex justify-center items-center">
                            <button class="mt-6 border-2 border-primary gap-2 text-white rounded-full px-12 py-1 flex font-semibold bg-primary hover:scale-105 duration-300 items-center justify-center">
                                <img src="{{ asset('iconos/adduser.svg') }}"> Registrarme
                            </button>
                        </div>
                    </form>
                    <div class="flex items-center justify-center gap-2 mt-5">
                        <p>¿Ya Tienes una Cuenta?</p>
                        <a href="{{route('login.index')}}" class="text-primary hover:underline duration-300">Iniciar Sesión</a>
                    </div>
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