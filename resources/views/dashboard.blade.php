@extends('layouts.app')

@section('titulo', 'Dashboard - Spa Armonía')

@section('contenido')
    <div class="bg-surface-50 min-h-[calc(100vh-4rem)]" id="dashboard-page">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-500 mt-1">Resumen general de SPA Armonía</p>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8"> {{-- Citas de Hoy --}}
                <div class="stat-card">
                    <div class="flex items-start justify-between">
                        <span class="text-sm font-semibold text-gray-500">Citas de Hoy</span>
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-1">
                        <div class="text-3xl font-bold text-gray-900">{{ $citasHoy }}</div>
                        <div class="text-xs text-gray-400 mt-1">{{ $citasHoyFinalizadas }} Finalizadas</div>
                    </div>
                </div>

                {{-- Citas pendientes --}}
                <div class="stat-card">
                    <div class="flex items-start justify-between">
                        <span class="text-sm font-semibold text-gray-500">Citas Pendientes</span>
                        <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-1">
                        <div class="text-3xl font-bold text-gray-900">{{ $citasPendientes }}</div>
                        <div class="text-xs text-gray-400 mt-1">{{ $citasConfirmadas }} Confirmadas</div>
                    </div>
                </div>

                {{-- Total de Citas --}}
                <div class="stat-card">
                    <div class="flex items-start justify-between">
                        <span class="text-sm font-semibold text-gray-500">Total de Citas</span>
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-1">
                        <div class="text-3xl font-bold text-gray-900">{{ $totalCitas }}</div>
                        <div class="text-xs text-gray-400 mt-1">{{ $totalCitasFinalizadas }} Completadas</div>
                    </div>
                </div>

                {{-- Total Clientes --}}
                <div class="stat-card">
                    <div class="flex items-start justify-between">
                        <span class="text-sm font-semibold text-gray-500">Clientes</span>
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-1">
                        <div class="text-3xl font-bold text-gray-900">{{ $totalClientes }}</div>
                        <div class="text-xs text-gray-400 mt-1">Registrados</div>
                    </div>
                </div>

                {{-- Masajistas --}}
                <div class="stat-card">
                    <div class="flex items-start justify-between">
                        <span class="text-sm font-semibold text-gray-500">Masajistas</span>
                        <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-1">
                        <div class="text-3xl font-bold text-gray-900">{{ $totalMasajistas }}</div>
                        <div class="text-xs text-gray-400 mt-1">En plantilla</div>
                    </div>
                </div>

                {{-- Servicios --}}
                <div class="stat-card">
                    <div class="flex items-start justify-between">
                        <span class="text-sm font-semibold text-gray-500">Servicios</span>
                        <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-1">
                        <div class="text-3xl font-bold text-gray-900">{{ $totalServicios }}</div>
                        <div class="text-xs text-gray-400 mt-1">Disponibles</div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="card p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Acciones Rápidas</h2>
                    <div class="space-y-3">
                        <a href="{{ route('citas.create') }}"
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary-50 transition-colors group">
                            <div
                                class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <span class="font-medium text-gray-700">Nueva Cita</span>
                        </a>
                        <a href="{{ route('clientes.index') }}"
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 transition-colors group">
                            <div
                                class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <span class="font-medium text-gray-700">Ver Clientes</span>
                        </a>
                        <a href="{{ route('masajistas.index') }}"
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-purple-50 transition-colors group">
                            <div
                                class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <span class="font-medium text-gray-700">Ver Masajistas</span>
                        </a>
                        <a href="{{ route('servicios.index') }}"
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-amber-50 transition-colors group">
                            <div
                                class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <span class="font-medium text-gray-700">Ver Servicios</span>
                        </a>
                    </div>
                </div>

                {{-- Recent Citas --}}
                <div class="lg:col-span-2 card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Citas para hoy</h2>
                        <a href="{{ route('citas.index', ['date' => now()->timezone('America/Bogota')->format('Y-m-d')]) }}"
                            class="text-sm text-primary-600 hover:text-primary-700 font-medium">Ver
                            las citas de hoy &rarr;</a>
                    </div>

                    @if($citasparahoy->count() > 0)
                        <div class="space-y-4">
                            @foreach($citasparahoy->take(3) as $cita)
                                <div class="flex items-center gap-4 p-4 rounded-lg bg-surface-50">
                                    {{-- Avatar --}}
                                    <div
                                        class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-sm shrink-0">
                                        {{ strtoupper(substr($cita->cliente->nombre ?? '?', 0, 2)) }}
                                    </div>

                                    {{-- Info --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="font-medium text-gray-900 truncate">{{ $cita->cliente->nombre ?? 'N/A' }}</span>
                                            <span class="badge-{{ $cita->estado }}">{{ ucfirst($cita->estado) }}</span>
                                        </div>
                                        <div class="text-sm text-gray-500 mt-0.5">
                                            {{ $cita->fecha->format('d M Y, H:i') }} ·
                                            {{ $cita->masajistaRel->nombre ?? 'N/A' }}
                                        </div>
                                    </div>

                                    {{-- Total --}}
                                    <div class="text-right shrink-0">
                                        <span
                                            class="text-lg font-bold text-gray-900">${{ number_format($cita->total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endforeach
                            @if ($citasparahoy->count() > 3)
                                <div class="align-right"><p>Más {{ $citasparahoy->count()-3 }} citas </p></div>
                            @endif
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No hay citas por hoy</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection