<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestor para Microempresas</title> 

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Poppins:600,700|Inter:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animaciones CSS (pueden ir en app.css o inline si es algo simple) */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down { animation: fadeInDown 1s ease-out forwards; }
        .animate-fade-in-up { animation: fadeInUp 1s ease-out forwards; }
    </style>
</head>
<body class="font-inter antialiased"> {{-- Usamos 'font-inter' como fuente principal --}}
    <div class="relative min-h-screen bg-gradient-to-br from-gray-900 to-blue-950 text-white flex flex-col justify-center items-center overflow-hidden">
        
        <header class="absolute top-0 left-0 right-0 p-6 z-20 flex justify-between items-center">
            <div class="text-2xl font-poppins font-bold text-white drop-shadow-md"> {{-- Usamos Poppins para el logo/nombre --}}
                <a href="/" class="hover:text-blue-300 transition-colors duration-200">Gestor de microempresa</a>
            </div>
            <nav>
                <ul class="flex space-x-6">
                    @auth
                        <li><a href="{{ url('/dashboard') }}" class="text-white hover:text-blue-300 transition-colors duration-200">Panel de Control</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="text-white hover:text-blue-300 transition-colors duration-200">Iniciar Sesión</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition-all duration-200 font-semibold">Regístrate Gratis</a></li>
                        @endif
                    @endauth
                </ul>
            </nav>
        </header>

        <main class="relative z-10 text-center px-4 max-w-5xl mx-auto">
            <h1 class="text-6xl md:text-7xl lg:text-8xl font-poppins font-extrabold leading-tight mb-6 drop-shadow-2xl animate-fade-in-down">
                Simplifica la Gestión de Tu Microempresa
            </h1>
            <p class="text-xl md:text-2xl lg:text-3xl text-gray-300 mb-10 leading-relaxed animate-fade-in-up delay-100">
                Controla ventas, inventario, clientes y finanzas. Impulsa el crecimiento de tu negocio.
            </p>
            <div class="space-x-4 animate-fade-in-up delay-200">
                <a href="{{ route('register') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-lg font-semibold px-8 py-4 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300 ease-in-out">
                    Comienza Ahora
                </a>
                <a href="{{ route('login') }}" class="inline-block bg-transparent border-2 border-white hover:bg-white hover:text-gray-900 text-white text-lg font-semibold px-8 py-4 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300 ease-in-out">
                    Acceder a Mi Cuenta
                </a>
            </div>
        </main>
</html>