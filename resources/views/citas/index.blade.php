@extends('layouts.app')

@section('titulo', 'Historial de Citas')

@section('contenido')
    <div class="bg-surface-50 min-h-[calc(100vh-4rem)]" id="citas-index-page">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Historial de Citas</h1>
                    <p class="text-primary-600 text-sm mt-0.5">{{ $citas->count() }} citas</p>
                </div>
                <a href="{{ route('citas.create') }}" class="btn-primary mt-4 sm:mt-0" id="btn-nueva-cita-page">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nueva Cita
                </a>
            </div>

            {{-- Citas List --}}
            @if($citas->count() > 0)
                <div class="space-y-4">
                    @foreach($citas as $cita)
                        <div class="card p-6 animate-fade-in" id="cita-{{ $cita->id_cita }}" x-data="{ open: false }"
                            :class="{ 'relative z-50': open }">
                            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                                {{-- Avatar + Client Info --}}
                                <div class="flex items-start gap-4 flex-1 min-w-0">
                                    <div
                                        class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold shrink-0">
                                        {{ strtoupper(substr($cita->cliente->nombre ?? '?', 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h3 class="font-semibold text-gray-900">{{ $cita->cliente->nombre ?? 'N/A' }}</h3>
                                            @if($cita->servicios->first())
                                                <span class="text-sm text-gray-500">·
                                                    {{ $cita->servicios->first()->nombre_servicio }}</span>
                                            @endif
                                        </div>
                                        <div class="flex flex-wrap gap-x-6 gap-y-1 mt-2 text-sm text-gray-500">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $cita->fecha->format('d M, Y') }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $cita->fecha->format('H:i') }}
                                                @if($cita->duracion_total)
                                                    ({{ $cita->duracion_total }} min)
                                                @endif
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ $cita->masajistaRel->nombre ?? 'N/A' }}
                                            </span>
                                            @if($cita->habitacion)
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                    Hab. {{ $cita->habitacion }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1">
                                            Cédula: {{ $cita->cliente->cedula ?? '' }} · Tel:
                                            {{ $cita->cliente->telefono ?? 'N/A' }} · Email: {{ $cita->cliente->correo ?? 'N/A' }}
                                        </div>
                                        {{-- Service tags --}}
                                        <div class="flex flex-wrap gap-2 mt-3">
                                            @foreach($cita->servicios as $srv)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-primary-50 text-primary-700 border border-primary-200">
                                                    {{ $srv->nombre_servicio }} - ${{ number_format($srv->precio, 0, ',', '.') }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Status + Total + Actions --}}
                                <div class="flex items-center gap-4 lg:flex-col lg:items-end shrink-0">
                                    <span class="badge-{{ $cita->estado }}">{{ ucfirst($cita->estado) }}</span>
                                    <span
                                        class="text-lg font-bold text-gray-900">${{ number_format($cita->total, 0, ',', '.') }}</span>

                                    {{-- Actions Dropdown --}}
                                    <div class="relative">
                                        <button @click="open = !open"
                                            class="p-2 rounded-lg text-gray-400 hover:bg-gray-100 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </button>
                                        <div x-show="open" @click.outside="open = false" x-transition
                                            class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                                            @if($cita->estado === 'pendiente')
                                                <form method="POST" action="{{ route('citas.confirm', $cita->id_cita) }}">
                                                    @csrf @method('PATCH')
                                                    <button type="submit"
                                                        class="w-full text-left px-4 py-2 text-sm text-primary-600 hover:bg-gray-50">✓
                                                        Confirmar</button>
                                                </form>
                                            @endif
                                            @if(in_array($cita->estado, ['pendiente', 'confirmada']))
                                                <form method="POST" action="{{ route('citas.cancel', $cita->id_cita) }}">
                                                    @csrf @method('PATCH')
                                                    <button type="submit"
                                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">✕
                                                        Cancelar</button>
                                                </form>
                                                <form method="POST" action="{{ route('citas.finalize', $cita->id_cita) }}">
                                                    @csrf @method('PATCH')
                                                    <button type="submit"
                                                        class="w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-gray-50">✓
                                                        Finalizar</button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('citas.destroy', $cita->id_cita) }}"
                                                onsubmit="return confirm('¿Eliminar esta cita?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">🗑
                                                    Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Notes --}}
                            @if($cita->nota)
                                <div class="mt-4 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                                    <span class="text-sm font-medium text-amber-700">Notas:</span>
                                    <span class="text-sm text-amber-600 ml-1">{{ $cita->nota }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-500 text-lg">No se encontraron citas.</p>
                    <a href="{{ route('citas.create') }}" class="btn-primary mt-4 inline-flex">Crear primera cita</a>
                </div>
            @endif
        </div>
    </div>
@endsection