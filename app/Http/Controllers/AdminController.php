<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Citas;
use App\Models\Clientes;
use App\Models\Masajista;
use App\Models\Servicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Show the login form.
     */
    public function login(): View
    {
        return view('login');
    }

    /**
     * Handle the login request.
     */
    public function loginSubmit(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string',
            'contrasena' => 'required|string',
        ], [
            'usuario.required' => 'El campo usuario es obligatorio.',
            'contrasena.required' => 'La contraseña es obligatoria.',
        ]);

        // Find admin by username
        $admin = Admin::where('usuario', $request->usuario)->first();

        if ($admin && Hash::check($request->contrasena, $admin->contrasena)) {
            // Login the admin using the 'admin' guard
            Auth::guard('admin')->login($admin);

            // Regenerate session to prevent session fixation
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'usuario' => 'Las credenciales proporcionadas no son correctas.',
        ])->withInput($request->only('usuario'));
    }

    /**
     * Logout the admin.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Display a listing of the resource.
     */
    public function dashboard(): View
    {
        $citasHoy = Citas::whereDate('fecha', today())->count();
        $citasHoyFinalizadas = Citas::whereDate('fecha', today())->where('estado', 'finalizada')->count();
        $citasPendientes = Citas::where('estado', 'pendiente')->count();
        $citasConfirmadas = Citas::where('estado', 'confirmada')->count();
        $totalCitas = Citas::count();
        $totalCitasFinalizadas = Citas::where('estado', 'finalizada')->count();
        $totalClientes = Clientes::count();
        $totalMasajistas = Masajista::count();
        $totalServicios = Servicios::count();

        $citasparahoy = Citas::with(['cliente', 'masajistaRel', 'servicios'])
            ->whereBetween('fecha', [now(), now()->endOfDay()])
            ->orderBy('fecha', 'asc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalCitas',
            'citasPendientes',
            'citasConfirmadas',
            'citasHoy',
            'citasHoyFinalizadas',
            'totalCitasFinalizadas',
            'totalClientes',
            'totalMasajistas',
            'totalServicios',
            'citasparahoy',
        ));
    }
}
