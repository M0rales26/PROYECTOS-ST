@extends('layouts.menu')
@section('title', 'Catálogo de Productos' )

@section('content')
    <div class="p-6">
        <div class="w-full mb-6 flex justify-center">
            <a href="{{route('producto.create')}}" class="w-full sm:w-96 lg:w-80 bg-primary text-white px-5 py-2 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 font-semibold">
                <img src="{{ asset('iconos/plus.svg') }}" class="nav"> Agregar Producto
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
            @foreach ($producto as $prd)
                <div class="bg-gray-200 p-6 rounded-lg shadow-xl flex items-center justify-center flex-col">
                    <div class="mb-4">
                        <img src="{{ url('imgprod/' . $prd->foto)}}" class="w-52 h-52 bg-white border-2 border-primary rounded-lg">
                    </div>
                    <div class="w-full text-center font-medium">
                        <p class="text-md">{{$prd->nombrep}}</p>
                        <p>${{$prd->precio}}</p>
                        <p>{{$prd->peso_neto}}</p>
                        <p class="text-red-500 font-semibold"> Stock {{$prd->stock}}</p>
                    </div>
                    <div class="w-full text-center my-4">
                        @if ($prd->estado=='HABILITADO')
                            <a href="{{route('change.status',$prd->id_producto)}}" class="text-sky-500">HABILITADO</a>
                        @else
                            <a href="{{route('change.status',$prd->id_producto)}}" class="text-red-500">DESHABILITADO</a>
                        @endif
                    </div>
                    <div class="flex justify-center gap-2 sm:gap-3 lg:gap-4 w-full sm:w-auto">
                        <form action="{{url('/producto/'.$prd->id_producto.'/edit/')}}">
                            <button type="submit" class="bg-primary text-white font-semibold px-7 sm:px-5 py-2 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300">
                                <img src="{{ asset('iconos/edit.svg') }}" class="nav"> Editar
                            </button>
                        </form>
                        <form action="" method="POST" class="form_delete">
                            <button class="bg-check text-white font-semibold px-7 sm:px-5 py-2 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300">
                                <img src="{{ asset('iconos/trash.svg') }}" class="nav"> Habilitar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <link href="{{asset('assets/css/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
    @if(session('success'))
        <script>
            Swal.fire(
                '',
                'El producto se agregó con exito!',
                'success'
            )
        </script>
    @endif
    @if(session('error'))
        <script>
            Swal.fire(
                '',
                'Hay productos sin stock, por favor actualicelos',
                'warning'
            )
        </script>
    @endif
    @if(session('Eliminado') == 'ok')
        <script>
            Swal.fire(
                'Eliminado!',
                'El producto se eliminó con exito!',
                'success'
            )
        </script>
    @endif
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
        $('.form_delete').submit(function(e){
            e.preventDefault();
                Swal.fire({
                    title: '¿Estás Seguro?',
                    text: "Se eliminará definitivamente el producto",
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