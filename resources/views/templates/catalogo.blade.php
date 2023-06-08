@extends('layouts.menu')
@section('title', 'Catálogo de Productos' )

@section('content')
    <div class="px-6 pt-6 pb-2">
        <div class="w-full mb-6 flex flex-col sm:flex-row items-center justify-end">
            <div class="flex items-center gap-4 mr-12">
                <a href="{{route('producto.create')}}" class="bg-primary text-white px-5 py-2 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 font-semibold">
                    <img src="{{ asset('iconos/plus.svg') }}" class="nav"> Agregar Producto
                </a>
                <a href="{{route('proveedor.index')}}" class="bg-primary text-white px-5 py-2 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 font-semibold">
                    <img src="{{ asset('iconos/shop.svg') }}" class="nav"> Pedido Proveedor
                </a>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-6 place-items-center">
            @foreach ($producto as $prd)
                <div class="bg-gray-200 p-6 rounded-lg shadow-xl flex items-center justify-center flex-col">
                    <div class="mb-4">
                        <img src="{{ url('imgprod/' . $prd->foto)}}" class="w-52 h-52 bg-white rounded-lg">
                    </div>
                    <div class="w-full text-center font-medium mb-2">
                        <p class="text-md">{{$prd->nombrep}}</p>
                        <p>${{$prd->precio}}</p>
                        <p>{{$prd->peso_neto}}</p>
                        <p class="text-red-500 font-semibold text-sm mt-3"> Cantidad Disponible: {{$prd->stock}}</p>
                        <p class="text-sky-500 font-semibold text-sm mt-2"> Estado: {{$prd->estado}}</p>
                    </div>
                    <div class="flex flex-col gap-2 mt-3 w-[95%] sm:w-full">
                        <form action="{{route('proveedor.store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="products_id" id="products_id" value="{{$prd->id_producto}}">
                            <button type="submit" class="bg-primary text-white px-5 py-1 rounded-lg text-sm md:text-xs lg:text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 w-full font-medium">
                                <img src="{{ asset('iconos/cart-add.svg') }}" class="nav">  Agregar a Pedido
                            </button>
                        </form>
                        @if ($prd->estado=='HABILITADO')
                            <a href="{{route('change.status',$prd->id_producto)}}" type="submit" class="bg-false text-white px-5 py-1 rounded-lg text-sm md:text-xs lg:text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 w-full font-medium">
                                <img src="{{ asset('iconos/change.svg') }}" class="nav"> Deshabilitar
                            </a>
                        @else
                            <a href="{{route('change.status',$prd->id_producto)}}" type="submit" class="bg-check text-white px-5 py-1 rounded-lg text-sm md:text-xs lg:text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 w-full font-medium">
                                <img src="{{ asset('iconos/change.svg') }}" class="nav"> Habilitar
                            </a>
                        @endif
                        <form action="{{url('/producto/'.$prd->id_producto.'/edit/')}}" method="GET">
                            <button type="submit" class="bg-yellow-500 text-white px-5 py-1 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 w-full font-medium">
                                <img src="{{ asset('iconos/edit.svg') }}" class="nav"> Editar Producto
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