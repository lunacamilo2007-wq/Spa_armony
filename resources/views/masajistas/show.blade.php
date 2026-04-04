@extends('layouts.app')

@section('titulo', 'Detalles del masajista')

@section('contenido')
<h1>Detalles del masajista</h1>
<p><strong>Cedula:</strong> {{ $masajista->cedula }}</p>
<p><strong>Nombre:</strong> {{ $masajista->nombre }}</p>
<p><strong>Teléfono:</strong> {{ $masajista->telefono }}</p>
<a href="{{ route('masajistas.index') }}">Volver</a>