@extends('layouts.app')

@section('titulo', 'Editar servicios')

@section('contenido')

    <h1>Editar servicios</h1>

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

    {{-- El action apunta a update y necesita el id del masajista --}}
    <form action="{{ route('servicios.update', $servicio->id_servicio) }}" method="POST">
        @csrf
        @method('PUT') {{-- Igual que con DELETE, los navegadores no soportan PUT nativamente --}}

        <div>
            <label for="nombre_servicio">Nombre del servicio</label>
            {{-- Aquí usamos el valor actual del masajista en lugar de old() --}}
            <input type="text" id="nombre_servicio" name="nombre_servicio"
                value="{{ old('nombre_servicio', $servicio->nombre_servicio) }}">
            @error('nombre_servicio')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="precio">Precio</label>
            <input type="text" id="precio" name="precio" value="{{ old('precio', $servicio->precio) }}">
            @error('precio')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="descripcion">Descripcion</label>
            <input type="text" id="descripcion" name="descripcion" value="{{ old('descripcion', $servicio->descripcion) }}">
            @error('descripcion')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Actualizar</button>
        <a href="{{ route('servicios.index') }}">Cancelar</a>
    </form>

@endsection