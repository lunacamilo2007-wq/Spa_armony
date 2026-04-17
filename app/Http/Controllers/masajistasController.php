<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masajista;
use App\Models\Servicios;
use App\Http\Requests\Masajistas\StoreMasajistaRequest;
use App\Http\Requests\Masajistas\UpdateMasajistaRequest;
use App\Services\Masajistas\MasajistasService;

class masajistasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected MasajistasService $service)
    {

    }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $masajistas = $this->service->obtenerMasajistas($search);
        return view('masajistas.index', compact('masajistas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $servicios = Servicios::all();
        return view('masajistas.create', compact('servicios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMasajistaRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('masajistas.index')
            ->with('success', 'Masajista registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $masajista = Masajista::find($id);
        $servicios = Servicios::all();
        return view('masajistas.show', compact('masajista', 'servicios'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $masajista = Masajista::findOrFail($id);
        $servicios = Servicios::all();
        return view('masajistas.edit', compact('masajista', 'servicios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasajistaRequest $request, string $id)
    {
        $masajista = $this->service->update($id, $request->validated());
        return redirect()->route('masajistas.index')
            ->with('success', 'Masajista actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->service->delete($id);
        return redirect()->route('masajistas.index')
            ->with('success', 'Masajista eliminado correctamente.');
    }
}
