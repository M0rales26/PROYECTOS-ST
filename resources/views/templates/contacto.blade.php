@extends('layouts.menu')
@section('title', 'Contacto')

@section('content')
    <div class="flex flex-col items-center justify-center text-center w-full h-screen flex-1 px-20">
        <div class="bg-gray-200 rounded-2xl shadow-xl w-[160%] sm:w-[100%] lg:w-[60%]">
            <div class="h-full p-5">
                <div class="my-4">
                    <h2 class="text-3xl font-bold text-primary mb-1">Contáctanos</h2>
                </div>
                <form action="{{route('enviar.correo')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="flex flex-col items-center gap-4 mb-6">
                        <div class="w-full sm:w-[80%] bg-gray-100 border-2 border-primary flex items-center rounded-xl">
                            <textarea name="texto" cols="15" rows="10" class="outline-none px-3 py-2 w-full bg-transparent resize-none" autocomplete="off"></textarea>
                        </div>
                    </div>
                    <div class="w-full flex items-center justify-center">
                        <button type="submit" class="text-white rounded-full px-7 sm:px-12 py-2 font-semibold bg-check hover:scale-105 duration-300 flex items-center justify-center">
                            <img src="{{ asset('iconos/check.svg') }}" class="nav mr-1"> Confirmar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection