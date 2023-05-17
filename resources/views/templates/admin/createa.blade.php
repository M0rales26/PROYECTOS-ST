@extends('layouts.menu')
@section('title', 'Agregar Admin' )

@section('content')
    <div class="flex flex-col items-center justify-center text-center w-full h-screen flex-1 px-20">
        <div class="bg-gray-200 rounded-2xl shadow-xl w-[150%] sm:w-[100%] lg:w-[75%]">
            <div class="w-full p-5">
                <div class="my-4">
                    <h2 class="text-3xl font-bold text-primary mb-1">Agregar Admin</h2>
                    <div class="border-2 w-10 border-primary inline-block mb-2"></div>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col items-center justify-center gap-3">
                        <div class="flex flex-col items-center gap-3 w-full">
                            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:px-4">
                                <div class="w-full sm:w-1/2">
                                    <div class="bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                                        <img src="{{ asset('iconos/user.svg') }}" class="ml-4">
                                        <input type="text" name="name" class="outline-none px-3 py-2 bg-transparent placeholder:text-black w-full" placeholder="Nombre" value="{{ old('name') }}" autocomplete="off">
                                    </div>
                                    @error('name')
                                        <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="w-full sm:w-1/2">
                                    <div class="bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                                        <img src="{{ asset('iconos/email.svg') }}" class="ml-4">
                                        <input type="text" name="email" class="outline-none px-3 py-2 bg-transparent placeholder:text-black w-full" placeholder="Correo Electrónico" value="{{ old('email') }}" autocomplete="off">
                                    </div>
                                    @error('email')
                                        <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:px-4">
                                <div class="w-full sm:w-1/2">
                                    <div class="bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                                        <img src="{{ asset('iconos/group.svg') }}" class="ml-4">
                                        <input type="text" class="outline-none px-3 py-2 border-none bg-transparent text-gray-400 w-full" value="3" autocomplete="off" disabled>
                                        <input type="hidden" name="rol_id" value="3">
                                    </div>
                                    @error('rol_id')
                                        <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="w-full sm:w-1/2">
                                    <div class="bg-gray-100 border-2 border-primary flex items-center rounded-xl">
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
                                    <div class="bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                                        <img src="{{ asset('iconos/lock.svg') }}" class="ml-4">
                                        <input type="password" name="password" class="outline-none px-3 py-2 border-none bg-transparent placeholder:text-black w-full" placeholder="Contraseña" autocomplete="off" id="password1">
                                        <img src="{{ asset('iconos/show.svg') }}" onclick="togglePassword()" class="mr-2 cursor-pointer" id="icon">
                                    </div>
                                    @error('password')
                                        <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="w-full sm:w-1/2">
                                    <div class="bg-gray-100 border-2 border-primary flex items-center rounded-xl">
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
                        <div class="w-[70%]">
                            <div class="bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                                <img src="{{ asset('iconos/image.svg') }}" class="ml-4">
                                <input type="file" name="fotop" class="outline-none px-3 py-2 border-none bg-transparent w-full" accept=".jpg,.png,.jpeg">
                            </div>
                            @error('fotop')
                                <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    {{-- // --}}
                    <div class="flex gap-5 w-full items-center justify-center">
                        <button type="submit" class="mt-6 text-white rounded-full px-7 sm:px-12 py-2 font-semibold bg-check hover:scale-105 duration-300 flex items-center justify-center">
                            <img src="{{ asset('iconos/check.svg') }}" class="nav mr-1"> Confirmar
                        </button>
                        <a href="{{route('admins.index')}}" class="mt-6 text-white rounded-full px-7 sm:px-12 py-2 font-semibold bg-gray-500 hover:scale-105 duration-300 cursor-pointer flex items-center justify-center">
                            <img src="{{ asset('iconos/x.svg') }}" class="nav mr-1"> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
@section('js')
    <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <link href="{{asset('assets/css/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
    @if(session('error'))
        <script>
            Swal.fire(
                '',
                'El nombre de producto ya existe!',
                'error'
            )
        </script>
    @endif
@endsection