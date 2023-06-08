@extends('layouts.menu')
@section('title', 'Pedidos Pendientes' )

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
            <div class="bg-gray-200 p-5 shadow-lg rounded-xl w-full">
                <table class="w-full border-separate border-spacing-y-3 border-spacing-x-1">
                    <thead class="text-primary text-xl">
                        <tr>
                            <th class="w-24">Pedido N°</th>
                            <th class="w-96">Realizada Por</th>
                            <th class="w-44">Estado</th>
                            <th class="w-44">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($facturas as $fact)
                            <tr>
                                <td class="">N° {{ $fact->factura_id}}</td>
                                <td class="">{{$fact->name}}</td>
                                <td class="">{{$fact->estado}}</td>
                                <td class="">
                                    <div class="flex justify-center gap-5">
                                        <form action="{{route('factura.pdf2',['id'=>$fact->factura_id])}}">
                                            <button type="submit" class="bg-primary text-white font-semibold px-7 sm:px-5 py-2 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300" title="Ver Comprobante">
                                                <img src="{{ asset('iconos/pdf.svg') }}" class="nav">
                                            </button>
                                        </form>
                                        @if ($fact->estado=='PENDIENTE')
                                            <a href="{{route('change.status.fact', ['id'=>$fact->factura_id])}}" type="submit" class="bg-check text-white px-5 py-2 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 w-42 font-medium" title="Cambiar a Completado">
                                                <img src="{{ asset('iconos/change.svg') }}" class="nav">
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    {{-- // --}}
    <div class="flex w-full items-center justify-center">
        {{$facturas->links("pagination::my-pagination")}}
    </div>
@endsection