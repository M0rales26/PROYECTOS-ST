@extends('layouts.menu')
@section('title', 'Productos' )

@section('content')
    <div class="px-6 pt-6 pb-2">
        <div class="mb-6 sm:mb-6 lg:mb-10 py-2 flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
            <form action="{{route('shop')}}" method="GET" class="flex w-full sm:w-2/4 items-center gap-2">
                <input type="text" placeholder="¿Qué deseas buscar...?" name="texto" value="{{$texto}}" autocomplete="off" class="w-full lg:w-96 h-10 p-2 outline-none bg-none font-semibold rounded-lg border-2 border-primary text-primary placeholder:text-center placeholder:text-primary">
                <button type="submit" class="bg-primary text-white px-5 py-1 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 h-10">
                    <img src="{{ asset('iconos/search.svg') }}" class="nav"> <span class="hidden sm:block"> Buscar</span>
                </button>
            </form>
            <h1 class="mr-0 sm:mr-12 lg:mr-40 mt-6 sm:mt-0 text-4xl font-bold text-center uppercase text-primary">Productos</h1>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
            @foreach ($producto as $prd)
                <div class="bg-gray-200 p-6 rounded-lg shadow-xl flex items-center justify-center flex-col">
                    <div class="mb-4">
                        <img src="{{ url('imgprod/' . $prd->foto)}}" class="w-52 h-52 border-2 border-primary rounded-lg bg-white">
                    </div>
                    <div class="w-full text-center font-medium">
                        <p class="text-md">{{$prd->nombrep}}</p>
                        <p>${{$prd->precio}}</p>
                        <p>{{$prd->peso_neto}}</p>
                        <p class="font-semibold text-primary">{{$prd->name}}</p>
                    </div>
                    <div class="flex flex-col gap-2 mt-4 w-[95%] sm:w-full">
                        <form action="{{route('cart.store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="products_id" id="products_id" value="{{$prd->id_producto}}">
                            <button type="submit" class="bg-primary text-white px-5 py-1 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 w-full font-medium">
                                <img src="{{ asset('iconos/carrito2.svg') }}" class="nav">  Agregar
                            </button>
                        </form>
                        <form action="{{route('comparar')}}" method="GET">
                            <input type="hidden" name="boton" value="{{$prd->nombrep}}">
                            <button type="submit" class="bg-[#055329] text-white px-5 py-1 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 w-full font-medium">
                                <img src="{{ asset('iconos/merge.svg') }}" class="nav"> Comparar
                            </button>
                        </form>
                        <form action="{{route('grafica.producto',$prd->id_producto)}}">
                            <button type="submit" class="bg-[#e83838] text-white px-5 py-1 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 w-full font-medium">
                                <img src="{{ asset('iconos/chart.svg') }}" class="nav"> Ver Gráfica
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div   >
    <div class="flex w-full items-center justify-center">
        {{$producto->links("pagination::my-pagination")}}
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
                'El producto se agregó al carrito con exito!',
                'success'
            )
        </script>
    @endif
    @if(session('error'))
        <script>
            Swal.fire(
                '',
                'El producto seleccionado no tiene stock disponible.',
                'warning'
            )
        </script>
    @endif
@endsection