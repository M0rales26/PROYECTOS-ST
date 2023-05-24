@extends('layouts.menu')
@section('title', 'Editar Datos' )

@section('content')
    <div class="flex flex-col items-center justify-center text-center w-full h-screen flex-1 px-20">
        <div class="bg-gray-200 rounded-2xl shadow-xl w-[160%] sm:w-[100%] lg:w-[60%]">
            <div class="h-full p-5">
                <div class="my-4">
                    <h2 class="text-3xl font-bold text-primary mb-1">Editar Datos</h2>
                    <div class="border-2 w-10 border-primary inline-block mb-2"></div>
                </div>
                <form action="{{url('editar', $datosperfil->id_usuario)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col items-center gap-4 mb-6">
                        <div class="w-full sm:w-[80%] bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                            <img src="{{ asset('iconos/user.svg') }}" class="ml-4">
                            <input type="text" name="name" class="outline-none px-3 py-2 w-full bg-transparent" value="{{$datosperfil->name}}" autocomplete="off">
                        </div>
                        <div class="w-full sm:w-[80%] bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                            <img src="{{ asset('iconos/email.svg') }}" class="ml-4">
                            <input type="text" name="name" class="outline-none px-3 py-2 w-full bg-transparent text-gray-400" value="{{$datosperfil->email}}" autocomplete="off" disabled>
                        </div>
                        <div class="w-full sm:w-[80%] bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                            <img src="{{ asset('iconos/location.svg') }}" class="ml-4">
                            <input type="text" name="direccion" class="outline-none px-3 py-2 w-full bg-transparent" value="{{$datosperfil->direccion}}" autocomplete="off">
                        </div>
                        <div class="w-full sm:w-[80%] bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                            <img src="{{ asset('iconos/image.svg') }}" class="ml-4">
                            <input type="file" name="fotop" class="outline-none px-3 py-2 w-full bg-transparent" accept=".jpg,.png,.jpeg">
                        </div>
                    </div>
                    {{-- // --}}
                    <div class="mb-4">
                        @error('name')
                            <p class="text-sm text-red-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                        @error('email')
                            <p class="text-sm text-red-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                        @error('direccion')
                            <p class="text-sm text-red-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                        @error('fotop')
                            <p class="text-sm text-red-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- // --}}
                    <div class="flex gap-2 sm:gap-5 w-full items-center justify-center">
                        <button type="submit" class="text-white rounded-full px-7 sm:px-12 py-2 font-semibold bg-check hover:scale-105 duration-300 flex items-center justify-center">
                            <img src="{{ asset('iconos/check.svg') }}" class="nav mr-1"> Confirmar
                        </button>
                        <a href="{{url('perfil', auth()->user()->id_usuario)}}" class="text-white rounded-full px-7 sm:px-12 py-2 font-semibold bg-gray-500 hover:scale-105 duration-300 cursor-pointer flex items-center justify-center">
                            <img src="{{ asset('iconos/x.svg') }}" class="nav mr-1"> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection