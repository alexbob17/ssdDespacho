<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instalaciones;
use App\Models\Reparacion;
use App\Models\Anulacion;
use App\Models\Postventa;
use App\Models\Dpto;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB; // Importa la clase DB aquí


class BusquedaController extends Controller
{
    //

    public function index(Request $request)
    {

        if (!auth()->check()) {
            // Redirigir al usuario al login si no está autenticado
            return redirect()->route('login');
        }
        
        if ($request->ajax()) {
            // Obtener el término de búsqueda si está presente
            $searchValue = $request->search['value'] ?? '';
    
            // Consulta para instalaciones
            $instalaciones = Instalaciones::select([
                'id',
                'numConsecutivo as boleta',
                'created_at as fecha',
                'codigo as codTecnico',
                'nombre_tecnico',
                'tipoOrden',
                'tipoactividad',
                DB::raw('COALESCE(ordenTv, ordenInternet, ordenLinea) as orden'),
                'ordenTv', // Añadir la columna ordenTv
                'ordenInternet', // Añadir la columna ordenInternet
                'ordenLinea', // Añadir la columna ordenLinea
                'status',
                'user_id',
                DB::raw('"instalaciones" as tipo') // Identificar que son instalaciones
            ])
            ->when($searchValue, function ($query, $searchValue) {
                return $query->where(function ($q) use ($searchValue) {
                    $q->where('numConsecutivo', 'LIKE', "%{$searchValue}%")
                      ->orWhere('codigo', 'LIKE', "%{$searchValue}%")
                      ->orWhere('nombre_tecnico', 'LIKE', "%{$searchValue}%")
                      ->orWhere('tipoOrden', 'LIKE', "%{$searchValue}%")
                      ->orWhere('tipoactividad', 'LIKE', "%{$searchValue}%")
                      ->orWhere('status', 'LIKE', "%{$searchValue}%")
                      ->orWhere('ordenTv', 'LIKE', "%{$searchValue}%")
                      ->orWhere('ordenInternet', 'LIKE', "%{$searchValue}%")
                      ->orWhere('ordenLinea', 'LIKE', "%{$searchValue}%");
                });
            });
    
            // Consulta para reparaciones
            $reparaciones = Reparacion::select([
                'id',
                'numConsecutivo as boleta',
                'created_at as fecha',
                'codigo as codTecnico',
                'nombre_tecnico',
                'tipoOrden',
                'tipoactividad',
                'orden', // Aquí 'orden' viene de la tabla de reparaciones
                DB::raw('NULL as ordenTv'), // Reparaciones no tiene ordenTv
                DB::raw('NULL as ordenInternet'), // Reparaciones no tiene ordenInternet
                DB::raw('NULL as ordenLinea'), // Reparaciones no tiene ordenLinea
                'status',
                'user_id',
                DB::raw('"reparaciones" as tipo') // Identificar que son reparaciones
            ])
            ->when($searchValue, function ($query, $searchValue) {
                return $query->where(function ($q) use ($searchValue) {
                    $q->where('numConsecutivo', 'LIKE', "%{$searchValue}%")
                      ->orWhere('codigo', 'LIKE', "%{$searchValue}%")
                      ->orWhere('nombre_tecnico', 'LIKE', "%{$searchValue}%")
                      ->orWhere('tipoOrden', 'LIKE', "%{$searchValue}%")
                      ->orWhere('tipoactividad', 'LIKE', "%{$searchValue}%")
                      ->orWhere('status', 'LIKE', "%{$searchValue}%")
                      ->orWhere('orden', 'LIKE', "%{$searchValue}%");
                });
            });
    
            // Consulta para postventas
            $postventas = Postventa::select([
                'id',
                'numConsecutivo as boleta',
                'created_at as fecha',
                'codigo as codTecnico',
                'nombre_tecnico',
                'tipoOrden',
                'tipoactividad',
                'orden', // Aquí 'orden' viene de la tabla de postventas
                DB::raw('NULL as ordenTv'), // Postventas no tiene ordenTv
                DB::raw('NULL as ordenInternet'), // Postventas no tiene ordenInternet
                DB::raw('NULL as ordenLinea'), // Postventas no tiene ordenLinea
                'status',
                'user_id',
                DB::raw('"postventas" as tipo') // Identificar que son postventas
            ])
            ->when($searchValue, function ($query, $searchValue) {
                return $query->where(function ($q) use ($searchValue) {
                    $q->where('numConsecutivo', 'LIKE', "%{$searchValue}%")
                      ->orWhere('codigo', 'LIKE', "%{$searchValue}%")
                      ->orWhere('nombre_tecnico', 'LIKE', "%{$searchValue}%")
                      ->orWhere('tipoOrden', 'LIKE', "%{$searchValue}%")
                      ->orWhere('tipoactividad', 'LIKE', "%{$searchValue}%")
                      ->orWhere('status', 'LIKE', "%{$searchValue}%")
                      ->orWhere('orden', 'LIKE', "%{$searchValue}%");
                });
            });
    
            // Combinar los datos utilizando union
            $query = $instalaciones
                ->union($reparaciones)
                ->union($postventas)
                ->orderBy('fecha', 'desc');
    
            // Obtener los resultados
            $result = $query->get();
    
            // Usar DataTables para devolver la respuesta en formato JSON
            return DataTables::of($result)
                ->addColumn('usuario', function ($row) {
                    return $row->user ? $row->user->name : 'N/A'; // Obtener el nombre del usuario si existe
                })
                ->make(true);
        }
    
        return view('busqueda.index');
    }
    

    



    public function edit($type, $id)
    {

        $dptos = Dpto::all();
        $anulacion = Anulacion::all();


        // Cargar el registro según el tipo
        switch ($type) {
            case 'instalaciones':
                $record = Instalaciones::findOrFail($id);
                $view = 'edit.instalaciones'; // Vista específica para instalaciones
                break;
            case 'reparaciones':
                $record = Reparacion::findOrFail($id);
                $view = 'edit.reparaciones'; // Vista específica para reparaciones
                break;
            case 'postventas':
                $record = Postventa::findOrFail($id);
                $view = 'edit.postventa'; // Vista específica para postventas
                break;
            default:
                abort(404); // Tipo de registro no válido
        }

    //dd($view, $record);

    //$record->motivoAnulada = Anulacion::where('MotivoAnulacion', $record->motivoAnulada)->value('id');

        return view($view, compact('record', 'type', 'dptos','anulacion'));
    }
    

}