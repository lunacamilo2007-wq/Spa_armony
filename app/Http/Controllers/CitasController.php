<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use App\Models\Clientes;
use App\Models\Masajista;
use App\Models\Servicios;
use App\Http\Requests\Citas\StoreCitasRequest;
use App\Http\Requests\Citas\UpdateCitasRequest;
use App\Services\Citas\CitasService;


class CitasController extends Controller
{
    public function __construct(protected CitasService $service)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citas = Citas::with(['cliente', 'masajistaRel', 'servicios'])->get();
        return view('citas.index', compact('citas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Clientes::all();
        $masajistas = Masajista::all();
        $servicios = Servicios::all();
        return view('citas.create', compact('clientes', 'masajistas', 'servicios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCitasRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('citas.index')
            ->with('success', 'Cita registrada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cita = Citas::with(['cliente', 'masajistaRel', 'servicios'])->findOrFail($id);
        return view('citas.show', compact('cita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $citas = Citas::findOrFail($id);
        $clientes = Clientes::all();
        $masajistas = Masajista::all();
        $servicios = Servicios::all();
        return view('citas.edit', compact('citas', 'clientes', 'masajistas', 'servicios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCitasRequest $request, string $id)
    {
        $this->service->update($id, $request->validated());
        return redirect()->route('citas.index')
            ->with('success', 'Cita actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->service->delete($id);
        return redirect()->route('citas.index')
            ->with('success', 'Cita eliminada exitosamente.');
    }

    public function cancel(string $id)
    {
        $this->service->changeStatus($id, 'cancelada');
        return redirect()->route('citas.index')
            ->with('success', 'Cita cancelada exitosamente.');
    }

    public function confirm(string $id)
    {
        $this->service->changeStatus($id, 'confirmada');
        return redirect()->route('citas.index')
            ->with('success', 'Cita confirmada exitosamente.');
    }

    public function finalize(string $id)
    {
        $this->service->changeStatus($id, 'finalizada');
        return redirect()->route('citas.index')
            ->with('success', 'Cita finalizada exitosamente.');
    }
}
