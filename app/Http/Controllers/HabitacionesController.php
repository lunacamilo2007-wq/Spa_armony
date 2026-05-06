<?php

namespace App\Http\Controllers;

use App\Http\Requests\Habitaciones\StoreHabitacionRequest;
use App\Http\Requests\Habitaciones\UpdateHabitacionRequest;
use App\Models\Habitacion;
use App\Services\Habitaciones\HabitacionesService;
use Illuminate\Http\Request;

class HabitacionesController extends Controller
{
    public function __construct(protected HabitacionesService $service) {}

    public function index(Request $request)
    {
        $habitaciones = $this->service->obtenerHabitaciones($request->input('search'));

        return view('habitaciones.index', compact('habitaciones'));
    }

    public function create()
    {
        return view('habitaciones.create');
    }

    public function store(StoreHabitacionRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('habitaciones.index')
            ->with('success', 'Habitación creada exitosamente.');
    }

    public function edit(Habitacion $habitacion)
    {
        return view('habitaciones.edit', compact('habitacion'));
    }

    public function update(UpdateHabitacionRequest $request, Habitacion $habitacion)
    {
        $this->service->update($habitacion->id, $request->validated());

        return redirect()->route('habitaciones.index')
            ->with('success', 'Habitación actualizada exitosamente.');
    }

    public function destroy(Habitacion $habitacion)
    {
        $this->service->delete($habitacion->id);

        return redirect()->route('habitaciones.index')
            ->with('success', 'Habitación eliminada exitosamente.');
    }

    public function toggleEstado(Habitacion $habitacion)
    {
        $this->service->toggleEstado($habitacion->id);

        return redirect()->route('habitaciones.index')
            ->with('success', 'Estado de la habitación actualizado exitosamente.');
    }
}
