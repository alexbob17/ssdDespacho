<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instalaciones;
use App\Models\Reparacion;
use App\Models\Postventa;
use App\Models\Consulta;
use App\Models\Agendamiento;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // En el controlador
    public function index()
    {
        $hoy = Carbon::today();
        $mesInicio = Carbon::now()->startOfMonth();

        $registrosMensuales = $this->getRegistrosMensuales();
        $nombresMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        list($labels, $data) = $this->prepareChartData($registrosMensuales, $nombresMeses);

        $agendamientosMes = $this->getCountByModel(Agendamiento::class, $mesInicio, Carbon::now());
        $agendamientosDia = $this->getCountByModel(Agendamiento::class, $hoy, $hoy);

        $consultasMes = $this->getCountByModel(Consulta::class, $mesInicio, Carbon::now());
        $consultasDia = $this->getCountByModel(Consulta::class, $hoy, $hoy);

        $reparacionesMes = $this->getCountByModel(Reparacion::class, $mesInicio, Carbon::now());
        $reparacionesDia = $this->getCountByModel(Reparacion::class, $hoy, $hoy);

        $instalacionesMes = $this->getCountByModel(Instalaciones::class, $mesInicio, Carbon::now());
        $instalacionesDia = $this->getCountByModel(Instalaciones::class, $hoy, $hoy);

        $postventaMes = $this->getCountByModel(Postventa::class, $mesInicio, Carbon::now());

        $topUsuarios = $this->getTopUsuarios($mesInicio);

        $topMotivos = $this->getTopMotivosConsulta($hoy);
        $hayDatosMotivos = !$topMotivos->isEmpty();

        $topTipoOrden = $this->getTopTipoOrden(Instalaciones::class, $hoy);
        $topTipoOrdenPost = $this->getTopTipoOrden(Postventa::class, $hoy);
        $topTipoOrdenReparacion = $this->getTopTipoOrden(Reparacion::class, $hoy);

        $topMotivoConsulta = $this->getTopMotivoConsulta($hoy);
        $topTipoOrdenInstalacion = $this->getTopTipoOrden(Instalaciones::class, $hoy);
        $topTipoOrdenPostventa = $this->getTopTipoOrden(Postventa::class, $hoy);
        $topTipoOrdenRepar = $this->getTopTipoOrden(Reparacion::class, $hoy);

        $usuarios = $topUsuarios->pluck('name')->toArray();
        $conteoTotal = $topUsuarios->pluck('total')->toArray();

        return view('home', [
            'agendamientosMes' => $agendamientosMes,
            'agendamientosDia' => $agendamientosDia,
            'consultasMes' => $consultasMes,
            'consultasDia' => $consultasDia,
            'reparacionesMes' => $reparacionesMes,
            'reparacionesDia' => $reparacionesDia,
            'instalacionesMes' => $instalacionesMes,
            'instalacionesDia' => $instalacionesDia,
            'postventaMes' => $postventaMes,
            'topUsuarios' => $topUsuarios,
            'usuarios' => $usuarios,
            'conteoTotal' => $conteoTotal,
            'topMotivos' => $topMotivos,
            'hayDatosMotivos' => $hayDatosMotivos,
            'topTipoOrden' => $topTipoOrden,
            'topTipoOrdenPost' => $topTipoOrdenPost,
            'topTipoOrdenReparacion' => $topTipoOrdenReparacion,
            'topMotivoConsulta' => $topMotivoConsulta,
            'topTipoOrdenInstalacion' => $topTipoOrdenInstalacion,
            'topTipoOrdenPostventa' => $topTipoOrdenPostventa,
            'topTipoOrdenRepar' => $topTipoOrdenRepar,
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    private function getRegistrosMensuales()
    {
        return DB::select("
            (select YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total from `consultas` group by `year`, `month`)
            union
            (select YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total from `agendamientos` group by `year`, `month`)
            union
            (select YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total from `reparaciones` group by `year`, `month`)
            union
            (select YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total from `instalaciones_realizadas` group by `year`, `month`)
            union
            (select YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total from `postventas` group by `year`, `month`)
        ");
    }

    private function prepareChartData($registrosMensuales, $nombresMeses)
    {
        $labels = [];
        $data = [];

        foreach ($registrosMensuales as $registro) {
            $labels[] = $nombresMeses[$registro->month - 1];
            $data[] = $registro->total;
        }

        return [$labels, $data];
    }

    private function getCountByModel($model, $startDate, $endDate)
    {
        return $model::whereBetween('created_at', [$startDate, $endDate])->count();
    }

    private function getTopUsuarios($mesInicio)
    {
        return User::withCount([
            'consultas' => function ($query) use ($mesInicio) {
                $query->whereBetween('created_at', [$mesInicio, Carbon::now()]);
            },
            'agendamientos' => function ($query) use ($mesInicio) {
                $query->whereBetween('created_at', [$mesInicio, Carbon::now()]);
            },
            'instalaciones' => function ($query) use ($mesInicio) {
                $query->whereBetween('created_at', [$mesInicio, Carbon::now()]);
            },
            'reparaciones' => function ($query) use ($mesInicio) {
                $query->whereBetween('created_at', [$mesInicio, Carbon::now()]);
            },
            'postventa' => function ($query) use ($mesInicio) {
                $query->whereBetween('created_at', [$mesInicio, Carbon::now()]);
            }
        ])
        ->get()
        ->map(function ($user) {
            $user->total = $user->consultas_count
                        + $user->agendamientos_count
                        + $user->instalaciones_count
                        + $user->reparaciones_count
                        + ($user->postventa_count ?? 0);
            return $user;
        })
        ->sortByDesc('total')
        ->take(10);
    }

    private function getTopMotivosConsulta($hoy)
    {
        return Consulta::select('motivo_consulta', DB::raw('count(*) as total'))
            ->whereDate('created_at', $hoy)
            ->groupBy('motivo_consulta')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();
    }

    private function getTopTipoOrden($model, $hoy)
    {
        return $model::select('tipoOrden', DB::raw('count(*) as total'))
            ->whereDate('created_at', $hoy)
            ->groupBy('tipoOrden')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();
    }

    private function getTopMotivoConsulta($hoy)
    {
        return Consulta::select('motivo_consulta', DB::raw('count(*) as total'))
            ->whereDate('created_at', $hoy)
            ->groupBy('motivo_consulta')
            ->orderBy('total', 'desc')
            ->first() ?? null;
    }




    


    
    
    

}