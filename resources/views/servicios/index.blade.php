@extends('layouts.app')

@section('titulo', 'Servicios')

@section('contenido')

    <h1>Servicios</h1>
    <a href="{{ route('servicios.create') }}">Añadir servicio</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($servicios as $servicio)
                <tr>
                    <td>{{ $servicio->id_servicio }}</td>
                    <td>{{ $servicio->nombre_servicio }}</td>
                    <td>{{ $servicio->precio }}</td>
                    <td>{{ $servicio->descripcion }}</td>
                    <td>
                        <a href="{{ route('servicios.edit', $servicio->id_servicio) }}">Editar</a>
                        <form action="{{ route('servicios.destroy', $servicio->id_servicio) }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection