@extends('layouts.app')

@section('titulo', 'Editar servicios')

@section('contenido')
<div class="bg-surface-50 min-h-[calc(100vh-4rem)]" id="servicios-edit-page">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Editar Servicio</h1>
            <a href="{{ route('servicios.index') }}" class="btn-secondary gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 19-7-7 7-7"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5"/></svg>
                Volver
            </a>
        </div>

        {{-- Form --}}
        <div class="card overflow-hidden">
            <form action="{{ route('servicios.update', $servicio->id_servicio) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6 sm:p-8 space-y-6">
                    <div>
                        <label for="nombre_servicio" class="label-field">Nombre del servicio</label>
                        <input type="text" id="nombre_servicio" name="nombre_servicio"
                            value="{{ old('nombre_servicio', $servicio->nombre_servicio) }}" class="input-field">
                        @error('nombre_servicio')
                            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="precio" class="label-field">Precio</label>
                        <input type="text" id="precio" name="precio" value="{{ old('precio', $servicio->precio) }}" class="input-field">
                        @error('precio')
                            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="descripcion" class="label-field">Descripción</label>
                        <input type="text" id="descripcion" name="descripcion" value="{{ old('descripcion', $servicio->descripcion) }}" class="input-field">
                        @error('descripcion')
                            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse sm:px-8 border-t border-gray-200">
                    <button type="submit" class="btn-primary w-full sm:w-auto sm:ml-3">Actualizar</button>
                    <a href="{{ route('servicios.index') }}" class="btn-secondary w-full sm:w-auto mt-3 sm:mt-0">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection