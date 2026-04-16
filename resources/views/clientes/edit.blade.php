@extends('layouts.app')

@section('titulo', 'Editar Cliente')

@section('contenido')

    <h1>Editar Cliente</h1>

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

    <form action="{{ route('clientes.update', $clientes->cedula) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="cedula">Cédula</label>
            <input type="text" id="cedula" name="cedula" value="{{ old('cedula', $clientes->cedula) }}">
            @error('cedula')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $clientes->nombre) }}">
            @error('nombre')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $clientes->telefono) }}">
            @error('telefono')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="correo">Correo</label>
            <input type="text" id="correo" name="correo" value="{{ old('correo', $clientes->correo) }}">
            @error('correo')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <button type="submit">Actualizar</button>
        <a href="{{ route('clientes.index') }}">Cancelar</a>
    </form>

@endsection