@extends('layouts.menu')
@section('title', 'Editar Producto' )

@section('content')
    <div class="flex flex-col items-center justify-center text-center w-full h-screen flex-1 px-20">
        <div class="bg-gray-200 rounded-2xl shadow-xl w-[160%] sm:w-[100%] lg:w-[60%]">
            <div class="h-full p-5">
                <div class="my-4">
                    <h2 class="text-3xl font-bold text-primary mb-1">Editar Producto</h2>
                    <div class="border-2 w-10 border-primary inline-block mb-2"></div>
                </div>
                <form action="{{url('producto/'.$producto->id_producto)}}" method="POST" enctype="multipart/form-data" class="form_edit">
                    @csrf
                    {{method_field('PATCH')}}
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-full sm:w-[80%] bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                            <img src="{{ asset('iconos/cookie.svg') }}" class="ml-4">
                            <input type="text" name="nombrep" class="outline-none px-3 py-2 w-full bg-transparent text-gray-400" value="{{$producto->nombrep}}" autocomplete="off" disabled>
                        </div>
                        <div class="w-full sm:w-[80%] bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                            <img src="{{ asset('iconos/dollar.svg') }}" class="ml-4">
                            <input type="number" name="precio" class="outline-none px-3 py-2 w-full bg-transparent" value="{{$producto->precio}}" autocomplete="off">
                        </div>
                        <div class="w-full sm:w-[80%] bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                            <img src="{{ asset('iconos/cylinder.svg') }}" class="ml-4">
                            <input type="text" name="peso_neto" class="outline-none px-3 py-2 w-full bg-transparent" value="{{$producto->peso_neto}}" autocomplete="off">
                        </div>
                        <div class="w-full sm:w-[80%] bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                            <img src="{{ asset('iconos/package.svg') }}" class="ml-4">
                            <input type="number" name="stock" class="outline-none px-3 py-2 w-full bg-transparent" value="{{$producto->stock}}" autocomplete="off">
                        </div>
                        <div class="w-full sm:w-[80%] bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                            <img src="{{ asset('iconos/image.svg') }}" class="ml-4">
                            <input type="file" name="foto" class="outline-none px-3 py-2 w-full bg-transparent" accept=".jpg,.png,.jpeg">
                        </div>
                    </div>
                    {{-- // --}}
                    <div class="mb-4">
                        @error('nombrep')
                            <p class="text-sm text-red-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                        @error('precio')
                            <p class="text-sm text-red-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                        @error('peso_neto')
                            <p class="text-sm text-red-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                        @error('foto')
                            <p class="text-sm text-red-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- // --}}
                    <input type="hidden" name="usuario_id" value="{{auth()->user()->id_usuario}}">
                    {{-- // --}}
                    <div class="flex gap-2 sm:gap-5 w-full items-center justify-center">
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
    @if(session('Actualizado') == 'ok')
        <script>
            Swal.fire(
                'Actualizado!',
                'El producto se actualizó con exito!',
                'success'
            )
        </script>
    @endif
    <script>
        $('.form_edit').submit(function(e){
            e.preventDefault();
                Swal.fire({
                    title: '¿Estás Seguro?',
                    text: "Se actualizarán los datos del producto",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed){
                        this.submit();
                    }
                })
            })
    </script>
@endsection