@extends('layouts.menu')
@section('title', 'Perfil de Usuario' )

@section('content')
    <div class="grid place-items-center w-full h-screen px-5">
        <div class="flex flex-col items-center justify-center w-full sm:w-4/5 lg:w-3/5 py-8 rounded-xl bg-gray-200 shadow-xl">
            <div class="flex flex-col sm:flex-row w-full items-center justify-center gap-8 sm:gap-14 mb-8">
                <div class="border-2 border-primary rounded-full">
                    <img src="{{ url('imguser/' . $datosperfil->fotop)}}" class="rounded-full w-64 h-64">
                </div>
                <div class="flex flex-col gap-4">
                    <div>
                        <span class="text-primary font-bold uppercase">Nombre</span>
                        <p class="text-xl">{{$datosperfil->name}}</p>
                    </div>
                    <div>
                        <span class="text-primary font-bold uppercase">Correo Electrónico</span>
                        <p class="text-xl">{{$datosperfil->email}}</p>
                    </div>
                    <div>
                        <span class="text-primary font-bold uppercase">Dirección</span>
                        <p class="text-xl">{{$datosperfil->direccion}}</p>
                    </div>
                </div>
            </div>
            <div class="w-full sm:w-auto grid place-items-center">
                <a href="{{url('editar', auth()->user()->id_usuario)}}" class="flex bg-primary text-white font-semibold items-center justify-center gap-2 px-5 py-2 rounded-lg hover:scale-105 duration-300 w-10/12 sm:w-auto">
                    <img src="{{ asset('iconos/edit.svg') }}" class="nav"> Editar Datos
                </a>
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
                '',
                'Los datos se actualizaron con exito!',
                'success'
            )
        </script>
    @endif
@endsection