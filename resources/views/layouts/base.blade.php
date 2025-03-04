<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }}</title>
    @livewireStyles
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans antialiased">
    {{ $slot }}
    @livewireScripts
</body>
</html>