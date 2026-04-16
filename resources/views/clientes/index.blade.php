@extends('layouts.app')

@section('titulo', 'Clientes')

@section('contenido')

    <h1>Clientes</h1>
    <p>{{ $clientes->count() }} Clientes registrados</p>

    <a href="{{ route('clientes.create')}}">Nuevo cliente</a>

    <table>
        <thead>
            <tr>
                <th>Cedula</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{-- Recorremos el array de clientes que envió el controlador --}}
            @forelse($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->cedula}}</td>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->correo }}</td>
                    <td>
                        <a href="{{ route('clientes.edit', $cliente->cedula) }}">Editar</a>
                        <form action="{{ route('clientes.destroy', $cliente->cedula) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>

                    </td>
                </tr>
                {{-- @forelse permite manejar el caso en que no haya registros --}}
            @empty
                <tr>
                    <td colspan="3">No hay clientes registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection