<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Poppins:400,600,700|Inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased relative overflow-hidden">
    {{-- Opción 1: Degradado vibrante (descomenta esta sección y comenta la de imagen si la prefieres) --}}
    {{-- <div class="absolute inset-0 bg-gradient-to-br from-indigo-800 via-blue-900 to-purple-900 opacity-90"></div> --}}

    {{-- Opción 2: Imagen de fondo con superposición oscura (descomenta esta sección y comenta la de degradado) --}}
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://source.unsplash.com/random/1920x1080/?technology,abstract,space');">
        <div class="absolute inset-0 bg-black opacity-70"></div> {{-- Capa oscura para mejor contraste --}}
    </div>

    <div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-transparent">
        <div>
            <a href="/">
                <x-application-logo class="w-24 h-24 fill-current text-white drop-shadow-lg" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 
                    bg-gray-900 bg-opacity-70 
                    backdrop-blur-lg 
                    rounded-3xl 
                    shadow-3xl 
                    transform hover:scale-105 
                    transition-all duration-500 ease-in-out 
                    border border-gray-700 
                    overflow-hidden"> {{-- Añadido overflow-hidden para asegurar que el contenido interno no se salga --}}
            {{ $slot }}
        </div>
    </div>
</body>
</html>