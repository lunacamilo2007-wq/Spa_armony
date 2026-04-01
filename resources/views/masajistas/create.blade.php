@extends('layouts.app')

@section('titulo', 'Nuevo Masajista')

@section('contenido')

    <h1>Nuevo Masajista</h1>

    {{-- En create.blade.php y edit.blade.php, justo antes del form --}}
@if($errors->any())
    <div class="alert-error">
        <p>Por favor corrige los siguientes errores:</p>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('masajistas.store') }}" method="POST">
        @csrf {{-- Protección de seguridad obligatoria en todo formulario --}}


        <div>
            <label for="cedula">Cédula</label>
            <input type="text" id="cedula" name="cedula" value="{{ old('cedula') }}">

            @error('cedula')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="nombre">Nombre</label>
            {{-- old('nombre') recupera el valor si el formulario falló validación --}}
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}">
            {{-- Muestra el error de validación si existe --}}
            @error('nombre')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}">
            @error('telefono')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Guardar</button>
        <a href="{{ route('masajistas.index') }}">Cancelar</a>
    </form>

@endsection