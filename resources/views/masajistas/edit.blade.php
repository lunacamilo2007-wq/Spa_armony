@extends('layouts.app')

@section('titulo', 'Editar Masajista')

@section('contenido')
<div class="bg-surface-50 min-h-[calc(100vh-4rem)]" id="masajistas-edit-page">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Editar Masajista</h1>
            <a href="{{ route('masajistas.index') }}" class="btn-secondary gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 19-7-7 7-7"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5"/></svg>
                Volver
            </a>
        </div>

        {{-- Form --}}
        <div class="card overflow-hidden">
            <form action="{{ route('masajistas.update', $masajista->cedula) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6 sm:p-8 space-y-6">
                    <div>
                        <label for="nombre" class="label-field">Nombre</label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $masajista->nombre) }}" class="input-field">
                        @error('nombre')
                            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="telefono" class="label-field">Teléfono</label>
                        <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $masajista->telefono) }}" class="input-field">
                        @error('telefono')
                            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="porcentaje_comision" class="label-field">Porcentaje de comisión</label>
                        <input type="number" id="porcentaje_comision" name="porcentaje_comision"
                            value="{{ old('porcentaje_comision', $masajista->porcentaje_comision) }}" class="input-field">
                        @error('porcentaje_comision')
                            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Servicios --}}
                    <div>
                        <label class="label-field">Servicios que ofrece</label>
                        <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach ($servicios as $servicio)
                                <div class="relative flex items-start p-3 border border-gray-200 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex h-6 items-center">
                                        <input type="checkbox" name="servicios[]" id="servicio_{{ $servicio->id_servicio }}"
                                            value="{{ $servicio->id_servicio }}"
                                            {{ $masajista->servicios->contains('id_servicio', $servicio->id_servicio) ? 'checked' : '' }}
                                            class="h-5 w-5 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
                                    </div>
                                    <label for="servicio_{{ $servicio->id_servicio }}" class="ml-3 text-sm font-medium text-gray-900 select-none cursor-pointer">
                                        {{ $servicio->nombre_servicio }} - ${{ number_format($servicio->precio, 2) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse sm:px-8 border-t border-gray-200">
                    <button type="submit" class="btn-primary w-full sm:w-auto sm:ml-3">Actualizar</button>
                    <a href="{{ route('masajistas.index') }}" class="btn-secondary w-full sm:w-auto mt-3 sm:mt-0">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection