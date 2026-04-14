@extends('layouts.app')

@section('titulo', 'Detalles del masajista')


@section('contenido')
    <h1>Detalles del masajista</h1>
    <p><strong>Cedula:</strong> {{ $masajista->cedula }}</p>
    <p><strong>Nombre:</strong> {{ $masajista->nombre }}</p>
    <p><strong>Teléfono:</strong> {{ $masajista->telefono }}</p>
    <p><strong>Porcentaje de comisión general:</strong>
        {{ rtrim(rtrim(number_format($masajista->porcentaje_comision, 2), '0'), '.') }}%</p>
    @php
        $totalComision = $masajista->servicios->sum(function ($servicio) use ($masajista) {
            return $masajista->calcularComision($servicio->precio);
        });
    @endphp

    <p><strong>Comisión total a recibir:</strong> ${{ number_format($totalComision, 0, ',', '.') }}</p>

    <div class="card p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Servicios y Comisiones</h2>
        @if($masajista->servicios->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($masajista->servicios as $srv)
                            <tr>
                                <td class="font-medium">{{ $srv->nombre_servicio }}</td>
                                <td>${{ number_format($srv->precio, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No tiene servicios asignados.</p>
        @endif
    </div>
    {{--<ul>
        @foreach ($masajista->servicios as $servicio)
        <li>
            {{ $servicio->nombre_servicio }} - ${{ number_format($servicio->precio, 2) }}
        </li>
        @endforeach
    </ul>--}}

    <form action="{{ route('masajistas.edit', $masajista->cedula) }}" method="POST">
        @csrf
        @method('GET')
        <button type="submit">Editar</button>
    </form>

    <form action="{{ route('masajistas.destroy', $masajista->cedula) }}" method="POST"
        onsubmit="return confirm('¿Estás seguro? que deseas eliminar a este masajista')">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar</button>
    </form>

    <a href="{{ route('masajistas.index') }}">Volver</a>
@endsection