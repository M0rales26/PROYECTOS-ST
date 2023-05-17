@extends('layouts.menu')
@section('title', 'Facturas Pendientes' )

@section('content')
    @if (isset($error))
        <div class="grid place-items-center w-full h-screen px-5">
            <div class="flex items-center justify-around gap-6 p-3 bg-gray-200 shadow-xl rounded-lg w-full sm:w-[80%] lg:w-[50%]">
                <div class="flex items-center justify-center gap-2">
                    <h2 class="font-semibold text-lg sm:text-2xl">
                        {{ $error }}
                    </h2>
                </div>
            </div>
        </div>
    @else
        <div class="px-6 pt-6 pb-2">
            <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-6 mb-6 place-items-center">
                @foreach ($facturas as $fact)
                    <div class="bg-gray-200 p-6 rounded-lg shadow-xl w-full h-72 gap-6 flex items-center justify-between flex-col">
                        <div class="w-full text-center text-xl">
                            <p class="font-bold uppercase text-primary">Factura N° {{ $fact->factura_id }}</p>
                        </div>
                        <div class="text-center">
                            <p class="flex flex-col">
                                <span class="text-md font-semibold">Realizada por:</span>
                                <span class="text-lg text-primary">{{$fact->name}}</span>
                            </p>
                        </div>
                        <div class="w-full text-center flex flex-col gap-1">
                            <p class="font-semibold">Estado de la Factura</p>
                            @if ($fact->estado == 'PENDIENTE')
                                <a href="{{route('change.status.fact', ['id'=>$fact->factura_id])}}" class="text-red-500">PENDIENTE</a>
                            @else
                                <a href="{{route('change.status.fact', ['id'=>$fact->factura_id])}}" class="text-lime-500">COMPLETADO</a>
                            @endif
                        </div>
                        <div class="w-[85%]">
                            <form action="{{route('factura.pdf2',['id'=>$fact->factura_id])}}" method="get" class="grid place-items-center">
                                <button type="submit" class="bg-primary text-white font-semibold px-2 sm:px-5 py-1 rounded-lg text-sm flex items-center justify-center gap-1 sm:gap-2 hover:scale-105 duration-300 w-full">
                                    <img src="{{ asset('iconos/pdf.svg') }}" class="nav"> Ver Factura
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    {{-- // --}}
    {{$facturas->links("pagination::my-pagination")}}
@endsection