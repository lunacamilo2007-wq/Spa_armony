@extends('layouts.app')

@section('titulo', 'Editar Servicio - SPA Armonía')

@section('contenido')
<div class="bg-surface-50 dark:bg-surface-900 min-h-[calc(100vh-4rem)]">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <a href="{{ route('servicios.index') }}"
            class="inline-flex items-center text-sm text-gray-500 hover:text-primary-600 mb-6">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver a servicios
        </a>

        {{-- Header --}}
        <div class="bg-gradient-to-r from-primary-500 to-primary-700 rounded-2xl p-8 mb-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/4"></div>
            <h1 class="text-2xl font-bold text-white relative z-10">Editar Servicio</h1>
            <p class="text-primary-100 mt-1 relative z-10">Actualiza la información de {{ $servicio->nombre_servicio }}</p>
        </div>

        <form action="{{ route('servicios.update', $servicio->id_servicio) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card p-6 mb-6">
                <div class="space-y-4">
                    <div>
                        <label for="nombre_servicio" class="label-field">Nombre del servicio *</label>
                        <input type="text" id="nombre_servicio" name="nombre_servicio"
                            value="{{ old('nombre_servicio', $servicio->nombre_servicio) }}" class="input-field" required>
                        @error('nombre_servicio')
                            <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="precio" class="label-field">Precio *</label>
                        <input type="number" id="precio" name="precio" value="{{ old('precio', $servicio->precio) }}" class="input-field" min="0" required>
                        @error('precio')
                            <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="descripcion" class="label-field">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="3" class="input-field">{{ old('descripcion', $servicio->descripcion) }}</textarea>
                        @error('descripcion')
                            <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="btn-primary flex-1 text-base py-3">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Actualizar Servicio
                </button>
                <a href="{{ route('servicios.index') }}" class="btn-secondary text-base py-3">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection