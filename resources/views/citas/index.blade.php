@extends('layouts.app')

@section('titulo', 'Citas')

@section('contenido')

    <h1>Citas</h1>
    <a href="{{ route('citas.create') }}">Crear Cita</a>

    <table>
        <th>Id</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Masajista</th>
        <th>Cliente</th>
        <th>Habitación</th>
        <th>estado</th>
        @foreach ($citas as $cita)
            <tr>
                <td>{{ $cita->id }}</td>
                <td>{{ $cita->fecha }}</td>
                <td>{{ $cita->hora }}</td>
                <td>{{ $cita->masajista }}</td>
                <td>{{ $cita->cliente->nombre ?? 'Sin cliente' }}</td>
                <td>{{ $cita->habitacion }}</td>
                <td>{{ $cita->estado }}</td>
            </tr>
        @endforeach
    </table>
@endsection