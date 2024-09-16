<?php
// app/Http/Controllers/ReportController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instalaciones;
use App\Models\Reparacion;
use App\Models\Postventa;
use App\Models\Consulta;
use App\Models\Agendamiento;
use App\Models\User;
use App\Models\Dpto;
use App\Models\Anulacion;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ReportController extends Controller
{
    public function index()
    {

        if (!auth()->check()) {
            // Redirigir al usuario al login si no está autenticado
            return redirect()->route('login');
        }
        $users = User::all(); // Obtener todos los usuarios
        return view('reports.index', compact('users'));
    }

    public function showResult(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $reportType = $request->query('report_type');

        $data = session('report_data.data', []);
        
        // Validar si los datos están disponibles en la sesión
        if (empty($data)) {
            abort(404, 'No se encontraron datos.');
        }

        return view('reports.result', [
            'data' => $data,
            'reportType' => $reportType,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }


    public function getReportData(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'report_type' => 'required|string',
        ]);
    
        // Procesar las fechas correctamente para incluir todo el día
        $startDate = Carbon::parse($request->start_date)->startOfDay(); // Inicio del día
        $endDate = Carbon::parse($request->end_date)->endOfDay(); // Final del día 23:59:59
    
        // Obtener los datos del reporte según el tipo
        $reportType = $request->report_type;
        $data = $this->getDataForReport($reportType, $startDate, $endDate);
    
        // Verificar si no hay datos
        if ($data->isEmpty()) {
            return response()->json(['error' => 'No se encontraron datos para el rango de fechas seleccionado.']);
        }
    
        // Guardar datos en la sesión
        session()->put('report_data', [
            'data' => $data,
            'reportType' => $reportType,
            'startDate' => $startDate->toDateString(), // Convertir a formato de fecha
            'endDate' => $endDate->toDateString(),     // Convertir a formato de fecha
        ]);
    
        // Redirigir a la vista de resultados con parámetros
        return response()->json([
            'success' => route('reports.result') . 
            '?start_date=' . urlencode($startDate->toDateString()) . 
            '&end_date=' . urlencode($endDate->toDateString()) . 
            '&report_type=' . urlencode($reportType)
        ]);
    }
    
    
    private function getDataForReport($reportType, $startDate, $endDate)
    {
        switch ($reportType) {
            case 'instalaciones':
                return Instalaciones::with(['user', 'anulacion'])  // Cargar la relación con User y Anulacion
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get()
                ->map(function ($instalacion) {
                    $instalacion->user_name = $instalacion->user->name ?? 'N/a';
                    $instalacion->motivo_anulacion = $instalacion->anulacion->MotivoAnulacion ?? 'N/a';
                    return $instalacion;
                });
            

            case 'reparacion':
                return Reparacion::with('user')  // Similar para Reparacion
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get()
                    ->map(function ($reparacion) {
                        $reparacion->user_name = $reparacion->user->name ?? 'N/a';
                        return $reparacion;
                    });

            case 'postventa':
                return Postventa::with('user', 'anulacion')  // Similar para Postventa
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get()
                    ->map(function ($postventa) {
                        $postventa->user_name = $postventa->user->name ?? 'N/a';
                        $postventa->motivo_anulacion = $postventa->anulacion->MotivoAnulacion ?? 'N/a';
                        return $postventa;
                    });

            case 'consulta':
                return Consulta::with('user')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get()
                    ->map(function ($consulta) {
                        $consulta->user_name = $consulta->user->name ?? 'N/a';
                        return $consulta;
                    });

            case 'agendamiento':
                return Agendamiento::with('user')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get()
                    ->map(function ($agendamiento) {
                        $agendamiento->user_name = $agendamiento->user->name ?? 'N/a';
                        return $agendamiento;
                    });

            default:
                return collect(); // Retorna una colección vacía si el tipo de reporte no es válido
        }
    }

    

}