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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            {{-- Total Clientes --}}
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900">{{ $totalClientes }}</div>
                <div class="text-sm text-gray-500">Clientes</div>
            </div>

            {{-- Masajistas --}}
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900">{{ $totalMasajistas }}</div>
                <div class="text-sm text-gray-500">Masajistas</div>
            </div>

            {{-- Servicios --}}
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900">{{ $totalServicios }}</div>
                <div class="text-sm text-gray-500">Servicios</div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="card p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Acciones Rápidas</h2>
                <div class="space-y-3">
                    <a href="{{ route('citas.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary-50 transition-colors group">
                        <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <span class="font-medium text-gray-700">Nueva Cita</span>
                    </a>
                    <a href="{{ route('clientes.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 transition-colors group">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="font-medium text-gray-700">Ver Clientes</span>
                    </a>
                    <a href="{{ route('masajistas.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-purple-50 transition-colors group">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <span class="font-medium text-gray-700">Ver Masajistas</span>
                    </a>
                    <a href="{{ route('servicios.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-amber-50 transition-colors group">
                        <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <span class="font-medium text-gray-700">Ver Servicios</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection