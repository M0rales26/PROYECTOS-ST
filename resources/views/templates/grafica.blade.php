@extends('layouts.menu')
@section('title', 'Gráfica Producto')

@section('content')
    <div class="flex items-center justify-center w-full h-screen p-2 sm:p-5">
        <div class="bg-gray-200 w-full rounded-lg shadow-xl p-3 sm:p-6">
            <div class="flex items-center justify-between text-primary font-semibold uppercase mb-7">
                <div class="">
                    @foreach ($producto as $prd)
                    @endforeach
                    <h1 class="ml-20 text-2xl">{{ $prd->nombrep }}</h1>
                </div>
                <div class="mr-10 w-2/5">
                    <form action="{{route('grafica.producto',$prd->id_producto)}}" method="GET" class="flex gap-4">
                        <select name="mes" class="outline-none px-3 py-1 bg-transparent w-1/2 border-2 border-primary appearance-none rounded-lg text-center">
                            <option value="1" class="bg-gray-200">Enero</option>
                            <option value="2" class="bg-gray-200">Febrero</option>
                            <option value="3" class="bg-gray-200">Marzo</option>
                            <option value="4" class="bg-gray-200">Abril</option>
                            <option value="5" class="bg-gray-200">Mayo</option>
                            <option value="6" class="bg-gray-200">Junio</option>
                            <option value="7" class="bg-gray-200">Julio</option>
                            <option value="8" class="bg-gray-200">Agosto</option>
                            <option value="9" class="bg-gray-200">Septiembre</option>
                            <option value="10" class="bg-gray-200">Octubre</option>
                            <option value="11" class="bg-gray-200">Noviembre</option>
                            <option value="12" class="bg-gray-200">Diciembre</option>
                        </select>
                        <select name="anio" class="outline-none px-3 py-1 bg-transparent w-1/2 border-2 border-primary appearance-none rounded-lg text-center">
                            <option value="2023" class="bg-gray-200">2023</option>
                            <option value="2024" class="bg-gray-200">2024</option>
                            <option value="2025" class="bg-gray-200">2025</option>
                        </select>
                        <input type="hidden" name="id" value="{{ $prd->id_producto }}">
                        <button type="submit" class="w-1/2 bg-primary text-white rounded-lg">Ver</button>
                    </form>
                </div>
            </div>
            <canvas id="myChart"></canvas>
            <script>
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($fechas) !!},
                        datasets: [{
                            label: 'Precio del Producto',
                            data: {!! json_encode($precios) !!},
                            backgroundColor: '#5556A6',
                            borderColor: '#5556A6',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                ticks: {
                                    stepSize: 100,
                                    // Otras opciones de personalización de los ticks en el eje Y, si es necesario
                                }
                            }
                        }
                    }
                });
            </script>
        </div>
    </div>
@endsection