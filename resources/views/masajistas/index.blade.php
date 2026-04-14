@extends('layouts.app')

@section('titulo', 'Masajistas')



@section('contenido')

    <h1>Masajistas</h1>
    <p>{{ $masajistas->count() }} Masajistas registrados</p>

    <a href="{{ route('masajistas.create')}}">Nuevo masajista</a>

    <table>
        <thead>
            <tr>
                <th>Cedula</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{-- Recorremos el array de masajistas que envió el controlador --}}
            @forelse($masajistas as $masajista)
                <tr>
                    <td>{{ $masajista->cedula}}</td>
                    <td>{{ $masajista->nombre }}</td>
                    <td>{{ $masajista->telefono }}</td>
                    <td>
                        <form action="{{ route('masajistas.show', $masajista->cedula) }}" method="POST">
                            @csrf
                            @method('GET')
                            <button type="submit">Mostrar más</button>
                        </form>

                    </td>
                </tr>
                {{-- @forelse permite manejar el caso en que no haya registros --}}
            @empty
                <tr>
                    <td colspan="3">No hay masajistas registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection