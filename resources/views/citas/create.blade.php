@extends('layouts.app')

@section('titulo', 'Agendar Nueva Cita')

@section('contenido')
    <div class="bg-surface-50 min-h-[calc(100vh-4rem)]" id="citas-create-page">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8" 
            x-data="{ 
                esNuevoCliente: '{{ old('es_nuevo_cliente', '0') }}',
                searchCliente: '',
                selectedCliente: null,
                showDropdown: false,
                clientes: {{ json_encode($clientes) }},
                get filteredClientes() {
                    if (this.searchCliente === '') return [];
                    return this.clientes.filter(c => 
                        c.nombre.toLowerCase().includes(this.searchCliente.toLowerCase()) || 
                        c.cedula.toString().includes(this.searchCliente)
                    );
                },
                selectCliente(cliente) {
                    this.selectedCliente = cliente;
                    this.searchCliente = `${cliente.nombre} (CC: ${cliente.cedula})`;
                    this.showDropdown = false;
                },
                init() {
                    const oldId = '{{ old('id_cliente') }}';
                    if (oldId) {
                        const client = this.clientes.find(c => c.cedula == oldId);
                        if (client) this.selectCliente(client);
                    }
                }
            }">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">
                        Agendar Cita
                    </h1>
                    <p class="text-sm text-gray-500 font-medium mt-1">
                        Configura una nueva cita para un cliente.
                    </p>
                </div>
                <a href="{{ route('citas.index') }}" class="btn-secondary gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="h-4 w-4">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg>
                    Volver
                </a>
            </div>

            {{-- Form Section --}}
            <div class="card overflow-hidden">
                <form action="{{ route('citas.store') }}" method="POST">
                    @csrf

                    <div class="p-6 sm:p-8 space-y-10">

                        {{-- Sección del Cliente --}}
                        <div class="space-y-6">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Información
                                    del Cliente</h2>

                                {{-- Toggle Cliente Nuevo o Existente --}}
                                <div class="flex gap-4 mb-6">
                                    <label
                                        class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none transition-all"
                                        :class="{ 'border-primary-500 ring-1 ring-primary-500': esNuevoCliente === '0', 'border-gray-200': esNuevoCliente !== '0' }">
                                        <input type="radio" x-model="esNuevoCliente" name="es_nuevo_cliente" value="0"
                                            class="sr-only">
                                        <span class="flex flex-1">
                                            <span class="flex flex-col">
                                                <span class="block text-sm font-medium text-gray-900">Cliente
                                                    Existente</span>
                                                <span class="mt-1 flex items-center text-sm text-gray-500">Buscar en
                                                    sistema</span>
                                            </span>
                                        </span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="h-5 w-5 text-primary-600"
                                            x-show="esNuevoCliente === '0'">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                            <path d="m9 11 3 3L22 4" />
                                        </svg>
                                    </label>

                                    <label
                                        class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none transition-all"
                                        :class="{ 'border-primary-500 ring-1 ring-primary-500': esNuevoCliente === '1', 'border-gray-200': esNuevoCliente !== '1' }">
                                        <input type="radio" x-model="esNuevoCliente" name="es_nuevo_cliente" value="1"
                                            class="sr-only">
                                        <span class="flex flex-1">
                                            <span class="flex flex-col">
                                                <span class="block text-sm font-medium text-gray-900">Cliente Nuevo</span>
                                                <span class="mt-1 flex items-center text-sm text-gray-500">Registrar
                                                    ahora</span>
                                            </span>
                                        </span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="h-5 w-5 text-primary-600"
                                            x-show="esNuevoCliente === '1'" style="display: none;">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                            <path d="m9 11 3 3L22 4" />
                                        </svg>
                                    </label>
                                </div>

                                {{-- Select Cliente Existente (Searchable) --}}
                                <div x-show="esNuevoCliente === '0'" x-transition class="space-y-4 relative z-50" >
                                    <div class="relative">
                                        <label for="search_cliente" class="label-field">
                                            Seleccionar Cliente <span class="text-red-500">*</span>
                                        </label>
                                        
                                        <div class="relative group">
                                            <input type="text" 
                                                x-model="searchCliente" 
                                                @input="showDropdown = true; selectedCliente = null"
                                                @focus="showDropdown = true"
                                                @click.away="showDropdown = false"
                                                class="input-field pr-10" 
                                                placeholder="Busque por nombre o número de cédula..."
                                                autocomplete="off"
                                                id="search_cliente">
                                            
                                            {{-- Icono de búsqueda --}}
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                            </div>

                                            {{-- Dropdown de resultados --}}
                                            <div x-show="showDropdown && searchCliente.length > 0" 
                                                x-cloak
                                                class="absolute z-20 mt-2 w-full bg-white shadow-xl max-h-72 rounded-xl py-2 border border-gray-100 overflow-auto focus:outline-none sm:text-sm animate-fade-in"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 translate-y-1"
                                                x-transition:enter-end="opacity-100 translate-y-0">
                                                
                                                <template x-for="cliente in filteredClientes" :key="cliente.cedula">
                                                    <div @click="selectCliente(cliente)" 
                                                        class="cursor-pointer select-none relative py-3 px-4 hover:bg-primary-50 transition-colors border-b border-gray-50 last:border-0 group/item">
                                                        <div class="flex flex-col">
                                                            <span class="block truncate font-semibold text-gray-900 group-hover/item:text-primary-700" x-text="cliente.nombre"></span>
                                                            <span class="block truncate text-xs text-gray-500" x-text="'Cédula: ' + cliente.cedula"></span>
                                                        </div>
                                                        <span x-show="selectedCliente && selectedCliente.cedula === cliente.cedula" 
                                                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-primary-600">
                                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </template>

                                                <div x-show="filteredClientes.length === 0" class="py-4 px-4 text-center">
                                                    <svg class="mx-auto h-8 w-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <p class="text-sm text-red-500 font-medium">
                                                        El usuario no está registrado en el sistema.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        {{-- Input oculto para el formulario --}}
                                        <input type="hidden" name="id_cliente" :value="selectedCliente ? selectedCliente.cedula : ''">
                                        
                                        @error('id_cliente')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>


                                {{-- Formulario Cliente Nuevo --}}
                                <div x-show="esNuevoCliente === '1'" x-transition x-cloak
                                    class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 p-5 bg-gray-50 border border-gray-200 rounded-xl">
                                    <div>
                                        <label for="nuevo_cliente_cedula" class="label-field">Cédula <span
                                                class="text-red-500">*</span></label>
                                        <input type="number" name="nuevo_cliente_cedula" id="nuevo_cliente_cedula"
                                            value="{{ old('nuevo_cliente_cedula') }}" class="input-field">
                                    </div>

                                    <div>
                                        <label for="nuevo_cliente_nombre" class="label-field">Nombre Completo <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="nuevo_cliente_nombre" id="nuevo_cliente_nombre"
                                            value="{{ old('nuevo_cliente_nombre') }}" class="input-field">
                                    </div>

                                    <div>
                                        <label for="nuevo_cliente_telefono" class="label-field">Teléfono <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="nuevo_cliente_telefono" id="nuevo_cliente_telefono"
                                            value="{{ old('nuevo_cliente_telefono') }}" class="input-field">
                                    </div>

                                    <div>
                                        <label for="nuevo_cliente_correo" class="label-field">Correo Electrónico <span
                                                class="text-red-500">*</span></label>
                                        <input type="email" name="nuevo_cliente_correo" id="nuevo_cliente_correo"
                                            value="{{ old('nuevo_cliente_correo') }}" class="input-field">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sección de la Cita --}}
                        <div class="space-y-6">
                            <h2 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Detalles de la
                                Cita</h2>

                            <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">

                                <div class="mb-4" x-data="{ fechaHora: '' }" x-init="
    flatpickr($refs.miCalendario, {
        enableTime: true,          // Habilita la selección de hora
        dateFormat: 'Y-m-d H:i',   // Formato que entiende Laravel por defecto
        locale: 'es',              // Lo pasa a español
        time_24hr: false,          // Usa AM/PM (o true si prefieres formato 24h)
        minDate: 'today',          // No permite agendar citas en el pasado
        minTime: '08:00',          // Opcional: Hora de apertura
        maxTime: '19:00',          // Opcional: Hora de cierre
        minuteIncrement: 15,       // Los minutos saltan de 15 en 15 (ideal para citas)
    })
