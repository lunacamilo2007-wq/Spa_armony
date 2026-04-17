@extends('layouts.app')

@section('titulo', 'Detalles del masajista')

@section('contenido')
    <div class="bg-surface-50 min-h-[calc(100vh-4rem)]" id="masajistas-show-page">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Detalles del Masajista</h1>
                <a href="{{ route('masajistas.index') }}" class="btn-secondary gap-2 mt-4 sm:mt-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 19-7-7 7-7" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5" />
                    </svg>
                    Volver
                </a>
            </div>

            {{-- Info Card --}}
            <div class="card p-6 mb-6">
                <div class="flex items-start gap-4">
                    <div
                        class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 font-bold text-lg shrink-0">
                        {{ strtoupper(substr($masajista->nombre, 0, 2)) }}
                    </div>
                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-gray-900">{{ $masajista->nombre }}</h2>
                        <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-8 text-sm">
                            <div>
                                <span class="text-gray-500">Cédula:</span>
                                <span class="font-medium text-gray-900 ml-1">{{ $masajista->cedula }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Teléfono:</span>
                                <span class="font-medium text-gray-900 ml-1">{{ $masajista->telefono }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Porcentaje de comisión:</span>
                                <span
                                    class="font-medium text-gray-900 ml-1">{{ rtrim(rtrim(number_format($masajista->porcentaje_comision, 2), '0'), '.') }}%</span>
                            </div>
                            @php
                                $totalComision = $masajista->servicios->sum(function ($servicio) use ($masajista) {
                                    return $masajista->calcularComision($servicio->precio);
                                });
                            @endphp
                            <div>
                                <span class="text-gray-500">Comisión:</span>
                                <span
                                    class="font-bold text-primary-700 ml-1">${{ number_format($totalComision, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Servicios y Comisiones --}}
            <div class="card p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Servicios que ofrece</h2>
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

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('masajistas.edit', $masajista->cedula) }}" class="btn-primary gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar
                </a>
                <form action="{{ route('masajistas.destroy', $masajista->cedula) }}" method="POST"
                    onsubmit="return confirm('¿Estás seguro? que deseas eliminar a este masajista')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection