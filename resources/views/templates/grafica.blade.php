@extends('layouts.menu')
@section('title', 'Gráfica Producto')

@section('content')
    <div class="flex items-center justify-center w-full h-screen p-2 sm:p-5">
        <div class="bg-gray-200 w-full rounded-lg shadow-xl p-3 sm:p-6">
            <div class="flex items-center justify-center sm:justify-normal text-2xl text-primary py-2 sm:px-32 font-semibold uppercase">
                @foreach ($producto as $prd)
                @endforeach
                    <h1>{{ $prd->nombrep }}</h1>
            </div>
            <canvas id="myChart"></canvas>
            <script>
                const ctx = document.getElementById('myChart').getContext('2d');
                const myChart = new Chart(ctx, {
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
                            xAxes: [{
                                type: 'time',
                                time: {
                                    unit: 'day',
                                    displayFormats: {
                                        day: 'MMM D'
                                    }
                                },
                                distribution: 'linear'
                            }]
                        }
                    }
                });
            </script>
        </div>
    </div>
@endsection