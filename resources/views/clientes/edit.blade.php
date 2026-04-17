@extends('layouts.app')

@section('titulo', 'Editar Cliente')

@section('contenido')
<div class="bg-surface-50 min-h-[calc(100vh-4rem)]" id="clientes-edit-page">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Editar Cliente</h1>
            <a href="{{ route('clientes.index') }}" class="btn-secondary gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m12 19-7-7 7-7"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5"/></svg>
                Volver
            </a>
        </div>

        {{-- Form --}}
        <div class="card overflow-hidden">
            <form action="{{ route('clientes.update', $clientes->cedula) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6 sm:p-8 space-y-6">
                    <div>
                        <label for="cedula" class="label-field">Cédula</label>
                        <input type="text" id="cedula" name="cedula" value="{{ old('cedula', $clientes->cedula) }}" class="input-field">
                        @error('cedula')
                            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="nombre" class="label-field">Nombre</label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $clientes->nombre) }}" class="input-field">
                        @error('nombre')
                            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="telefono" class="label-field">Teléfono</label>
                        <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $clientes->telefono) }}" class="input-field">
                        @error('telefono')
                            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="correo" class="label-field">Correo</label>
                        <input type="text" id="correo" name="correo" value="{{ old('correo', $clientes->correo) }}" class="input-field">
                        @error('correo')
                            <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse sm:px-8 border-t border-gray-200">
                    <button type="submit" class="btn-primary w-full sm:w-auto sm:ml-3">Actualizar</button>
                    <a href="{{ route('clientes.index') }}" class="btn-secondary w-full sm:w-auto mt-3 sm:mt-0">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection