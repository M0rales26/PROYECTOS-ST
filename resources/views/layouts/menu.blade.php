<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/Swing.css') }}">
    <script src="{{ asset('js/chart.js') }}"></script>
    <script src=" {{asset('js/tailwin.js')}} "></script>
    {{-- // --}}
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: '#5556a6',
                            check: '#055329',
                            false: '#E83838',
                        }
                    }
                }
            }
        </script>
    {{-- // --}}
    @vite('resources/css/app.css')
    <title>SolTiend - @yield('title')</title>
</head>
<body class="font-[Poppins] bg-white h-screen scrollbar-none">
    @if (auth()->user()->rol_id == 1)
        <div class="fixed lg:p-5 max-w-64 h-screen">
            <div class="px-6 pt-8 w-[19rem] sm:w-[24rem] lg:w-64 bg-gray-200 h-full hidden sm:hidden lg:flex flex-col justify-between shadow-xl rounded-lg z-50 transition-all duration-300" id="menu">
                <div>
                    <div class="mb-8">
                        <a href="{{route('home.index')}}" class="text-primary font-bold text-3xl flex items-center justify-center gap-2">
                            <img src="{{ asset('iconos/logo.svg') }}"> SolTiend
                        </a>
                    </div>
                    {{-- // --}}
                    <h6 class="font-bold mb-4">General</h6>
                    <ul class="border-b-2 border-black mb-8">
                        <a href="{{route('home.index')}}">
                            <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                <img src="{{ asset('iconos/home.svg') }}" class="nav"> Inicio
                            </li>
                        </a>
                        <a href="{{route('shop')}}">
                            <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                <img src="{{ asset('iconos/lemon.svg') }}" class="nav"> Productos
                            </li>
                        </a>
                        <a href="{{route('tiendas.index')}}">
                            <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                <img src="{{ asset('iconos/store.svg') }}" class="nav"> Tiendas
                            </li>
                        </a>
                        <a href="{{route('historial.index')}}">
                            <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                <img src="{{ asset('iconos/archive.svg') }}" class="nav"> Historial
                            </li>
                        </a>
                    </ul>
                    {{-- // --}}
                    <h6 class="font-bold mb-4">Opciones</h6>
                    <ul class="">
                        <a href="{{url('perfil', auth()->user()->id_usuario)}}">
                            <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                <img src="{{ asset('iconos/user.svg') }}" class="nav"> Perfil
                            </li>
                        </a>
                        <a href="{{route('cart.index')}}">
                            <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                <img src="{{ asset('iconos/carrito.svg') }}" class="nav"> Carrito
                                <div class="w-5 h-5 grid place-items-center bg-primary text-xs text-white rounded-full">
                                    {{Cart::getTotalQuantity()}}
                                </div>
                            </li>
                        </a>
                        <a href="{{route('login.destroy')}}">
                            <li class="flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                <img src="{{ asset('iconos/logout.svg') }}" class="nav"> Cerrar Sesión
                            </li>
                        </a>
                    </ul>
                </div>
                {{-- // --}}
                <div class="font-bold py-4 flex items-center justify-center gap-2 text-primary text-xl">
                    @if (auth()->check())
                        <span>{{ auth()->user()->name}}</span>
                    @endif
                </div>
            </div>
        </div>
        <button onclick="toggleMenu()" class="xl:hidden fixed bottom-4 right-4 bg-primary p-3 rounded-full z-50">
            <img src="{{ asset('iconos/menu.svg') }}" id="icon">
        </button>
    @else
        @if (auth()->user()->rol_id == 2)
            <div class="fixed lg:p-5 max-w-64 h-screen">
                <div class="px-6 pt-8 w-[19rem] sm:w-[24rem] lg:w-64 bg-gray-200 h-full hidden sm:hidden lg:flex flex-col justify-between shadow-xl rounded-lg z-50 transition-all duration-300" id="menu">
                    <div>
                        <div class="mb-8">
                            <a href="{{route('home.index')}}" class="text-primary font-bold text-3xl flex items-center justify-center gap-2">
                                <img src="{{ asset('iconos/logo.svg') }}"> SolTiend
                            </a>
                        </div>
                        {{-- // --}}
                        <h6 class="font-bold mb-4">General</h6>
                        <ul class="border-b-2 border-black mb-8">
                            <a href="{{route('home.index')}}">
                                <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                    <img src="{{ asset('iconos/home.svg') }}" class="nav"> Inicio
                                </li>
                            </a>
                            <a href="{{route('producto.index')}}">
                                <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                    <img src="{{ asset('iconos/briefcase.svg') }}" class="nav"> Catálogo
                                </li>
                            </a>
                            <a class="cursor-pointer" onclick="toggleSubMenu()">
                                <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                    <img src="{{ asset('iconos/file.svg') }}" class="nav"> Pedidos
                                    <img src="{{ asset('iconos/chevronr.svg') }}" class="ml-8" id="chevron">
                                </li>
                            </a>
                            <div class="hidden" id="submenu">
                                <a href="{{route('pendiente.index')}}">
                                    <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:scale-105 duration-300">
                                        <img src="{{ asset('iconos/radio.svg') }}" class="nav"> Pendientes
                                    </li>
                                </a>
                                <a href="{{route('completado.index')}}">
                                    <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:scale-105 duration-300">
                                        <img src="{{ asset('iconos/radio.svg') }}" class="nav"> Completados
                                    </li>
                                </a>
                            </div>
                        </ul>
                        {{-- // --}}
                        <h6 class="font-bold mb-4">Opciones</h6>
                        <ul class="">
                            <a href="{{url('perfil', auth()->user()->id_usuario)}}">
                                <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                    <img src="{{ asset('iconos/user.svg') }}" class="nav"> Perfil
                                </li>
                            </a>
                            <a href="{{route('contacto.index')}}">
                                <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                    <img src="{{ asset('iconos/message.svg') }}" class="nav"> Contáctanos
                                </li>
                            </a>
                            <a href="{{route('login.destroy')}}">
                                <li class="flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                    <img src="{{ asset('iconos/logout.svg') }}" class="nav"> Cerrar Sesión
                                </li>
                            </a>
                        </ul>
                    </div>
                    {{-- // --}}
                    <div class="font-bold py-4 flex items-center justify-center gap-1 text-primary text-xl">
                        @if (auth()->check())
                            <span>{{ auth()->user()->name}}</span>
                        @endif
                    </div>
                </div>
            </div>
            <button onclick="toggleMenu()" class="xl:hidden fixed bottom-4 right-4 bg-primary p-3 rounded-full shadow-2xl z-50">
                <img src="{{ asset('iconos/menu.svg') }}" id="icon">
            </button>
        @else
            <div class="fixed lg:p-5 max-w-64 h-screen">
                <div class="px-6 pt-8 w-[19rem] sm:w-[24rem] lg:w-64 bg-gray-200 h-full hidden sm:hidden lg:flex flex-col justify-between shadow-xl rounded-lg z-50 transition-all duration-300" id="menu">
                    <div>
                        <div class="mb-8">
                            <a href="{{route('home.index')}}" class="text-primary font-bold text-3xl flex items-center justify-center gap-2">
                                <img src="{{ asset('iconos/logo.svg') }}"> SolTiend
                            </a>
                        </div>
                        {{-- // --}}
                        <h6 class="font-bold mb-4">General</h6>
                        <ul class="border-b-2 border-black mb-8">
                            <a href="{{route('home.index')}}">
                                <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                    <img src="{{ asset('iconos/home.svg') }}" class="nav"> Inicio
                                </li>
                            </a>
                            <a href="{{route('nombres.index')}}">
                                <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                    <img src="{{ asset('iconos/bookmarks.svg') }}" class="nav"> Nombres
                                </li>
                            </a>
                            <a href="{{route('admins.index')}}">
                                <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                    <img src="{{ asset('iconos/group.svg') }}" class="nav"> Administradores
                                </li>
                            </a>
                        </ul>
                        {{-- // --}}
                        <h6 class="font-bold mb-4">Opciones</h6>
                        <ul class="">
                            <a href="{{url('perfil', auth()->user()->id_usuario)}}">
                                <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                    <img src="{{ asset('iconos/user.svg') }}" class="nav"> Perfil
                                </li>
                            </a>
                            <a href="{{route('parametrizado.index')}}">
                                <li class="mb-4 flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                    <img src="{{ asset('iconos/list.svg') }}" class="nav"> Estadísticas
                                </li>
                            </a>
                            <a href="{{route('login.destroy')}}">
                                <li class="flex items-center gap-2 px-5 py-1 rounded-lg hover:bg-white hover:scale-105 duration-300">
                                    <img src="{{ asset('iconos/logout.svg') }}" class="nav"> Cerrar Sesión
                                </li>
                            </a>
                        </ul>
                    </div>
                    {{-- // --}}
                    <div class="font-bold py-4 flex items-center justify-center gap-1 text-primary text-xl">
                        @if (auth()->check())
                            <span>{{ auth()->user()->name}}</span>
                        @endif
                    </div>
                </div>
            </div>
            <button onclick="toggleMenu()" class="xl:hidden fixed bottom-4 right-4 bg-primary p-3 rounded-full shadow-2xl z-50">
                <img src="{{ asset('iconos/menu.svg') }}" id="icon">
            </button>
        @endif
    @endif
    {{-- // --}}
    <main class="ml-0 sm:m-0 lg:ml-72">
        @yield('content')
        @yield('js')
    </main>
    <script>
        function toggleMenu() {
            var menu = document.getElementById("menu");
            var menuIcon = document.getElementById("icon");
            if (menu.classList.contains("hidden") || menu.classList.contains("sm:hidden")){
                menu.classList.remove("hidden");
                menu.classList.remove("sm:hidden");
                menu.classList.add("flex");
                menu.classList.add("sm:flex");
                menuIcon.src = "{{ asset('iconos/x.svg') }}";
            } else {
                menu.classList.remove("flex");
                menu.classList.remove("sm:flex");
                menu.classList.add("hidden");
                menu.classList.add("sm:hidden");
                menuIcon.src = "{{ asset('iconos/menu.svg') }}";
            }
        }
        function toggleSubMenu() {
            var submenu = document.getElementById("submenu");
            var menuIcon = document.getElementById("chevron");
            if (submenu.classList.contains("hidden")) {
                submenu.classList.remove("hidden");
                submenu.classList.add("block");
                menuIcon.classList.add("rotate-90");
            } else {
                submenu.classList.remove("block");
                submenu.classList.add("hidden");
                menuIcon.classList.remove("rotate-90");
            }
        }

    </script>
</body>
</html>