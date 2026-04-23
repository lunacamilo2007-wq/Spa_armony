{{-- Badge Component --}}
@props(['estado'])

@php
$classes = match($estado) {
    'pendiente'  => 'badge-pendiente',
    'confirmada' => 'badge-confirmada',
    'cancelada'  => 'badge-cancelada',
    'finalizada' => 'badge-finalizada',
    default      => 'badge bg-gray-100 text-gray-800',
};
$labels = match($estado) {
    'pendiente'  => 'Pendiente',
    'confirmada' => 'Confirmada',
    'cancelada'  => 'Cancelada',
    'finalizada' => 'Finalizada',
    default      => ucfirst($estado),
};
@endphp

<span class="{{ $classes }}" {{ $attributes }}>{{ $labels }}</span>
