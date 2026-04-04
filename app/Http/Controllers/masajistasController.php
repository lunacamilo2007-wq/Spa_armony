<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masajista;
use App\Http\Requests\StoreMasajistaRequest;
use App\Http\Requests\UpdateMasajistaRequest;
use App\Services\Masajistas\MasajistasService;

class masajistasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected MasajistasService $service)
    {

    }
    public function index()
    {
        $masajistas = Masajista::all();
        return view('masajistas.index', compact('masajistas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('masajistas.create');
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
        return view('masajistas.show', compact('masajista'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $masajista = Masajista::findOrFail($id);
        return view('masajistas.edit', compact('masajista'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMasajistaRequest $request, string $id)
    {
        $masajista = Masajista::findOrFail($id);
        $masajista->update($request->only(['nombre', 'telefono']));
        return redirect()->route('masajistas.index')
            ->with('success', 'Masajista actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $masajista = Masajista::findOrFail($id);
        $masajista->delete();
        return redirect()->route('masajistas.index')
            ->with('success', 'Masajista eliminado correctamente.');
    }
}
