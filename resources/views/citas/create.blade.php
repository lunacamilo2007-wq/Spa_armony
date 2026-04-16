@extends('layouts.app')

@section('titulo', 'Agendar Nueva Cita')

@section('contenido')
<div class="max-w-7xl mx-auto space-y-6" x-data="{ esNuevoCliente: '0' }">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 drop-shadow-sm tracking-tight mb-1">
                Agendar Cita
            </h1>
            <p class="text-sm text-gray-500 font-medium tracking-wide">
                Configura una nueva cita para un cliente.
            </p>
        </div>
        <a href="{{ route('citas.index') }}" class="group relative inline-flex w-fit items-center justify-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 transition-all duration-200 hover:bg-gray-50 hover:ring-gray-400 active:scale-95 focus:outline-none focus:ring-2 focus:ring-spa-500">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-gray-500 group-hover:text-gray-700 transition-colors"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            Volver
        </a>
    </div>

    <!-- Error Summary if any validation fails -->
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-red-400"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                </div>
                <div class="ml-3 text-sm text-red-700">
                    <p class="font-bold">Por favor corrige los siguientes errores:</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Form Section -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-200 overflow-hidden">
        <form action="{{ route('citas.store') }}" method="POST">
            @csrf
            
            <div class="p-6 sm:p-8 space-y-10">
                
                {{-- Sección del Cliente --}}
                <div class="space-y-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Información del Cliente</h2>
                        
                        <!-- Toggle Cliente Nuevo o Existente -->
                        <div class="flex gap-4 mb-6">
                            <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none" :class="{ 'border-spa-500 ring-1 ring-spa-500': esNuevoCliente === '0', 'border-gray-200': esNuevoCliente !== '0' }">
                                <input type="radio" x-model="esNuevoCliente" name="es_nuevo_cliente" value="0" class="sr-only">
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-medium text-gray-900">Cliente Existente</span>
                                        <span class="mt-1 flex items-center text-sm text-gray-500">Buscar en sistema</span>
                                    </span>
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-spa-600" x-show="esNuevoCliente === '0'"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                            </label>

                            <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none" :class="{ 'border-spa-500 ring-1 ring-spa-500': esNuevoCliente === '1', 'border-gray-200': esNuevoCliente !== '1' }">
                                <input type="radio" x-model="esNuevoCliente" name="es_nuevo_cliente" value="1" class="sr-only">
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-medium text-gray-900">Cliente Nuevo</span>
                                        <span class="mt-1 flex items-center text-sm text-gray-500">Registrar ahora</span>
                                    </span>
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-spa-600" x-show="esNuevoCliente === '1'" style="display: none;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                            </label>
                        </div>
                        
                        <!-- Select Cliente Existente -->
                        <div x-show="esNuevoCliente === '0'" x-transition class="space-y-4">
                            <div>
                                <label for="id_cliente" class="block text-sm font-medium leading-6 text-gray-900 mb-1">
                                    Seleccionar Cliente <span class="text-red-500">*</span>
                                </label>
                                <select id="id_cliente" name="id_cliente" 
                                    class="block w-full rounded-xl border-0 py-2.5 px-3 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-spa-500 sm:text-sm sm:leading-6 shadow-sm transition-shadow">
                                    <option value="">Seleccione un cliente...</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->cedula }}" {{ old('id_cliente') == $cliente->cedula ? 'selected' : '' }}>
                                            {{ $cliente->nombre }} (CC: {{ $cliente->cedula }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Formulario Cliente Nuevo -->
                        <div x-show="esNuevoCliente === '1'" x-transition x-cloak class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 p-5 bg-gray-50 border border-gray-200 rounded-xl">
                            <div>
                                <label for="nuevo_cliente_cedula" class="block text-sm font-medium leading-6 text-gray-900 mb-1">Cédula <span class="text-red-500">*</span></label>
                                <input type="number" name="nuevo_cliente_cedula" id="nuevo_cliente_cedula" value="{{ old('nuevo_cliente_cedula') }}"
                                    class="block w-full rounded-xl border-0 py-2.5 px-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-spa-500 sm:text-sm sm:leading-6 shadow-sm transition-shadow">
                            </div>

                            <div>
                                <label for="nuevo_cliente_nombre" class="block text-sm font-medium leading-6 text-gray-900 mb-1">Nombre Completo <span class="text-red-500">*</span></label>
                                <input type="text" name="nuevo_cliente_nombre" id="nuevo_cliente_nombre" value="{{ old('nuevo_cliente_nombre') }}"
                                    class="block w-full rounded-xl border-0 py-2.5 px-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-spa-500 sm:text-sm sm:leading-6 shadow-sm transition-shadow">
                            </div>

                            <div>
                                <label for="nuevo_cliente_telefono" class="block text-sm font-medium leading-6 text-gray-900 mb-1">Teléfono <span class="text-red-500">*</span></label>
                                <input type="text" name="nuevo_cliente_telefono" id="nuevo_cliente_telefono" value="{{ old('nuevo_cliente_telefono') }}"
                                    class="block w-full rounded-xl border-0 py-2.5 px-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-spa-500 sm:text-sm sm:leading-6 shadow-sm transition-shadow">
                            </div>

                            <div>
                                <label for="nuevo_cliente_correo" class="block text-sm font-medium leading-6 text-gray-900 mb-1">Correo Electrónico <span class="text-red-500">*</span></label>
                                <input type="email" name="nuevo_cliente_correo" id="nuevo_cliente_correo" value="{{ old('nuevo_cliente_correo') }}"
                                    class="block w-full rounded-xl border-0 py-2.5 px-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-spa-500 sm:text-sm sm:leading-6 shadow-sm transition-shadow">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sección de la Cita --}}
                <div class="space-y-6">
                    <h2 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Detalles de la Cita</h2>
                    
                    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                        
                        <!-- Fecha y Hora -->
                        <div>
                            <label for="fecha" class="block text-sm font-medium leading-6 text-gray-900 mb-1">Fecha y Hora <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="fecha" id="fecha" value="{{ old('fecha') }}"
                                class="block w-full rounded-xl border-0 py-2.5 px-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-spa-500 sm:text-sm sm:leading-6 shadow-sm transition-shadow">
                        </div>

                        <!-- Habitación -->
                        <div>
                            <label for="habitacion" class="block text-sm font-medium leading-6 text-gray-900 mb-1">Habitación N° <span class="text-red-500">*</span></label>
                            <input type="number" name="habitacion" id="habitacion" value="{{ old('habitacion') }}" min="1"
                                class="block w-full rounded-xl border-0 py-2.5 px-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-spa-500 sm:text-sm sm:leading-6 shadow-sm transition-shadow">
                        </div>

                        <!-- Masajista -->
                        <div class="sm:col-span-2">
                            <label for="masajista" class="block text-sm font-medium leading-6 text-gray-900 mb-1">Masajista Asignado <span class="text-red-500">*</span></label>
                            <select id="masajista" name="masajista" 
                                class="block w-full rounded-xl border-0 py-2.5 px-3 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-spa-500 sm:text-sm sm:leading-6 shadow-sm transition-shadow">
                                <option value="">Seleccione un masajista...</option>
                                @foreach($masajistas as $mas)
                                    <option value="{{ $mas->cedula }}" {{ old('masajista') == $mas->cedula ? 'selected' : '' }}>
                                        {{ $mas->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-sm text-gray-500">Nota: Al guardar la cita, no se restringen estrictamente los servicios seleccionados al masajista actual en el formulario.</p>
                        </div>
                        
                        <!-- Servicios (Checkbox Group) -->
                        <div class="sm:col-span-2 mt-4 space-y-3">
                            <fieldset>
                                <legend class="text-sm font-medium leading-6 text-gray-900">Servicios a realizar <span class="text-red-500">*</span></legend>
                                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($servicios as $servicio)
                                    <div class="relative flex items-start p-4 border border-gray-200 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                                        <div class="flex h-6 items-center">
                                            <input id="servicio_{{ $servicio->id_servicio }}" name="servicios[]" value="{{ $servicio->id_servicio }}" type="checkbox" 
                                                class="h-5 w-5 rounded border-gray-300 text-spa-600 focus:ring-spa-600"
                                                {{ is_array(old('servicios')) && in_array($servicio->id_servicio, old('servicios')) ? 'checked' : '' }}>
                                        </div>
                                        <div class="ml-3 text-sm leading-6 flex-1">
                                            <label for="servicio_{{ $servicio->id_servicio }}" class="font-medium text-gray-900 select-none cursor-pointer">
                                                {{ $servicio->nombre_servicio }}
                                            </label>
                                            <p class="text-gray-500">${{ number_format($servicio->precio, 0) }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>

                        <!-- Nota -->
                        <div class="sm:col-span-2">
                            <label for="nota" class="block text-sm font-medium leading-6 text-gray-900 mb-1">Notas Opcionales</label>
                            <textarea id="nota" name="nota" rows="3" 
                                class="block w-full rounded-xl border-0 py-2.5 px-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-spa-500 sm:text-sm sm:leading-6 shadow-sm transition-shadow">{{ old('nota') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Ejemplo: Condiciones médicas, preferencias especiales del cliente, etc.</p>
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- Footer con Botones -->
            <div class="bg-gray-50 px-6 py-5 sm:flex sm:flex-row-reverse sm:px-8 border-t border-gray-200">
                <button type="submit" 
                        class="inline-flex w-full justify-center items-center gap-2 rounded-xl bg-spa-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-spa-700 active:bg-spa-800 active:scale-95 transition-all duration-200 sm:ml-3 sm:w-auto focus:outline-none focus:ring-2 focus:ring-spa-500 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Guardar Cita
                </button>
                <a href="{{ route('citas.index') }}" 
                   class="mt-3 inline-flex w-full justify-center items-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 active:scale-95 transition-all duration-200 sm:mt-0 sm:w-auto focus:outline-none focus:ring-2 focus:ring-spa-500 focus:ring-offset-2">
                    Cancelar
                </a>
            </div>

        </form>
    </div>

</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection