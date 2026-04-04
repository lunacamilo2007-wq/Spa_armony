<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicios;
use App\Http\Requests\Servicios\StoreServiciosRequest;
use App\Http\Requests\Servicios\UpdateServiciosRequest;
use App\Services\Servicios\ServiciosService;

class ServiciosController extends Controller
{
    public function __construct(protected ServiciosService $service)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = Servicios::all();
        return view('servicios.index', compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('servicios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiciosRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('servicios.index')
            ->with('success', 'servicio registrado exitosamente. ');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $servicio = Servicios::findOrFail($id);
        return view('servicios.edit', compact('servicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiciosRequest $request, string $id)
    {
        $this->service->update($id, $request->validated());
        return redirect()->route('servicios.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->service->delete($id);
        return redirect()->route('servicios.index')
            ->with('success', 'Servicio eliminado correctamente.');
    }
}
