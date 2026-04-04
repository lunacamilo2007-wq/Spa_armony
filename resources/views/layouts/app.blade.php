<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spa - @yield('titulo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

    <nav>
        <a href="{{ route('masajistas.index') }}">Masajistas</a>
        <a href="{{route('servicios.index') }}">Servicios</a>
    </nav>

    <main>
        {{-- Mensaje flash de éxito (el que enviamos desde el controlador) --}}
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Aquí se inyecta el contenido de cada vista hija --}}
        @yield('contenido')
    </main>

</body>

</html>