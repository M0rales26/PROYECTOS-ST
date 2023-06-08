<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    @vite(['resources/js/app.js'])
    <title>SolTiend - @yield('title')</title>
</head>
<body class="font-[Poppins] bg-gray-100 h-screen">
    @yield('content')
</body>
</html>
