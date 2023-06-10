@extends('layouts.menu')
@section('title', 'Carrito' )

@section('content')
    @if (count(Cart::getContent()))
        {{-- // --}}
        @foreach ($cartCollection as $item)
        @endforeach
        {{-- // --}}
        <div class="px-6 pt-6 pb-2">
            <div class="w-full mb-6 flex flex-col sm:flex-row items-center justify-between">
                <div class="flex items-center ml-2">
                    <h2 class="text-2xl font-bold text-center uppercase text-primary flex gap-2">
                        <img src="{{ asset('iconos/coins.svg') }}" class="">
                        Valor Total: {{Cart::getTotal()}}
                    </h2>
                </div>
                <div class="flex items-center gap-4 mr-12">
                    <form action="{{route('proveedor.clear')}}" method="POST">
                        @csrf
                        <input type="hidden" name="products_id" id="products_id" value="{{$item->id_producto}}">
                        <button type="submit" class="bg-primary text-white font-semibold px-5 py-2 rounded-lg text-sm flex items-center justify-center gap-1 sm:gap-2 hover:scale-105 duration-300">
                            <img src="{{ asset('iconos/trash.svg') }}" class="nav"> Vaciar Carrito
                        </button>
                    </form>
                    <form action="{{route('factura.save')}}" method="POST">
                        @csrf
                        @foreach ($cartCollection as $prod)
                        <tr>
                            <input type="hidden" name="id[]" value="{{$prod->id}}">
                            <input type="hidden" name="cliente_id" value="{{auth()->user()->id_usuario}}">
                            <input type="hidden" name="total_prod[]" value="{{$prod->price * $prod->quantity}}">
                            <input type="hidden" name="cantidad[]" value="{{$prod->quantity}}">
                            <input type="hidden" name="id_tendero[]" value="{{$prod->attributes->id_tendero}}">
                        </tr>
                        @endforeach
                        <input type="hidden" name="total" value="{{Cart::getTotal()}}">
                        <button type="submit" class="bg-primary text-white px-5 py-2 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 font-semibold">
                            <img src="{{ asset('iconos/checkfull.svg') }}" class="nav"> Confirmar Compra
                        </button>
                    </form>
                </div>
            </div>
            {{-- // --}}
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-6 place-items-center">
                @foreach ($cartCollection as $prd)
                    <div class="bg-gray-200 p-6 rounded-lg shadow-xl w-full sm:w-auto flex items-center justify-center flex-col">
                        <div class="mb-4">
                            <img src="{{ url('imgprod/' . $prd->attributes->imagen)}}" class="w-52 h-52 rounded-lg bg-white">
                        </div>
                        <div class="text-center">
                            <p>{{$prd->name}}</p>
                            <p>${{$prd->price}}</p>
                            <p>{{$prd->attributes->descripcion}}</p>
                            <p class="font-bold text-red-600">Cantidad: {{$prd->quantity}}</p>
                        </div>
                        <div class="flex flex-col gap-2 mt-4 w-full sm:w-auto">
                            <div class="px-2 sm:px-4 py-2">
                                <form action="{{route('cart.update')}}" method="POST" class="flex items-center justify-center gap-2">
                                    @csrf
                                    <div class="">
                                        <input type="hidden" name="id" id="id" value="{{$prd->id}}">
                                        <input type="number" name="quantity" id="quantity" value="{{$prd->quantity}}" autocomplete="off" class="w-44 sm:w-24 rounded-lg bg-white px-4 py-1 text-center outline-none border-2 border-primary">
                                    </div>
                                    <div class="">
                                        <button type="submit" class="bg-primary grid place-items-center h-8 w-8  rounded-full hover:scale-105 duration-300">
                                            <img src="{{ asset('iconos/checkfull.svg') }}" class="nav">
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="w-full flex items-center justify-center">
                                <form action="{{route('cart.remove')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$prd->id}}">
                                    <button type="submit" class="bg-check text-white px-16 sm:px-5 py-1 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300">
                                        <img src="{{ asset('iconos/xfull.svg') }}" class="nav"> Remover
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @else
            <div class="grid place-items-center w-full h-screen px-6">
                <div class="grid place-items-center gap-6 p-3 bg-gray-200 shadow-xl rounded-lg w-full sm:w-3/4 lg:w-1/2">
                    <div class="flex items-center justify-center">
                        <h2 class="font-semibold text-2xl">
                            ¡Carrito Vacio!
                        </h2>
                    </div>
                </div>
            </div>
        @endif
@endsection
@section('js')
    <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <link href="{{asset('assets/css/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
    @if(session('success'))
        <script>
            Swal.fire(
                '',
                'La compra se registró con exito!',
                'success'
            )
        </script>
    @endif
    @if(session('error'))
        <script>
            Swal.fire(
                '',
                'No hay suficiente cantidad de productos disponible.',
                'warning'
            )
        </script>
    @endif
@endsection