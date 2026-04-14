@extends('layouts.app')

@section('titulo', 'Detalles del masajista - SPA Armonía')

@section('contenido')
<div class="bg-surface-50 dark:bg-surface-900 min-h-[calc(100vh-4rem)]" id="masajista-show-page">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <a href="{{ route('masajistas.index') }}"
            class="inline-flex items-center text-sm text-gray-500 hover:text-primary-600 mb-6">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver a masajistas
        </a>

        {{-- Profile Card --}}
        <div class="card p-8 mb-6">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 rounded-2xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-700 dark:text-primary-400 font-bold text-2xl">
                    {{ strtoupper(substr($masajista->nombre, 0, 2)) }}
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $masajista->nombre }}</h1>
                    <p class="text-gray-500 dark:text-gray-400">Cédula: {{ $masajista->cedula }} · Tel: {{ $masajista->telefono ?? 'N/A' }}</p>
                    <p class="text-primary-600 dark:text-primary-400 text-sm mt-1">
                        Comisión: {{ rtrim(rtrim(number_format($masajista->porcentaje_comision, 2), '0'), '.') }}%
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('masajistas.edit', $masajista->cedula) }}" class="btn-secondary text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Editar
                    </a>
                    <form action="{{ route('masajistas.destroy', $masajista->cedula) }}" method="POST" onsubmit="return confirm('¿Estás seguro que deseas eliminar a este masajista?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Services & Commissions --}}
        <div class="card p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Servicios y Comisiones</h2>
            @if($masajista->servicios->count() > 0)
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Servicio</th>
                                <th>Precio</th>
                                <th>Comisión</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($masajista->servicios as $srv)
                                <tr>
                                    <td class="font-medium">{{ $srv->nombre_servicio }}</td>
                                    <td>${{ number_format($srv->precio, 0, ',', '.') }}</td>
                                    <td class="text-primary-600 dark:text-primary-400 font-medium">${{ number_format($masajista->calcularComision($srv->precio), 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @php
                    $totalComision = $masajista->servicios->sum(function ($servicio) use ($masajista) {
                        return $masajista->calcularComision($servicio->precio);
                    });
                @endphp
                <div class="mt-4 p-4 bg-primary-50 dark:bg-primary-900/20 rounded-lg border border-primary-200 dark:border-primary-800 flex justify-between items-center">
                    <span class="font-semibold text-primary-700 dark:text-primary-300">Comisión Total</span>
                    <span class="text-xl font-bold text-primary-700 dark:text-primary-300">${{ number_format($totalComision, 0, ',', '.') }}</span>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No tiene servicios asignados.</p>
            @endif
        </div>
    </div>
</div>
@endsection