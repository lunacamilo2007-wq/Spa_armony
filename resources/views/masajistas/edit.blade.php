@extends('layouts.app')

@section('titulo', 'Editar Masajista')


@section('contenido')

    <h1>Editar Masajista</h1>

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

    {{-- El action apunta a update y necesita el id del masajista --}}
    <form action="{{ route('masajistas.update', $masajista->cedula) }}" method="POST">
        @csrf
        @method('PUT') {{-- Igual que con DELETE, los navegadores no soportan PUT nativamente --}}

        <div>
            <label for="nombre">Nombre</label>
            {{-- Aquí usamos el valor actual del masajista en lugar de old() --}}
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $masajista->nombre) }}">
            @error('nombre')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $masajista->telefono) }}">
            @error('telefono')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="porcentaje_comision">Porcentaje de comisión</label>
            <input type="number" id="porcentaje_comision" name="porcentaje_comision"
                value="{{ old('porcentaje_comision', $masajista->porcentaje_comision) }}">
            @error('porcentaje_comision')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="">Servicios que ofrece</label>
            @foreach ($servicios as $servicio)
                <div style="margin-bottom: 5px;">
                    <input type="checkbox" name="servicios[]" id="servicio_{{ $servicio->id_servicio }}"
                        value="{{ $servicio->id_servicio }}" {{ $masajista->servicios->contains('id_servicio', $servicio->id_servicio) ? 'checked' : '' }}>
                    <label for="servicio_{{ $servicio->id_servicio }}">{{ $servicio->nombre_servicio }} -
                        ${{ number_format($servicio->precio, 2) }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit">Actualizar</button>
        <a href="{{ route('masajistas.index') }}">Cancelar</a>
    </form>

@endsection