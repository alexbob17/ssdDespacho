<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instalaciones;
use App\Models\Reparacion;
use App\Models\Postventa;
use App\Models\Consulta;
use App\Models\Agendamiento;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Fechas actuales para el día y el mes
        $hoy = Carbon::today();
        $mesInicio = Carbon::now()->startOfMonth();

        $agendamientosMes = Agendamiento::whereBetween('created_at', [$mesInicio, Carbon::now()])->count();
        $agendamientosDia = Agendamiento::whereDate('created_at', $hoy)->count();

        // 2. Consultas
        $consultasMes = Consulta::whereBetween('created_at', [$mesInicio, Carbon::now()])->count();
        $consultasDia = Consulta::whereDate('created_at', $hoy)->count();

        // 3. Reparaciones
        $reparacionesMes = Reparacion::whereBetween('created_at', [$mesInicio, Carbon::now()])->count();
        $reparacionesDia = Reparacion::whereDate('created_at', $hoy)->count();

        // 4. Instalaciones
        $instalacionesMes = Instalaciones::whereBetween('created_at', [$mesInicio, Carbon::now()])->count();
        $instalacionesDia = Instalaciones::whereDate('created_at', $hoy)->count();

        // Pasar los datos a la vista del dashboard
        return view('dashboard.index', [
            'agendamientosMes' => $agendamientosMes,
            'agendamientosDia' => $agendamientosDia,
            'consultasMes' => $consultasMes,
            'consultasDia' => $consultasDia,
            'reparacionesMes' => $reparacionesMes,
            'reparacionesDia' => $reparacionesDia,
            'instalacionesMes' => $instalacionesMes,
            'instalacionesDia' => $instalacionesDia,
        ]);
    }
}