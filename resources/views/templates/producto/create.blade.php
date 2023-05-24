@extends('layouts.menu')
@section('title', 'Agregar Producto' )

@section('content')
    <div class="flex flex-col items-center justify-center text-center w-full h-screen flex-1 px-20">
        <div class="bg-gray-200 rounded-2xl shadow-xl w-[160%] sm:w-[100%] lg:w-[60%]">
            <div class="h-full p-5">
                <div class="my-4">
                    <h2 class="text-3xl font-bold text-primary mb-1">Agregar Producto</h2>
                    <div class="border-2 w-10 border-primary inline-block mb-2"></div>
                </div>
                <form action="{{route('producto.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-full sm:w-[80%] bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                            <img src="{{ asset('iconos/cookie.svg') }}" class="ml-4">
                            <select name="nombrep" class="outline-none px-3 py-2 bg-transparent w-[83%] appearance-none">
                                <option value="" class="bg-gray-200">Elegir Nombre</option>
                                @foreach ($nombres as $nombre)
                                    <option value="{{$nombre->nombre}}" class="bg-gray-200">{{$nombre->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full sm:w-[80%] bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                            <img src="{{ asset('iconos/dollar.svg') }}" class="ml-4">
                            <input type="number" name="precio" class="outline-none px-3 py-2 w-full bg-transparent placeholder:text-black" placeholder="Precio Producto" value="{{ old('precio') }}" autocomplete="off">
                        </div>
                        <div class="w-full sm:w-[80%] bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                            <img src="{{ asset('iconos/cylinder.svg') }}" class="ml-4">
                            <input type="text" name="peso_neto" class="outline-none px-3 py-2 w-full bg-transparent placeholder:text-black" placeholder="Peso Neto" value="{{ old('peso_neto') }}" autocomplete="off">
                        </div>
                        <div class="w-full sm:w-[80%] bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                            <img src="{{ asset('iconos/package.svg') }}" class="ml-4">
                            <input type="number" name="stock" class="outline-none px-3 py-2 w-full bg-transparent placeholder:text-black" placeholder="Stock Producto" value="{{ old('stock') }}" autocomplete="off">
                        </div>
                        <div class="w-full sm:w-[80%] bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                            <img src="{{ asset('iconos/image.svg') }}" class="ml-4">
                            <input type="file" name="foto" class="outline-none px-3 py-2 w-full bg-transparent placeholder:text-black" accept=".jpg,.png,.jpeg">
                        </div>
                    </div>
                    {{-- // --}}
                    <div>
                        @error('nombrep')
                            <p class="text-sm text-red-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                        @error('precio')
                            <p class="text-sm text-red-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                        @error('peso_neto')
                            <p class="text-sm text-red-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                        @error('stock')
                            <p class="text-sm text-red-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                        @error('foto')
                            <p class="text-sm text-red-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- // --}}
                    <input type="hidden" name="usuario_id" value="{{auth()->user()->id_usuario}}">
                    <input type="hidden" name="estado" value="HABILITADO">
                    {{-- // --}}
                    <div class="flex gap-5 w-full items-center justify-center">
                        <button type="submit" class="mt-6 text-white rounded-full px-7 sm:px-12 py-2 font-semibold bg-check hover:scale-105 duration-300 flex items-center justify-center">
                            <img src="{{ asset('iconos/check.svg') }}" class="nav mr-1"> Confirmar
                        </button>
                        <a href="{{route('producto.index')}}" class="mt-6 text-white rounded-full px-7 sm:px-12 py-2 font-semibold bg-gray-500 hover:scale-105 duration-300 cursor-pointer flex items-center justify-center">
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
                'El producto ya existe!',
                'error'
            )
        </script>
    @endif
@endsection