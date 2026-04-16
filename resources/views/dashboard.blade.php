@extends('layouts.app')

@section('titulo', 'Dashboard - Spa Armonía')

@section('contenido')
    <div class="bg">
        <div class="max">

            {{-- Header --}}
            <div class="mb-8">
                <h1>Dashboard</h1>
                <p>Resumen general Spa Armonía</p>
            </div>

            {{-- Stats --}}
            <div class="grid">
                {{-- Citas Pendientes --}}
                {{--<div class="stat">
                    <div class="flex">
                        <div class="w-12">
                            <svg></svg>
                        </div>
                    </div>
                    <div class="text">{{ $citasPendientes }}</div>
                    <div class="text-sm">Citas Pendientes</div>
                </div> --}}

                {{-- Citas Hoy --}}
                {{--<div class="stat-card">
                    <div class="flex">
                        <div class="w-12">
                            <svg></svg>
                        </div>
                    </div>
                    <div class="text">{{ $citasHoy }}</div>
                    <div class="text-sm">Citas hoy</div>
                </div>--}}

                {{--Total Clientes --}}
                <div class="stat">
                    <div class="flex">
                        <div class="w-12">
                            <svg></svg>
                        </div>
                    </div>
                    <div class="text">{{ $totalClientes }}</div>
                    <div class="text-sm">Clientes</div>
                </div>

                {{-- Masajistas --}}
                -<div class="stat">
                    <div class="flex">
                        <div class="w-12">
                            <svg></svg>
                        </div>
                    </div>
                    <div class="text">{{ $totalMasajistas}}</div>
                    <div class="text-sm">Masajistas</div>
                </div>
            </div>

            {{-- Acciones rapidas --}}
            <div class="grid">
                {{-- Acciones rapidas --}}
                <div class="card">
                    <h2>Acciones rapidas</h2>
                    <div class="space">
                        <a href="{{ route('citas.create') }}">
                            <div class="w-10">
                                <svg></svg>
                            </div>
                            <span class="font-medium">Nueva Cita</span>
                        </a>
                        <a href="{{ route('clientes.index') }}">
                            <div class="w-10">
                                <svg></svg>
                            </div>
                            <span class="font-medium">Ver Clientes</span>
                        </a>
                        <a href="{{ route('masajistas.index') }}">
                            <div class="w-10">
                                <svg></svg>
                            </div>
                            <span class="font-medium">Ver Masajistas</span>
                        </a>
                        <a href="{{ route('servicios.index') }}">
                            <div class="w-10">
                                <svg></svg>
                            </div>
                            <span class="font-medium">Ver Servicios</span>
                        </a>
                    </div>
                </div>

                {{-- Citas Pendientes --}}
                {{--<div class="lg:col">
                    <div class="flex">
                        <h2>Citas Pendientes</h2>
                        <a href="{{ route('citas.index') }}">Ver todas</a>
                    </div>

                    @if($citasPendientes->count() > 0)
                    <div class="space">
                        @foreach($citasPendientes as $cita)
                        <div class="flex">

                            {{-- Avatar
                            <div class="w10">
                                {{ strtoupper(substr($cita->cliente->nombre ?? '?', 0, 2)) }}
                            </div>

                            {{-- Info
                            <div class="flex">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-gray-900 dark:text-white truncate">{{
                                        $cita->cliente->nombre ?? 'N/A' }}</span>
                                    <x-badge :estado="$cita->estado" />
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                    {{ $cita->fecha->format('d M Y, H:i') }} ·
                                    {{ $cita->masajistaRelation->nombre_masajista ?? 'N/A' }}
                                </div>
                            </div>

                            {{-- Total
                            <div class="text-right">
                                <span>${{ number_format($cita->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p>No hay citas pendientes</p>
                    @endif
                </div>--}}
            </div>
        </div>
    </div>
@endsection