@extends('layouts.app')

@section('titulo', 'Citas')

@section('contenido')

    <h1>Citas</h1>
    <a href="{{ route('citas.create') }}">Crear Cita</a>



@endsection