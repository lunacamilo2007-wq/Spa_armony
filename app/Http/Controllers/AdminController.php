<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Clientes;
use App\Models\Masajista;
use App\Models\Servicios;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard(): View
    {
        // $totalCitas = Cita::count();
        // $citasPendientes = Cita::where('estado', 'pendiente')->count();
        // $citasConfirmadas = Cita::where('estado', 'confirmada')->count();
        // $citasHoy = Cita::whereDate('fecha', today())->count();
        $totalClientes = Clientes::count();
        $totalMasajistas = Masajista::count();
        $totalServicios = Servicios::count();

        // $citasRecientes = Cita::with('cliente', 'masajistaRelation', 'servicios')
        //     ->orderBy('fecha', 'desc')
        //     ->limit(5)
        //     ->get();

        return view('dashboard', compact(
            // 'totalCitas',
            // 'citasPendientes',
            // 'citasConfirmadas',
            // 'citasHoy',
            'totalClientes',
            'totalMasajistas',
            'totalServicios',
            // 'citasRecientes', 
        ));
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
