<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RECIBO PARAMETRIZADO</title>
</head>
<body>
    <h1>productos mas vendidos</h1>
    @foreach ($top_productos as $item)
        <p>{{$item->nombrep}}</p>
        <p>{{$item->name}}</p>
    @endforeach

    <h1>clientes que mas compran</h1>
    @foreach ($top_clientes as $item)
        <p>{{$item->name}}</p>
    @endforeach

    <h1>mejores vendedores</h1>
    @foreach ($top_vendedores as $item)
        <p>{{$item->name}}</p>
    @endforeach
    <!-- @foreach ($top_clientes as $item)
        <p>{{$item->cliente_id}}</p>
    @endforeach -->
</body>
</html>