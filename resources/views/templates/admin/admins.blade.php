@extends('layouts.menu')
@section('title', 'Lista Nombre Productos' )

@section('content')
    <div class="px-6 pt-6 pb-2">
        <div class="w-full mb-6 flex flex-col sm:flex-row items-center justify-end">
            <div class="flex items-center gap-4 mr-12">
                <a href="{{route('admins.create')}}" class="bg-primary text-white px-5 py-2 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 font-semibold">
                    <img src="{{ asset('iconos/plus.svg') }}" class="nav"> Agregar Administrador
                </a>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-6 mb-6 place-items-center">
            @foreach ($admins as $admin)
                <div class="bg-gray-200 p-6 rounded-lg shadow-xl w-full sm:w-auto flex items-center justify-center flex-col">
                    <div class="mb-4">
                        <img src="{{ url('imguser/' . $admin->fotop)}}" class="w-48 sm:w-52 h-48 sm:h-52 border-2 border-primary rounded-lg bg-white">
                    </div>
                    <div class="text-xl font-bold text-primary">
                        <h2 class="">{{$admin->name}}</h2>
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
                'El administrador se creó con exito!',
                'success'
            )
        </script>
    @endif
@endsection