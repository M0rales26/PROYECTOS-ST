@extends('layouts.menu')
@section('title', 'Tiendas' )

@section('content')
    <div class="px-6 pt-6 pb-2">
        <div class="mb-6 sm:mb-6 lg:mb-10 py-2 flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
            <form action="{{route('tiendas.index')}}" method="GET" class="flex w-full sm:w-2/4 items-center gap-2">
                <input type="text" placeholder="¿Qué deseas buscar...?" name="texto" value="{{$texto}}" autocomplete="off" class="w-full lg:w-96 h-10 p-2 outline-none bg-none font-semibold rounded-lg border-2 border-primary text-primary placeholder:text-center placeholder:text-primary">
                <button type="submit" class="bg-primary text-white px-5 py-2 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 h-10 sm:h-auto">
                    <img src="{{ asset('iconos/search.svg') }}" class="nav"> <span class="hidden sm:block"> Buscar</span>
                </button>
            </form>
            <h1 class="mr-0 sm:mr-12 lg:mr-40 mt-6 sm:mt-0 text-4xl font-bold text-center uppercase text-primary">Tiendas</h1>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-6 mb-6 place-items-center">
            @foreach ($tiendas as $shop)
                <a href="{{route('tiendainfo.index',['id' => $shop->id_usuario])}}" class="bg-gray-200 p-6 rounded-lg shadow-xl w-full sm:w-auto flex items-center justify-center flex-col">
                    <div class="mb-4">
                        <img src="imguser/{{$shop->fotop}}" class="w-48 sm:w-52 h-48 sm:h-52 border-2 border-primary rounded-lg bg-white">
                    </div>
                    <div class="text-xl font-bold text-primary">
                        <h2 class="">{{$shop->name}}</h2>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <div class="flex w-full items-center justify-center">
        {{$tiendas->links("pagination::my-pagination")}}
    </div>
@endsection