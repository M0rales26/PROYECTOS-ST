@extends('layouts.menu')
@section('title', 'Lista Nombre Productos' )

@section('content')
    <div class="p-6">
        <div class="mb-6 py-2 flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-0">
            <form action="{{route('nombres.index')}}" method="GET" class="flex w-full sm:w-2/4 items-center gap-2">
                <input type="text" placeholder="¿Qué deseas buscar...?" name="texto" value="{{$texto}}" autocomplete="off" class="w-full lg:w-96 h-10 p-2 outline-none bg-none font-semibold rounded-lg border-2 border-primary text-primary placeholder:text-center placeholder:text-primary">
                <button type="submit" class="bg-primary text-white px-5 py-1 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 h-10">
                    <img src="{{ asset('iconos/search.svg') }}" class="nav"> <span class="hidden sm:block"> Buscar</span>
                </button>
            </form>
            <a href="{{route('nombres.create')}}" class="bg-primary text-white px-5 py-2 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 font-semibold mr-12">
                <img src="{{ asset('iconos/plus.svg') }}" class="nav"> Agregar Nombre
            </a>
        </div>
        {{-- // --}}
        <div class="bg-gray-200 p-5 shadow-lg rounded-xl overflow-x-scroll sm:overflow-hidden w-full">
            <table class="w-full border-separate border-spacing-y-3 border-spacing-x-1">
                <thead class="text-primary text-xl">
                    <tr>
                        <th class="w-24">N°</th>
                        <th class="w-96">Nombre Producto</th>
                        <th class="w-44">Estado</th>
                        <th class="w-44">Opciones</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($nombres as $name)
                        <tr>
                            <td class="">N° {{ ($nombres->currentPage() - 1) * $nombres->perPage() + $loop->index + 1 }}</td>
                            <td class="">{{$name->nombre}}</td>
                            <td class="">{{$name->estado}}</td>
                            <td class="">
                                <div class="flex justify-center gap-5">
                                    <form action="{{url('/nombres/'. $name->id_nombrep.'/edit/')}}">
                                        <button type="submit" class="bg-primary text-white font-semibold px-7 sm:px-5 py-2 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300" title="EDITAR">
                                            <img src="{{ asset('iconos/edit.svg') }}" class="nav">
                                        </button>
                                    </form>
                                    @if ($name->estado=='HABILITADO')
                                        <a href="{{route('change.status.name',$name->id_nombrep)}}" type="submit" class="bg-false text-white px-5 py-2 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 w-42 font-medium" title="DESHABILITAR">
                                            <img src="{{ asset('iconos/change.svg') }}" class="nav">
                                        </a>
                                    @else
                                        <a href="{{route('change.status.name',$name->id_nombrep)}}" type="submit" class="bg-check text-white px-5 py-2 rounded-lg text-sm flex items-center justify-center gap-2 hover:scale-105 duration-300 w-42 font-medium" title="HABILITAR">
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
    <div class="flex w-full items-center justify-center">
        {{$nombres->links("pagination::my-pagination")}}
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
                'El nombre de producto se agregó con exito!',
                'success'
            )
        </script>
    @endif
    @if(session('Eliminado') == 'ok')
        <script>
            Swal.fire(
                'Eliminado!',
                'El nombre de producto se eliminó con exito!',
                'success'
            )
        </script>
    @endif
    @if(session('Actualizado') == 'ok')
        <script>
            Swal.fire(
                'Actualizado!',
                'El nombre de producto se actualizó con exito!',
                'success'
            )
        </script>
    @endif
    <script>
        $('.form_delete').submit(function(e){
            e.preventDefault();
                Swal.fire({
                    title: '¿Estás Seguro?',
                    text: "Se eliminará definitivamente el nombre de producto",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed){
                        this.submit();
                    }
                })
            })
    </script>
@endsection