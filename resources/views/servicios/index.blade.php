@extends('layouts.app')

@section('titulo', 'Servicios')

@section('contenido')
<div class="bg-surface-50 min-h-[calc(100vh-4rem)]" id="servicios-index-page">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Servicios</h1>
                <p class="text-primary-600 text-sm mt-0.5">{{ $servicios->count() }} servicios disponibles</p>
            </div>
            <a href="{{ route('servicios.create') }}" class="btn-primary mt-4 sm:mt-0">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Añadir Servicio
            </a>
        </div>

        {{-- Table --}}
        <div class="table-container">
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
                            <td class="font-medium">{{ $servicio->id_servicio }}</td>
                            <td>{{ $servicio->nombre_servicio }}</td>
                            <td class="font-semibold text-primary-700">${{ number_format($servicio->precio, 0, ',', '.') }}</td>
                            <td class="max-w-xs truncate">{{ $servicio->descripcion }}</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('servicios.edit', $servicio->id_servicio) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-primary-700 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Editar
                                    </a>
                                    <form action="{{ route('servicios.destroy', $servicio->id_servicio) }}" method="POST"
                                        onsubmit="return confirm('¿Estás seguro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection