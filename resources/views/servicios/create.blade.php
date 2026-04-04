@extends('layouts.app')

@section('titulo', 'Añadir servicio')

@section('contenido')

    <h1>Añadir Servicios</h1>

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

    <form action="{{ route('servicios.store') }}" method="POST">
        @csrf {{-- Protección de seguridad obligatoria en todo formulario --}}


        <div>
            <label for="nombre_servicio">Nombre del servicio</label>
            <input type="text" id="nombre_servicio" name="nombre_servicio" value="{{ old('nombre_servicio') }}">

            @error('nombre_servicio')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="precio">Precio</label>
            {{-- old('nombre') recupera el valor si el formulario falló validación --}}
            <input type="text" id="precio" name="precio" value="{{ old('precio') }}">
            {{-- Muestra el error de validación si existe --}}
            @error('precio')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="descricion">Descripcion</label>
            <input type="text" id="descripcion" name="descripcion" value="{{ old('descripcion') }}">
            @error('descripcion')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Guardar</button>
        <a href="{{ route('servicios.index') }}">Cancelar</a>
    </form>

@endsection