<?php

namespace App\Http\Controllers;

use App\Models\Agendamiento;
use Illuminate\Http\Request;
use App\Models\Tecnico; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AgendamientoController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            // Redirigir al usuario al login si no está autenticado
            return redirect()->route('login');
        }
    
        // Obtener el mes y el año actual
        $currentMonth = date('m');
        $currentYear = date('Y');
    
        // Filtrar los registros del mes actual
        $agendamientos = Agendamiento::whereMonth('created_at', $currentMonth)
                                     ->whereYear('created_at', $currentYear)
                                     ->get();
    
        return view('agendamientos.index', compact('agendamientos'));
    }
    

    public function create()
    {
        // Mostrar el formulario para crear un nuevo agendamiento
        return view('agendamientos.create');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'codigo' => 'required|string|max:255', // Ajusta las reglas según tu necesidad
            'numero' => 'required|string|max:255',
            'nombre_tecnico' => 'required|string|max:255',
            'tipo_agendamiento' => 'nullable|string|max:255',
            'fecha_agendamiento' => 'required|date',
            'hora_agendamiento' => 'required|date_format:H:i',
            'numero_orden' => 'required|string|max:255',
            'observaciones' => 'required|string|max:1000',
        ]);

        // Agregar el ID del usuario que está creando el registro
        $userId = auth()->id();

        // Crear un nuevo agendamiento en la base de datos usando los datos validados
        $agendamiento = Agendamiento::create([
            'codigo' => $validatedData['codigo'],
            'numero' => $validatedData['numero'],
            'nombre_tecnico' => $validatedData['nombre_tecnico'],
            'tipo_agendamiento' => $validatedData['tipo_agendamiento'],
            'fecha_agendamiento' => $validatedData['fecha_agendamiento'],
            'hora_agendamiento' => $validatedData['hora_agendamiento'],
            'numero_orden' => $validatedData['numero_orden'],
            'observaciones' => $validatedData['observaciones'],
            'usuario_id' => $userId,
        ]);

        // Obtener el numeroid del agendamiento recién creado
        $numeroid = $agendamiento->numeroid;

        // Redirigir a la vista principal con un mensaje de éxito
        return redirect()->route('agendamientos.index')->with('message', 'CONSULTA#: ' . $numeroid);
    }



    public function show(Agendamiento $agendamiento)
    {
        return view('agendamientos.show', compact('agendamiento'));
    }

    public function edit(Agendamiento $agendamiento)
    {
        return view('agendamientos.edit', compact('agendamiento'));
    }

    public function update(Request $request, Agendamiento $agendamiento)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'codigo' => 'required|string|unique:agendamientos,codigo,' . $agendamiento->id,
            'numero' => 'required|string',
            'nombre_tecnico' => 'required|string',
            'tipo_agendamiento' => 'required|in:Instalaciones,Postventas,Reparaciones',
            'fecha_agendamiento' => 'required|date',
            'hora_agendamiento' => 'required|date_format:H:i',
            'numero_orden' => 'required|string',
            'observaciones' => 'nullable|string',
            'numeroid' => 'required|string',
        ]);

        // Actualizar el agendamiento
        $agendamiento->update($validatedData);

        return redirect()->route('agendamientos.index')->with('success', 'Agendamiento actualizado con éxito.');
    }

    public function destroy(Agendamiento $agendamiento)
    {
        // Eliminar el agendamiento
        $agendamiento->delete();

        return redirect()->route('agendamientos.index')->with('success', 'Agendamiento eliminado con éxito.');
    }

    public function getTecnico(Request $request, $codigo)
    {
        // Buscar al técnico por su código
        $tecnico = Tecnico::where('codigo', $codigo)->first();
        
        if ($tecnico) {
            // Verificar si el estado del técnico es "Activo"
            if ($tecnico->status === "Activo") {
                $fechaHoy = Carbon::today()->toDateString();
                $agendamientosHoy = Agendamiento::where('codigo', $codigo)
                    ->whereDate('created_at', $fechaHoy)
                    ->with('user') // Asegúrate de cargar la relación 'user'
                    ->get();
            
                return response()->json([
                    'success' => true,
                    'message' => 'Técnico encontrado y está activo',
                    'tecnico' => [
                        'numero' => $tecnico->numero,
                        'nombre_tecnico' => $tecnico->nombre_tecnico
                    ],
                    'agendamientos' => $agendamientosHoy
                ]);
            } else {
                // Devolver una respuesta de error si el técnico no está activo
                return response()->json([
                    'success' => false,
                    'message' => 'Técnico no está activo',
                    'tecnico' => null,
                    'agendamientos' => []
                ]);
            }
        } else {
            // Devolver una respuesta de error si el técnico no fue encontrado
            return response()->json([
                'success' => false,
                'message' => 'Técnico no encontrado',
                'tecnico' => null,
                'agendamientos' => []
            ]);
        }
    }


}