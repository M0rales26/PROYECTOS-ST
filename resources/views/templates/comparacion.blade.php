@extends('layouts.menu')
@section('title', 'Comparación' )

@section('content')
    <div class="px-6 pt-6 pb-2">
        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
            @foreach ($producto as $com)
                <div class="bg-gray-200 p-6 rounded-lg shadow-xl flex items-center justify-center flex-col">
                    <div class="mb-4">
                        <img src="/imgprod/{{$com->foto}}" class="w-52 h-52 rounded-lg bg-white">
                    </div>
                    <div class="w-full text-center font-medium">
                        <p class="font-semibold text-primary">{{$com->name}}</p>
                        <p class="text-md">{{$com->nombrep}}</p>
                        <p>${{$com->precio}}</p>
                        <p>{{$com->peso_neto}}</p>
                        <p class="font-bold text-sky-600">Disponibles: {{$com->stock}}</p>
                    </div>
                    <div class="flex flex-col gap-2 mt-4 w-[95%]">
                        <form action="{{route('cart.store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="products_id" id="products_id" value="{{$com->id_producto}}">
                            <button type="submit" class="bg-primary text-white px-5 py-1 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 w-full">
                                <img src="{{ asset('iconos/carrito2.svg') }}" class="nav">  Agregar
                            </button>
                        </form>
                        <form action="{{route('grafica.producto',$com->id_producto)}}">
                            <button type="submit" class="bg-false text-white px-5 py-1 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 w-full">
                                <img src="{{ asset('iconos/chart.svg') }}" class="nav"> Ver Gráfica
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="flex w-full items-center justify-center">
        {{$producto->links("pagination::my-pagination")}}
    </div>
@endsection