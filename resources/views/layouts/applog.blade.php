<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="{{asset('css/Swing.css')}}">
    <script src=" {{asset('js/tailwin.js')}} "></script>
    {{-- // --}}
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: '#5556a6',
                            check: '#055329',
                        }
                    }
                }
            }
        </script>
    {{-- // --}}
    @vite('resources/css/app.css')
    <title>SolTiend - @yield('title')</title>
</head>
<body class="font-[Poppins] bg-gray-100 h-screen">
    @yield('content')
</body>
</html>