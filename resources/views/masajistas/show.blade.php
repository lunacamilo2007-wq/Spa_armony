@extends('layouts.app')

@section('titulo', 'Detalles del masajista')

@section('contenido')
<h1>Detalles del masajista</h1>
<p><strong>Cedula:</strong> {{ $masajista->cedula }}</p>
<p><strong>Nombre:</strong> {{ $masajista->nombre }}</p>
<p><strong>Teléfono:</strong> {{ $masajista->telefono }}</p>
<p><strong>Porcentaje de comisión general:</strong>
    {{ rtrim(rtrim(number_format($masajista->porcentaje_comision, 2), '0'), '.') }}%</p>
@php
    $totalComision = $masajista->servicios->sum(function ($servicio) use ($masajista) {
        return $masajista->calcularComision($servicio->precio);
    });
@endphp

<p><strong>Comisión total a recibir:</strong> ${{ number_format($totalComision, 2) }}</p>

<p><strong>Servicios que ofrece:</strong></p>
<ul>
    @foreach ($masajista->servicios as $servicio)
        <li>
            {{ $servicio->nombre_servicio }} - ${{ number_format($servicio->precio, 2) }}
        </li>
    @endforeach
</ul>

<a href="{{ route('masajistas.index') }}">Volver</a>