">
    <label for="fecha" class="block text-sm font-medium text-gray-700 mb-1">
        Fecha y Hora de la Cita
    </label>
    
    <div class="relative">
        <input 
            x-ref="miCalendario"
            type="text" 
            x-model="fechaHora"
            name="fecha" 
            id="fecha"
            class="w-full pl-10 pr-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 text-gray-900 shadow-sm transition-colors cursor-pointer"
            placeholder="Selecciona el día y la hora..."
            readonly
        >
        
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
    </div>
</div>

                                {{-- Habitación --}}
                                <div>
                                    <label for="habitacion" class="label-field">Habitación N° <span
                                            class="text-red-500">*</span></label>
                                    {{-- <input type="number" name="habitacion" id="habitacion" value="{{ old('habitacion') }}"
                                        min="1" class="input-field"> --}}
                                    <select name="habitacion" id="habitacion" class="input-field">
                                        <option value="">Seleccione una habitación...</option>
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ old('habitacion') == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                {{-- Masajista --}}
                                <div class="sm:col-span-2">
                                    <label for="masajista" class="label-field">Masajista Asignado <span
                                            class="text-red-500">*</span></label>
                                    <select id="masajista" name="masajista" class="select-field">
                                        <option value="">Seleccione un masajista...</option>
                                        @foreach($masajistas as $mas)
                                            <option value="{{ $mas->cedula }}" {{ old('masajista') == $mas->cedula ? 'selected' : '' }}>
                                                {{ $mas->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Servicios (Checkbox Group) --}}
                                <div class="sm:col-span-2 mt-4 space-y-3">
                                    <fieldset>
                                        <legend class="text-sm font-medium leading-6 text-gray-900">Servicios a realizar
                                            <span class="text-red-500">*</span></legend>
                                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            @foreach($servicios as $servicio)
                                                <div 
                                                    class="relative flex items-center p-4 border border-gray-200 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                                                    <div class="flex h-6 items-center">
                                                        <input id="servicio_{{ $servicio->id_servicio }}" name="servicios[]"
                                                            value="{{ $servicio->id_servicio }}" type="checkbox"
                                                            class="h-5 w-5 rounded border-gray-300 text-primary-600 focus:ring-primary-600"
                                                            {{ is_array(old('servicios')) && in_array($servicio->id_servicio, old('servicios')) ? 'checked' : '' }}>
                                                    </div>
                                                    <div class="ml-3 text-sm leading-6 flex-1">
                                                        <label for="servicio_{{ $servicio->id_servicio }}"
                                                            class="font-medium text-gray-900 select-none cursor-pointer">
                                                            {{ $servicio->nombre_servicio }}
                                                        </label>
                                                        <p class="text-gray-500">${{ number_format($servicio->precio, 0) }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </fieldset>
                                </div>

                                {{-- Nota --}}
                                <div class="sm:col-span-2">
                                    <label for="nota" class="label-field">Notas Opcionales</label>
                                    <textarea id="nota" name="nota" rows="3"
                                        class="input-field">{{ old('nota') }}</textarea>
                                    <p class="mt-1 text-sm text-gray-500">Ejemplo: Condiciones médicas, preferencias
                                        especiales del cliente, etc.</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Footer con Botones --}}
                    <div class="bg-gray-50 px-6 py-5 sm:flex sm:flex-row-reverse sm:px-8 border-t border-gray-200">
                        <button type="submit" class="btn-primary w-full sm:w-auto sm:ml-3 gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="h-4 w-4">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                <polyline points="17 21 17 13 7 13 7 21" />
                                <polyline points="7 3 7 8 15 8" />
                            </svg>
                            Guardar Cita
                        </button>
                        <a href="{{ route('citas.index') }}" class="btn-secondary w-full sm:w-auto mt-3 sm:mt-0">
                            Cancelar
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection