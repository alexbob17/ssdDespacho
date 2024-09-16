<?php

namespace App\Http\Controllers;

use App\Models\EditarConsulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditarConsultasController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Verifica si hay un usuario autenticado
            if (!auth()->check()) {
                return redirect('/login')->with('error', 'Por favor, inicia sesión para acceder a esta página.');
            }

            // Verifica si el usuario autenticado tiene uno de los roles necesarios
            if (!auth()->user()->hasRole(['admin', 'supervisor n2', 'supervisor n1'])) {
                return redirect('/home')->with('error', 'No tienes permiso para acceder a esta página.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        // Verifica si el usuario autenticado tiene uno de los roles necesarios
        if (!auth()->user()->hasRole(['supervisor n1', 'admin', 'supervisor n2'])) {
            return redirect('/home')->with('error', 'No tienes permiso para acceder a esta página.');
        }

        // Obtener todas las consultas
        $consultas = EditarConsulta::all();

        // Retornar la vista con las consultas
        return view('consultasedit.index', compact('consultas'));
    }

    public function create()
    {
        if (!auth()->user()->hasRole(['admin', 'supervisor n2'])) {
            return redirect('/home')->with('error', 'No tienes permiso para acceder a esta página.');
        }
        return view('consultasedit.create');
    }

    public function store(Request $request)
    {

        if (!auth()->user()->hasRole(['admin', 'supervisor n2'])) {
            return redirect('/home')->with('error', 'No tienes permiso para acceder a esta página.');
        }
        // Validar los datos ingresados
        $request->validate([
            'MotivoConsulta' => 'required|string|max:255',
        ]);

        // Crear una nueva consulta con los datos validados
        EditarConsulta::create([
            'MotivoConsulta' => strtoupper($request->input('MotivoConsulta')),  // Almacena en mayúsculas
        ]);

        // Redirigir al índice de consultas con un mensaje de éxito
        return redirect()->route('editarconsultas.index')->with('message', 'Consulta registrada con éxito');
    }

    public function edit($id)
    {

        if (!auth()->user()->hasRole(['admin', 'supervisor n2'])) {
            return redirect('/home')->with('error', 'No tienes permiso para acceder a esta página.');
        }
        $consulta = EditarConsulta::findOrFail($id); // Busca la consulta por ID o lanza un error 404
        return view('consultasedit.edit', compact('consulta')); // Cambia la ruta de la vista aquí
    }

    public function update(Request $request, $id)
    {

        if (!auth()->user()->hasRole(['admin', 'supervisor n2'])) {
            return redirect('/home')->with('error', 'No tienes permiso para acceder a esta página.');
        }
        // Validar los datos ingresados
        $request->validate([
            'MotivoConsulta' => 'required|string|max:255',
        ]);

        // Busca la consulta por ID o lanza un error 404
        $consulta = EditarConsulta::findOrFail($id);

        // Actualiza los datos de la consulta
        $consulta->update([
            'MotivoConsulta' => strtoupper($request->input('MotivoConsulta')),  // Guarda en mayúsculas
        ]);

        // Redirige al índice de consultas con un mensaje de éxito
        return redirect()->route('editarconsultas.index')->with('message', 'Consulta actualizada con éxito');
    }

    public function destroy($id)
    {

        if (!auth()->user()->hasRole([ 'admin', 'supervisor n2'])) {
            return redirect('/home')->with('error', 'No tienes permiso para acceder a esta página.');
        }
        $consulta = EditarConsulta::findOrFail($id);
        $consulta->delete();

        return response()->json(['success' => true]);
    }
}