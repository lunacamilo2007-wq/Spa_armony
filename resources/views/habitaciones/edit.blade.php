@extends('layouts.app')

@section('titulo', 'Editar Habitación - SPA Armonía')

@section('contenido')
    <div class="bg-surface-50 min-h-[calc(100vh-4rem)]" id="habitaciones-edit-page">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Editar Habitación</h1>
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
                <form action="{{ route('habitaciones.update', $habitacion) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-6 sm:p-8 space-y-6">
                        <div>
                            <label for="numero" class="label-field">Número Habitación</label>
                            <input type="text" id="numero" name="numero" value="{{ $habitacion->id }}"
                                class="input-field bg-gray-100" readonly>
                        </div>

                        <div>
                            <label for="estado" class="label-field">Estado</label>
                            <select id="estado" name="estado" class="input-field">
                                <option value="activo" {{ $habitacion->estado === 'activo' ? 'selected' : '' }}>Activo
                                </option>
                                <option value="inactivo" {{ $habitacion->estado === 'inactivo' ? 'selected' : '' }}>Inactivo
                                </option>
                            </select>
                            @error('estado')
                                <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse sm:px-8 border-t border-gray-200">
                        <button type="submit" class="btn-primary w-full sm:w-auto sm:ml-3">Actualizar</button>
                        <a href="{{ route('habitaciones.index') }}"
                            class="btn-secondary w-full sm:w-auto mt-3 sm:mt-0">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
