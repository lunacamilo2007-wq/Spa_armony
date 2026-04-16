@extends('layouts.app')

@section('titulo', 'Masajistas')

@section('contenido')
<div class="bg-surface-50 min-h-[calc(100vh-4rem)]" id="masajistas-index-page">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Masajistas</h1>
                <p class="text-primary-600 text-sm mt-0.5">{{ $masajistas->count() }} Masajistas registrados</p>
            </div>
            <a href="{{ route('masajistas.create') }}" class="btn-primary mt-4 sm:mt-0">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo Masajista
            </a>
        </div>

        {{-- Table --}}
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($masajistas as $masajista)
                        <tr>
                            <td class="font-medium">{{ $masajista->cedula }}</td>
                            <td>{{ $masajista->nombre }}</td>
                            <td>{{ $masajista->telefono }}</td>
                            <td>
                                <a href="{{ route('masajistas.show', $masajista->cedula) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-primary-700 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Ver detalles
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-gray-500">No hay masajistas registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection