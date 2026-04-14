@extends('layouts.app')

@section('titulo', 'Gestión de Servicios - SPA Armonía')

@section('contenido')
<div class="bg-surface-50 dark:bg-surface-900 min-h-[calc(100vh-4rem)]" id="servicios-index-page">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Gestión de Servicios</h1>
                <p class="text-primary-600 dark:text-primary-400 text-sm mt-0.5">{{ $servicios->count() }} servicios</p>
            </div>
            <a href="{{ route('servicios.create') }}" class="btn-primary mt-4 sm:mt-0" id="btn-nuevo-servicio">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo Servicio
            </a>
        </div>

        @if($servicios->count() > 0)
            <div class="table-container">
                <table>
                    <thead><tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Descripción</th><th class="text-right">Acciones</th></tr></thead>
                    <tbody>
                        @foreach($servicios as $servicio)
                            <tr>
                                <td class="font-mono text-sm">{{ $servicio->id_servicio }}</td>
                                <td class="font-medium text-gray-900 dark:text-white">{{ $servicio->nombre_servicio }}</td>
                                <td class="font-bold text-primary-600 dark:text-primary-400">${{ number_format($servicio->precio, 0, ',', '.') }}</td>
                                <td class="text-sm">{{ $servicio->descripcion ?? '-' }}</td>
                                <td class="text-right">
                                    <a href="{{ route('servicios.edit', $servicio->id_servicio) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium mr-3">Editar</a>
                                    <form method="POST" action="{{ route('servicios.destroy', $servicio->id_servicio) }}" class="inline" onsubmit="return confirm('¿Eliminar este servicio?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:text-red-700 text-sm font-medium">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="card p-12 text-center"><p class="text-gray-500 text-lg">No hay servicios registrados.</p></div>
        @endif
    </div>
</div>
@endsection