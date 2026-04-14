@extends('layouts.app')

@section('titulo', 'Nuevo Masajista - SPA Armonía')

@section('contenido')
<div class="bg-surface-50 dark:bg-surface-900 min-h-[calc(100vh-4rem)]">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <a href="{{ route('masajistas.index') }}"
            class="inline-flex items-center text-sm text-gray-500 hover:text-primary-600 mb-6">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver a masajistas
        </a>

        {{-- Header --}}
        <div class="bg-gradient-to-r from-primary-500 to-primary-700 rounded-2xl p-8 mb-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/4"></div>
            <h1 class="text-2xl font-bold text-white relative z-10">Nuevo Masajista</h1>
            <p class="text-primary-100 mt-1 relative z-10">Registra un nuevo masajista en el sistema</p>
        </div>

        <form action="{{ route('masajistas.store') }}" method="POST">
            @csrf

            <div class="card p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Información Personal</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Datos básicos del masajista</p>

                <div class="space-y-4">
                    <div>
                        <label for="cedula" class="label-field">Cédula *</label>
                        <input type="text" id="cedula" name="cedula" value="{{ old('cedula') }}" class="input-field" placeholder="1001234567" required>
                        @error('cedula')
                            <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="nombre" class="label-field">Nombre *</label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" class="input-field" placeholder="Nombre completo" required>
                        @error('nombre')
                            <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="telefono" class="label-field">Teléfono</label>
                        <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}" class="input-field" placeholder="3121234567">
                        @error('telefono')
                            <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="porcentaje_comision" class="label-field">Porcentaje de comisión (%)</label>
                        <input type="number" id="porcentaje_comision" name="porcentaje_comision" value="{{ old('porcentaje_comision') }}" class="input-field" placeholder="Ej: 15" min="0" max="100" step="0.01">
                        @error('porcentaje_comision')
                            <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Services --}}
            <div class="card p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Servicios</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Selecciona los servicios que ofrece este masajista</p>

                <div class="space-y-2 max-h-48 overflow-y-auto pr-2 border border-gray-200 dark:border-surface-600 rounded-lg p-3 bg-gray-50 dark:bg-surface-900 border-opacity-50">
                    @foreach ($servicios as $servicio)
                        <label class="flex items-center gap-3 cursor-pointer p-1.5 hover:bg-white dark:hover:bg-surface-800 rounded-md transition-colors">
                            <input type="checkbox" name="servicios[]" value="{{ $servicio->id_servicio }}"
                                   class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 dark:bg-surface-800 text-primary-600 focus:ring-primary-500"
                                   {{ in_array($servicio->id_servicio, old('servicios', [])) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700 dark:text-white font-medium">{{ $servicio->nombre_servicio }} - ${{ number_format($servicio->precio, 0, ',', '.') }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="btn-primary flex-1 text-base py-3">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Guardar Masajista
                </button>
                <a href="{{ route('masajistas.index') }}" class="btn-secondary text-base py-3">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection