@extends('layouts.app')

@section('titulo', 'Masajistas')

@section('contenido')

<h1>Masajistas</h1>

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
                        {{-- Botón editar --}}
                        <a href="{{ route('masajistas.edit', $masajista->cedula) }}">Editar</a>

                        {{-- Formulario para eliminar (necesita ser POST con método DELETE) --}}
                        <form action="{{ route('masajistas.destroy', $masajista->cedula) }}" method="POST"
                              onsubmit="return confirm('¿Estás seguro?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
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
