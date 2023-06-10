@extends('layouts.menu')
@section('title', 'Agregar Nombre Producto' )

@section('content')
    <div class="flex flex-col items-center justify-center text-center w-full h-screen flex-1 px-20">
        <div class="bg-gray-200 rounded-2xl shadow-xl w-[150%] sm:w-[100%] lg:w-[60%]">
            <div class="w-full p-5">
                <div class="my-4">
                    <h2 class="text-3xl font-bold text-primary mb-1">Agregar Nombre Producto</h2>
                    <div class="border-2 w-10 border-primary inline-block mb-2"></div>
                </div>
                <form action="{{route('nombres.store')}}" method="POST">
                    @csrf
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-full sm:w-[80%] bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                            <img src="{{ asset('iconos/cookie.svg') }}" class="ml-4">
                            <input type="text" name="nombre" class="outline-none px-3 py-2 w-full bg-transparent placeholder:text-black" placeholder="Nombre Producto" value="{{ old('nombre') }}" autocomplete="off">
                            <input type="hidden" name="estado" value="HABILITADO">
                        </div>
                    </div>
                    {{-- // --}}
                    @error('nombre')
                        <p class="text-sm text-red-600 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                    {{-- // --}}
                    <div class="flex gap-5 w-full items-center justify-center">
                        <button type="submit" class="mt-6 text-white rounded-full px-7 sm:px-12 py-2 font-semibold bg-check hover:scale-105 duration-300 flex items-center justify-center">
                            <img src="{{ asset('iconos/check.svg') }}" class="nav mr-1"> Confirmar
                        </button>
                        <a href="{{route('nombres.index')}}" class="mt-6 text-white rounded-full px-7 sm:px-12 py-2 font-semibold bg-gray-500 hover:scale-105 duration-300 cursor-pointer flex items-center justify-center">
                            <img src="{{ asset('iconos/x.svg') }}" class="nav mr-1"> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
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