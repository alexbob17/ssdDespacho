<?php

namespace App\Http\Controllers;

use App\Models\Anulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AnulacionController extends Controller
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
    // Mostrar la lista de anulaciones
    public function index()
    {

        // Verifica si el usuario autenticado tiene uno de los roles necesarios
        if (!auth()->user()->hasRole(['supervisor n1', 'admin', 'supervisor n2'])) {
            return redirect('/home')->with('error', 'No tienes permiso para acceder a esta página.');
        }

        $anulacion = Anulacion::all(); // Obtener todas las anulaciones
        return view('editanulacion.index', compact('anulacion')); // Retornar la vista con los datos
    }

    // Mostrar el formulario para crear una nueva anulación
    public function create()
    {

        if (!auth()->user()->hasRole(['admin', 'supervisor n2'])) {
            return redirect('/home')->with('error', 'No tienes permiso para acceder a esta página.');
        }
        return view('editanulacion.create');
    }

    // Guardar la nueva anulación
    public function store(Request $request)
    {
        // Validar los datos ingresados
        $request->validate([
            'MotivoAnulacion' => 'required|string|max:255',
        ]);

        // Crear la anulación en la base de datos
        Anulacion::create($request->all());

        // Redirigir a la lista de anulaciones con un mensaje de éxito
        return redirect()->route('editanulacion.index')->with('message', 'Motivo Anulación creada con éxito.');
    }

    // Mostrar el formulario para editar una anulación existente
    public function edit($id)
    {
        if (!auth()->user()->hasRole(['admin', 'supervisor n2'])) {
            return redirect('/home')->with('error', 'No tienes permiso para acceder a esta página.');
        }
        $anulacion = Anulacion::findOrFail($id); // Buscar la anulación por ID
        return view('editanulacion.edit', compact('anulacion')); // Retornar la vista de edición con los datos
    }

    // Actualizar una anulación existente
    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasRole(['admin', 'supervisor n2'])) {
            return redirect('/home')->with('error', 'No tienes permiso para acceder a esta página.');
        }
        // Validar los datos ingresados
        $request->validate([
            'MotivoAnulacion' => 'required|string|max:255',
        ]);

        // Buscar y actualizar la anulación
        $anulacion = Anulacion::findOrFail($id);
        $anulacion->update($request->all());

        // Redirigir a la lista de anulaciones con un mensaje de éxito
        return redirect()->route('editanulacion.index')->with('message', 'Anulación actualizada con éxito.');
    }

    // Eliminar una anulación existente
    public function destroy($id)
    {
        $anulacion = Anulacion::findOrFail($id);
        $anulacion->delete();

        return response()->json(['success' => true]);
    }

}