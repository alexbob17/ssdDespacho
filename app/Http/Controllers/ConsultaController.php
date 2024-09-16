<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Tecnico; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class ConsultaController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            // Redirigir al usuario al login si no está autenticado
            return redirect()->route('login');
        }

        $currentMonth = date('m');
        $currentYear = date('Y');

        // Crear la consulta con la relación 'user', filtrando por mes y año actuales
        $consultas = Consulta::with('user')
                            ->whereMonth('created_at', $currentMonth)
                            ->whereYear('created_at', $currentYear)
                            ->get();
                            
        $tecnico = null;

        // Obtener todos los registros de la tabla editarconsultas
        $motivos = DB::table('editarconsultas')->pluck('MotivoConsulta', 'id');

        // Filtrar por código de técnico si se proporciona
        if ($request->has('codigo_tecnico')) {
            $codigo_tecnico = $request->get('codigo_tecnico');
            $consultas->where('codigo_tecnico', $codigo_tecnico); // Filtrar por técnico si se proporciona

            // Buscar el técnico por código
            $tecnico = Tecnico::where('codigo', $codigo_tecnico)->first();
        }

        return view('consultas.index', compact('consultas', 'tecnico', 'motivos'));
    }



    // Muestra el formulario para crear una nueva consulta
    public function create()
    {
        return view('consultas.create');
    }

    // Almacena una nueva consulta en la base de datos
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'codigo_tecnico' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'nombre_tecnico' => 'required|string|max:255',
            'motivo_consulta' => 'required|string|max:255',
            'numero_orden' => 'required|string|max:255',
            'observaciones' => 'required|string',
        ]);
    
        // Ajustar la hora actual en la zona horaria deseada
        $currentDateTime = Carbon::now('America/Managua'); // Ajusta la zona horaria según tus necesidades
    
        $userId = auth()->id();
    
        // Crear una nueva consulta en la base de datos
        $consulta = Consulta::create(array_merge($validatedData, [
            'created_at' => $currentDateTime,
            'updated_at' => $currentDateTime, // Ajusta la hora de actualización si es necesario
            'user_id' => $userId // Agregar el ID del usuario al registro
        ]));
    
        // Obtener el idconsulta generado
        $idconsulta = $consulta->idconsulta;
    
        // Redirigir con un mensaje de éxito que incluye el idconsulta
        return redirect()->route('consultas.index')->with('message', "CONSULTA:#$idconsulta");
    }
    

    // Muestra el formulario para editar una consulta existente
    public function edit(Consulta $consulta)
    {
        return view('consultas.edit', compact('consulta'));
    }

    // Actualiza una consulta existente en la base de datos
    public function update(Request $request, Consulta $consulta)
    {
        $request->validate([
            'codigo_tecnico' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'nombre_tecnico' => 'required|string|max:255',
            'motivo_consulta' => 'required|string|max:255',
            'numero_orden' => 'required|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        $consulta->update($request->all());

        return redirect()->route('consultas.index')->with('success', 'Consulta actualizada con éxito.');
    }

    // Elimina una consulta existente de la base de datos
    public function destroy(Consulta $consulta)
    {
        $consulta->delete();
        return redirect()->route('consultas.index')->with('success', 'Consulta eliminada con éxito.');
    }

    public function getTecnico(Request $request, $codigo)
    {
        $tecnico = Tecnico::where('codigo', $codigo)->first();
        
        if ($tecnico) {
            $fechaHoy = Carbon::today()->toDateString();
            $consultasHoy = Consulta::where('codigo_tecnico', $codigo)
                ->whereDate('created_at', $fechaHoy)
                ->with('user') // Asegúrate de cargar la relación 'user'
                ->get();

            return response()->json([
                'numero' => $tecnico->numero,
                'nombre_tecnico' => $tecnico->nombre_tecnico,
                'status' => $tecnico->status, // Asegúrate de incluir el estado
                'consultas' => $consultasHoy
            ]);
        } else {
            return response()->json([
                'numero' => '',
                'nombre_tecnico' => '',
                'status' => 'Inactivo', // O el valor que sea adecuado para cuando no se encuentra el técnico
                'consultas' => []
            ]);
        }
    }

}