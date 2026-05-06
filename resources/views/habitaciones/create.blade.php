@extends('layouts.app')

@section('titulo', 'Nueva Habitación - SPA Armonía')

@section('contenido')
    <div class="bg-surface-50 min-h-[calc(100vh-4rem)]" id="habitaciones-create-page">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Añadir Habitación</h1>
                <a href="{{ route('habitaciones.index') }}" class="btn-secondary gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 19-7-7 7-7" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5" />
                    </svg>
                    Volver
                </a>
            </div>

            {{-- Form --}}
            <div class="card overflow-hidden">
                <form action="{{ route('habitaciones.store') }}" method="POST">
                    @csrf
                    <div class="p-6 sm:p-8 space-y-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-sm text-blue-800">
                                <strong>Nota:</strong> El número de habitación se asignará automáticamente cuando sea creada.
                            </p>
                        </div>

                        <div>
                            <label for="estado" class="label-field">Estado Inicial</label>
                            <select id="estado" name="estado" class="input-field">
                                <option value="">Seleccionar estado...</option>
                                <option value="activo" {{ old('estado') === 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('estado')
                                <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse sm:px-8 border-t border-gray-200">
                        <button type="submit" class="btn-primary w-full sm:w-auto sm:ml-3">Guardar</button>
                        <a href="{{ route('habitaciones.index') }}"
                            class="btn-secondary w-full sm:w-auto mt-3 sm:mt-0">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
