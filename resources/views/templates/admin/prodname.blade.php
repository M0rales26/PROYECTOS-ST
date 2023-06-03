@extends('layouts.menu')
@section('title', 'Lista Nombre Productos' )

@section('content')
    <div class="p-6">
        <div class="w-full mb-6 flex justify-center">
            <a href="{{route('nombres.create')}}" class="w-full sm:w-96 lg:w-80 bg-primary text-white px-5 py-2 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 font-semibold">
                <img src="{{ asset('iconos/plus.svg') }}" class="nav"> Agregar Nombre de Producto
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
            @foreach ($nombres as $name)
                <div class="bg-gray-200 p-6 rounded-lg shadow-xl flex items-center justify-center flex-col">
                    <div class="w-full text-center font-medium mb-4">
                        <p class="text-xl uppercase text-primary">N° {{ ($nombres->currentPage() - 1) * $nombres->perPage() + $loop->index + 1 }}</p>
                        <p class="text-md uppercase text-primary">{{$name->nombre}}</p>
                    </div>
                    <div class="flex justify-center gap-2 sm:gap-3 lg:gap-4 w-full sm:w-auto">
                        <form action="{{url('/nombres/'. $name->id_nombrep.'/edit/')}}">
                            <button type="submit" class="bg-primary text-white font-semibold px-7 sm:px-5 py-2 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300">
                                <img src="{{ asset('iconos/edit.svg') }}" class="nav"> Editar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="flex w-full items-center justify-center">
        {{$nombres->links("pagination::my-pagination")}}
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
                'El nombre de producto se agregó con exito!',
                'success'
            )
        </script>
    @endif
    @if(session('Eliminado') == 'ok')
        <script>
            Swal.fire(
                'Eliminado!',
                'El nombre de producto se eliminó con exito!',
                'success'
            )
        </script>
    @endif
    @if(session('Actualizado') == 'ok')
        <script>
            Swal.fire(
                'Actualizado!',
                'El nombre de producto se actualizó con exito!',
                'success'
            )
        </script>
    @endif
    <script>
        $('.form_delete').submit(function(e){
            e.preventDefault();
                Swal.fire({
                    title: '¿Estás Seguro?',
                    text: "Se eliminará definitivamente el nombre de producto",
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