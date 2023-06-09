@extends('layouts.menu')
@section('title', 'Estadísticas' )

@section('content')
    <div class="px-6 pt-6 pb-2">
        <div class="w-4/6 p-5 bg-gray-200 rounded-lg shadow-lg flex items-center justify-between gap-5">
            <p class="w-1/2 font-semibold text-primary uppercase">Filtrar las estadísticas por mes y año:</p>
            <form action="{{route('parametrizado.index')}}" method="GET" class="w-1/2 flex gap-4">
                <select name="mes" class="outline-none px-3 py-1 bg-transparent w-1/2 border-2 border-primary appearance-none rounded-lg text-center">
                    <option value="1" class="bg-gray-200">Enero</option>
                    <option value="2" class="bg-gray-200">Febrero</option>
                    <option value="3" class="bg-gray-200">Marzo</option>
                    <option value="4" class="bg-gray-200">Abril</option>
                    <option value="5" class="bg-gray-200">Mayo</option>
                    <option value="6" class="bg-gray-200">Junio</option>
                    <option value="7" class="bg-gray-200">Julio</option>
                    <option value="8" class="bg-gray-200">Agosto</option>
                    <option value="9" class="bg-gray-200">Septiembre</option>
                    <option value="10" class="bg-gray-200">Octubre</option>
                    <option value="11" class="bg-gray-200">Noviembre</option>
                    <option value="12" class="bg-gray-200">Diciembre</option>
                </select>
                <select name="anio" class="outline-none px-3 py-1 bg-transparent w-1/2 border-2 border-primary appearance-none rounded-lg text-center">
                    <option value="2023" class="bg-gray-200">2023</option>
                    <option value="2024" class="bg-gray-200">2024</option>
                    <option value="2025" class="bg-gray-200">2025</option>
                </select>
                <button type="submit" class="bg-primary text-white font-semibold px-2 sm:px-5 py-1 rounded-lg text-sm flex items-center justify-center gap-1 sm:gap-2 hover:scale-105 duration-300 w-1/2">
                    Ver
                </button>
            </form>
        </div>
        <div class="flex py-5 gap-4 text-center mt-[10%]">
            @if (isset($error))
                <div class="bg-gray-200 p-5 w-[33%] rounded-xl shadow-lg">
                    <h1 class="text-primary text-xl uppercase font-semibold mb-4">productos más vendidos</h1>
                        <p class="py-2 text-lg">No hay datos</p>
                </div>
                <div class="bg-gray-200 p-5 w-[33%] rounded-xl shadow-lg">
                    <h1 class="text-primary text-xl uppercase font-semibold mb-4">clientes que más compran</h1>
                        <p class="py-2 text-lg">No hay datos</p>
                </div>
                <div class="bg-gray-200 p-5 w-[33%] rounded-xl shadow-lg">
                    <h1 class="text-primary text-xl uppercase font-semibold mb-4">mejores vendedores</h1>
                        <p class="py-2 text-lg">No hay datos</p>
                </div>
            @else
                <div class="bg-gray-200 p-5 w-[33%] rounded-xl shadow-lg">
                    <h1 class="text-primary text-xl uppercase font-semibold mb-4">productos más vendidos</h1>
                    @foreach ($top_productos as $item)
                        <div class="text-lg py-2 mb-1">
                            <p class="text-sm text-primary">{{$item->name}}</p>
                            <p>{{$item->nombrep}}</p>
                        </div>
                        @endforeach
                    </div>
                <div class="bg-gray-200 p-5 w-[33%] rounded-xl shadow-lg">
                    <h1 class="text-primary text-xl uppercase font-semibold mb-4">clientes que más compran</h1>
                    @foreach ($top_clientes as $item)
                        <div class="text-lg py-2 mb-1">
                            <p class="text-sm text-primary">{{ $loop->iteration }}°</p>
                            <p>{{$item->name}}</p>
                        </div>
                    @endforeach
                </div>
                <div class="bg-gray-200 p-5 w-[33%] rounded-xl shadow-lg">
                    <h1 class="text-primary text-xl uppercase font-semibold mb-4">mejores vendedores</h1>
                    @foreach ($top_vendedores as $item)
                        <div class="text-lg py-2 mb-1">
                            <p class="text-sm text-primary">{{ $loop->iteration }}°</p>
                            <p>{{$item->name}}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <link href="{{asset('assets/css/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
    @if(isset($error))
        <script>
            Swal.fire(
                '',
                '{{ $error }}',
                'error'
            )
        </script>
    @endif
@endsection