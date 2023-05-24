@extends('layouts.menu')
@section('title', 'Tienda' )

@section('content')
    <div class="p-6">
        <div class="flex justify-center mb-8">
            @foreach ($tendero as $pers)
            @endforeach
            {{-- // --}}
            <div class="bg-gray-200 p-4 rounded-lg shadow-xl w-full sm:w-3/4 lg:w-2/4 flex flex-col sm:flex-row items-center justify-around">
                <img src="{{ url('imguser/' . $pers->fotop)}}" class="w-52 h-52 border-2 border-primary rounded-lg bg-white">
                <div class="flex flex-col gap-2 p-8 text-xl text-primary font-medium">
                    <p>{{$pers->name}}</p>
                    <p>{{$pers->email}}</p>
                    <p>{{$pers->direccion}}</p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
            @foreach ($producto as $prd)
                <div class="bg-gray-200 p-6 rounded-lg shadow-xl w-full sm:w-full flex items-center justify-center flex-col">
                    <div class="mb-4">
                        <img src="{{ url('imgprod/' . $prd->foto)}}" class="w-52 h-52 border-2 border-primary rounded-lg bg-white">
                    </div>
                    <div class="text-center font-medium">
                        <p>{{$prd->nombrep}}</p>
                        <p>${{$prd->precio}}</p>
                        <p>{{$prd->peso_neto}}</p>
                        <p class="font-bold text-sky-600">Disponibles: {{$prd->stock}}</p>
                    </div>
                    <div class="flex flex-col gap-2 mt-4 w-[95%] sm:w-full">
                        <form action="{{route('cart.store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="products_id" id="products_id" value="{{$prd->id_producto}}">
                            <button type="submit" class="bg-primary text-white px-5 py-1 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 w-full">
                                <img src="{{ asset('iconos/carrito2.svg') }}" class="nav">  Agregar
                            </button>
                        </form>
                        <form action="{{route('grafica.producto',$prd->id_producto)}}">
                            <button type="submit" class="bg-[#e83838] text-white px-5 py-1 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 w-full">
                                <img src="{{ asset('iconos/chart.svg') }}" class="nav"> Ver Gráfica
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection