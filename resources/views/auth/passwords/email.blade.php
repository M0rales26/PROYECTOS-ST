@extends('layouts.app')
@section('title', 'Reestablecer Contraseña')

@section('content')
    <main class="flex items-center justify-center text-center w-full h-screen flex-1">
        <div class="flex items-center justify-center w-full sm:w-4/5 lg:w-8/12 sm:px-6 lg:px-0 px-3">
            <div class="bg-white rounded-2xl shadow-2xl sm:w-full lg:w-full xl:w-3/5 w-full">
                <div class="p-5 h-full">
                    <div class="text-left text-xl font-bold">
                        <span class="text-primary">Sol</span>Tiend
                    </div>
                    <div class="flex flex-col">
                        <div class="my-6">
                            <h2 class="text-3xl font-bold text-primary mb-1">Restablecer Contraseña</h2>
                            <div class="border-2 w-10 border-primary inline-block mb-2"></div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('password.email') }}" class="flex flex-col items-center">
                        @csrf
                        <div class="sm:w-[90%] w-full bg-gray-200 flex items-center rounded-xl">
                            <img src="{{ asset('iconos/email.svg') }}" class="nav ml-4">
                            <input type="email" name="email" class="w-full outline-none px-3 pr-5 py-2 bg-transparent placeholder:text-black @error('email') is-invalid @enderror" placeholder="Correo Electrónico" value="{{ old('email') }}" autocomplete="off">
                        </div>
                        {{-- // --}}
                        <div class="mt-2">
                            @error('email')
                                <p class="text-sm text-red-600 font-semibold mt-3">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="">
                            @if (session('status'))
                                <p class="text-md text-green-600 font-semibold mt-3">{{ session('status') }}</p>
                            @endif
                        </div>
                        {{-- // --}}
                        <div class="flex gap-2 sm:gap-5 w-full items-center justify-center mt-6">
                            <button type="submit" class="text-white rounded-full px-7 sm:px-12 py-2 font-semibold bg-primary hover:scale-105 duration-300 flex items-center justify-center">
                                <img src="{{ asset('iconos/mailsend.svg') }}" class="nav mr-1"> Confirmar
                            </button>
                            <a href="{{route('login.index')}}" class="text-white rounded-full px-7 sm:px-12 py-2 font-semibold bg-gray-500 hover:scale-105 duration-300 cursor-pointer flex items-center justify-center">
                                <img src="{{ asset('iconos/x.svg') }}" class="nav mr-1"> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection