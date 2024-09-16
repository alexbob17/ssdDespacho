@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">

@section('content_header')
<h1>Dashboard Principal</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <h3 style="margin-bottom:1rem;">Bienvenido, {{ Auth::user()->name }}!</h3> <!-- Mensaje de bienvenida -->

        @if (auth()->check() && !auth()->user()->hasAnyRole(['supervisor n1' ,'supervisor n2','admin']))
        <div class="row" style="margin-top:1.6rem;">
            <!-- Tarjeta de tecnicos activos -->
            <div class="col-md-6 col-xl-3">
                <div class="card card-custom shadow-lg">
                    <div class="card-body">
                        <h6 class="text-uppercase">Agendamientos</h6>
                        <div class="d-flex justify-content-between align-items-center" id="agendamiento">
                            <i class="fas fa-calendar-check fa-3x"></i>
                            <h2 class="display-4">Mes: {{ $agendamientosMes }}</h2>
                        </div>
                        <p class="">Total del día: {{ $agendamientosDia }}</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de usuarios activos -->
            <div class="col-md-6 col-xl-3">
                <div class="card card-custom bg-secondary text-white shadow-lg">
                    <div class="card-body">
                        <h6 class="text-uppercase">Consultas</h6>
                        <div class="d-flex justify-content-between align-items-center" id="consultas">
                            <i class="fas fa-headset fa-3x"></i>
                            <h2 class="display-4">Mes: {{ $consultasMes }}</h2>
                        </div>
                        <p class="">Total del dia: {{ $consultasDia }}</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de reparaciones -->
            <div class="col-md-4 col-xl-3">
                <div class="card card-custom shadow-lg">
                    <div class="card-body">
                        <h6 class="text-uppercase">Reparaciones</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <i class="fas fa-toolbox fa-3x"></i>
                            <h2 class="display-4">Mes: {{ $reparacionesMes }}</h2>
                        </div>
                        <p class="">Total del dia: {{ $reparacionesDia  }}</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de instalaciones -->
            <div class="col-md-4 col-xl-3">
                <div class="card card-custom bg-danger text-white shadow-lg">
                    <div class="card-body">
                        <h6 class="text-uppercase">Instalaciones</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <i class="fas fa-hammer fa-3x"></i>
                            <h2 class="display-4">Mes: {{ $instalacionesMes}}</h2>
                        </div>
                        <p class="">Total del dia: {{ $instalacionesDia  }}</p>
                    </div>
                </div>
            </div>


        </div>

        <div class="form-row" style="display:flex;justify-content:center;">
            <img src="{{ asset('img/logodespachossd.png') }}" alt="" class="image-container">
        </div>

        @endif
        @if (auth()->check() && !auth()->user()->hasAnyRole(['operador n2' ,'operador n1']))
        <div class="row">
            <!-- Tarjeta de agendamientos -->
            <div class="col-md-4 col-xl-3">
                <div class="card card-custom shadow-lg">
                    <div class="card-body">
                        <h6 class="text-uppercase">Agendamientos</h6>
                        <div class="d-flex justify-content-between align-items-center" id="agendamiento">
                            <i class="fas fa-calendar-check fa-3x"></i>
                            <h2 class="display-4">Mes: {{ $agendamientosMes }}</h2>
                        </div>
                        <p class="">Total del día: {{ $agendamientosDia }}</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de consultas -->
            <div class="col-md-4 col-xl-3">
                <div class="card card-custom bg-secondary text-white shadow-lg">
                    <div class="card-body">
                        <h6 class="text-uppercase">Consultas</h6>
                        <div class="d-flex justify-content-between align-items-center" id="consultas">
                            <i class="fas fa-headset fa-3x"></i>
                            <h2 class="display-4">Mes: {{ $consultasMes }}</h2>
                        </div>
                        <p class="">Total del dia: {{ $consultasDia }}</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de reparaciones -->
            <div class="col-md-4 col-xl-3">
                <div class="card card-custom shadow-lg">
                    <div class="card-body">
                        <h6 class="text-uppercase">Reparaciones</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <i class="fas fa-toolbox fa-3x"></i>
                            <h2 class="display-4">Mes: {{ $reparacionesMes }}</h2>
                        </div>
                        <p class="">Total del dia: {{ $reparacionesDia  }}</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de instalaciones -->
            <div class="col-md-4 col-xl-3">
                <div class="card card-custom bg-danger text-white shadow-lg">
                    <div class="card-body">
                        <h6 class="text-uppercase">Instalaciones</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <i class="fas fa-hammer fa-3x"></i>
                            <h2 class="display-4">Mes: {{ $instalacionesMes}}</h2>
                        </div>
                        <p class="">Total del dia: {{ $instalacionesDia  }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row mt-4">
            <div class="col-md-6" style="">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Totla de registros Mensual</h5>
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card chart-card-custom shadow-lg">
                    <div class="card-body">
                        <h5 class=" text-center">Top 10 Agentes con mas llamadas registradas en el mes</h5>
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class=" text-center">Top Instalaciones del Día</h5>
                        <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tipo de Orden</th>
                                    <th>Registros</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($topTipoOrden->isEmpty())
                                <tr>
                                    <td colspan="2" class="text-center">Aún no hay registros en el día</td>
                                </tr>
                                @else
                                @foreach($topTipoOrden as $tipo)
                                <tr>
                                    <td><i class="fas fa-wrench"></i> {{ $tipo->tipoOrden }}</td>
                                    <td><span class="badge bg-success p-2">{{ $tipo->total }}</span></td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class=" text-center">Top Postventas del Día</h5>
                        <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tipo de Orden</th>
                                    <th>Registros</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($topTipoOrdenPost->isEmpty())
                                <tr>
                                    <td colspan="2" class="text-center">Aún no hay registros en el día</td>
                                </tr>
                                @else
                                @foreach($topTipoOrdenPost as $tipo)
                                <tr>
                                    <td><i class="fas fa-wrench"></i> {{ $tipo->tipoOrden }}</td>
                                    <td><span class="badge bg-info p-2">{{ $tipo->total }}</span></td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="text-center">Top Reparaciones del Día</h5>
                        <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tipo de Orden</th>
                                    <th>Registros</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($topTipoOrdenReparacion->isEmpty())
                                <tr>
                                    <td colspan="2" class="text-center">Aún no hay registros en el día</td>
                                </tr>
                                @else
                                @foreach($topTipoOrdenReparacion as $tipo)
                                <tr>
                                    <td><i class="fas fa-wrench"></i> {{ $tipo->tipoOrden }}</td>
                                    <td><span class="badge bg-warning p-2">{{ $tipo->total }}</span></td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="form-row">
            <div class="col-md-6">
                <div class="card chart-card-custom shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title">Top Consultas del dia</h5>
                        <canvas id="pieChart" style=""></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="text-center">📊 ¿Dónde está el Tráfico?</h5>
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th>🔍 Tipo</th>
                                    <th>🛠️ Tipo Orden / Motivo Consulta</th>
                                    <th>📊 Registros</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(is_null($topTipoOrdenInstalacion) && is_null($topTipoOrdenPostventa) &&
                                is_null($topTipoOrdenRepar) && is_null($topMotivoConsulta))
                                <tr>
                                    <td colspan="3" class="text-center">🚫 Aún no hay registros en el día</td>
                                </tr>
                                @else
                                @if($topTipoOrdenInstalacion)
                                <tr>
                                    <td><i class="fas fa-tools"></i> Instalaciones</td>
                                    <td>🔧 {{ $topTipoOrdenInstalacion->tipoOrden }}</td>
                                    <td><span class="badge bg-success p-3">{{ $topTipoOrdenInstalacion->total }}
                                        </span></td>
                                </tr>
                                @endif

                                @if($topTipoOrdenPostventa)
                                <tr>
                                    <td><i class="fas fa-tools"></i> Postventa</td>
                                    <td>🔧 {{ $topTipoOrdenPostventa->tipoOrden }}</td>
                                    <td><span class="badge bg-success p-3">{{ $topTipoOrdenPostventa->total }} </span>
                                    </td>
                                </tr>
                                @endif

                                @if($topTipoOrdenRepar)
                                <tr>
                                    <td><i class="fas fa-tools"></i> Reparaciones</td>
                                    <td>🔧 {{ $topTipoOrdenRepar->tipoOrden }}</td>
                                    <td><span class="badge bg-success p-3">{{ $topTipoOrdenRepar->total }}
                                        </span></td>
                                </tr>
                                @endif

                                @if($topMotivoConsulta)
                                <tr>
                                    <td><i class="fas fa-question-circle"></i> Consultas</td>
                                    <td>💬 {{ $topMotivoConsulta->motivo_consulta }}</td>
                                    <td><span class="badge bg-success p-3">{{ $topMotivoConsulta->total }} </span>
                                    </td>
                                </tr>
                                @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>

@endif
@endsection


@section('css');

<style>
.bgmove {
    margin: auto;
    font-family: -apple-system, BlinkMacSystemFont, sans-serif;
    overflow: auto;
    background: linear-gradient(315deg, rgba(101, 0, 94, 1) 3%, rgba(60, 132, 206, 1) 38%, rgba(48, 238, 226, 1) 68%, rgba(255, 25, 25, 1) 98%);
    animation: gradient 15s ease infinite;
    background-size: 400% 400%;
    background-attachment: fixed;
}

@keyframes gradient {
    0% {
        background-position: 0% 0%;
    }

    50% {
        background-position: 100% 100%;
    }

    100% {
        background-position: 0% 0%;
    }
}

.wave {
    background: rgb(255 255 255 / 25%);
    border-radius: 1000% 1000% 0 0;
    position: fixed;
    width: 200%;
    height: 12em;
    animation: wave 10s -3s linear infinite;
    transform: translate3d(0, 0, 0);
    opacity: 0.8;
    bottom: 0;
    left: 0;
    z-index: -1;
}

.wave:nth-of-type(2) {
    bottom: -1.25em;
    animation: wave 18s linear reverse infinite;
    opacity: 0.8;
}

.wave:nth-of-type(3) {
    bottom: -2.5em;
    animation: wave 20s -1s reverse infinite;
    opacity: 0.9;
}

@keyframes wave {
    2% {
        transform: translateX(1);
    }

    25% {
        transform: translateX(-25%);
    }

    50% {
        transform: translateX(-50%);
    }

    75% {
        transform: translateX(-25%);
    }

    100% {
        transform: translateX(1);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-60px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.image-container {
    animation: fadeIn 2s ease-out;
}


.ag-courses_item {
    margin: auto;
    overflow: hidden;
    border-radius: 28px;
}

.ag-courses-item_link {
    display: block;
    padding: 30px 20px;
    background-color: #121212;
    overflow: hidden;
    position: relative;
    text-decoration: none;
}

.ag-courses-item_link:hover,
.ag-courses-item_link:hover .ag-courses-item_date {
    color: #121212;
}

.ag-courses-item_link:hover .ag-courses-item_bg {
    -webkit-transform: scale(10);
    -ms-transform: scale(10);
    transform: scale(10);
}

.ag-courses-item_title {
    min-height: 57px;
    margin: 0 0 30px;
    overflow: hidden;
    font-weight: bold;
    font-size: 20px;
    color: rgb(255, 255, 255);
    z-index: 2;
    position: relative;
}

.ag-courses-item_date-box {
    font-size: 18px;
    color: #fff;
    z-index: 2;
    position: relative;
}

.ag-courses-item_date {
    font-weight: bold;
    color: #f9e534;
    -webkit-transition: color 0.5s ease;
    -o-transition: color 0.5s ease;
    transition: color 0.5s ease;
}

.ag-courses-item_bg {
    height: 130px;
    width: 100px;
    background-color: #f9b234;
    z-index: 1;
    position: absolute;
    top: -75px;
    right: -75px;
    border-radius: 50%;
    -webkit-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

.card-custom {
    border-radius: 15px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background-color: #1f2833;
    /* Color oscuro para la tarjeta */
    color: white;
}

.card-custom:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}



.card-custom h6 {
    font-size: 14px;
    font-weight: bold;
    letter-spacing: 1px;
    margin-bottom: 1rem;
}

.card-custom .display-4 {
    font-size: 2.5rem;
    font-weight: bold;
    margin: 0;
}

.card-custom .small {
    font-size: 12px;
}

/* Transitions for hover effects */
.card-body i {
    color: white;
    /* Color del icono */
}

.card-custom.bg-danger:hover {
    background-color: #ff4e4e;
}

.card-custom.bg-secondary:hover {
    background-color: #6c757d;
}

/* Icon size and positioning */
.card-body i {
    transition: color 0.3s ease;
}
</style>
@stop


@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Datos pasados desde Blade
const usuarios = @json($usuarios);
const conteoTotal = @json($conteoTotal);

// Obtener el contexto del gráfico
const ctxBar = document.getElementById('barChart').getContext('2d');

// Verificar si hay datos
if (usuarios.length === 0 || conteoTotal.length === 0) {
    // Si no hay datos, mostrar un mensaje
    const noDataMessage = 'No hay registros disponibles para mostrar.';
    ctxBar.clearRect(0, 0, ctxBar.canvas.width, ctxBar.canvas.height); // Limpiar el canvas
    ctxBar.font = '16px Arial';
    ctxBar.textAlign = 'center';
    ctxBar.textBaseline = 'middle';
    ctxBar.fillStyle = 'rgba(75, 192, 192, 1)';
    ctxBar.fillText(noDataMessage, ctxBar.canvas.width / 2, ctxBar.canvas.height / 2);
} else {
    // Si hay datos, crear el gráfico de barras
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: usuarios,
            datasets: [{
                label: 'Total de Registros',
                data: conteoTotal,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
</script>



<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctxPie = document.getElementById('pieChart').getContext('2d');

    // Datos desde el backend
    var topMotivos = @json($topMotivos);
    var hayDatosMotivos = @json($hayDatosMotivos);

    // Si hay datos, los usamos para el gráfico
    if (hayDatosMotivos) {
        var labels = topMotivos.map(function(item) {
            return item.motivo_consulta;
        });
        var data = topMotivos.map(function(item) {
            return item.total;
        });
    } else {
        // Si no hay datos, mostrar un gráfico con un solo sector "Sin datos"
        var labels = ['Sin datos aún'];
        var data = [100]; // Esto solo sirve para que el gráfico no esté vacío
    }

    var pieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: hayDatosMotivos ? ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                    '#E7E9ED'
                ] : ['#CCCCCC'],
                hoverBackgroundColor: hayDatosMotivos ? ['#FF6384', '#36A2EB', '#FFCE56',
                    '#4BC0C0', '#E7E9ED'
                ] : ['#AAAAAA']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top', // Posiciona la leyenda al costado
                    labels: {
                        boxWidth: 10, // Ajusta el tamaño del cuadro de color de la leyenda
                        padding: 15, // Ajusta el espacio entre la leyenda y el gráfico
                    }
                }
            },
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    top: 10,
                    bottom: 10
                }
            }
        }
    });
});


document.addEventListener('DOMContentLoaded', function() {
    var ctxLine = document.getElementById('lineChart').getContext('2d');

    // Datos desde el backend
    var labels = @json($labels); // Etiquetas con mes y año
    var data = @json($data); // Total de registros por mes

    // Verificar si hay datos
    if (labels.length === 0 || data.length === 0) {
        // Si no hay datos, mostrar un mensaje
        var noDataMessage = 'No hay registros disponibles para mostrar.';
        ctxLine.clearRect(0, 0, ctxLine.canvas.width, ctxLine.canvas.height); // Limpiar el canvas
        ctxLine.font = '16px Arial';
        ctxLine.textAlign = 'center';
        ctxLine.textBaseline = 'middle';
        ctxLine.fillStyle = 'rgba(75, 192, 192, 1)';
        ctxLine.fillText(noDataMessage, ctxLine.canvas.width / 2, ctxLine.canvas.height / 2);
    } else {
        // Si hay datos, crear el gráfico de líneas
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: labels, // Mostrar los nombres de los meses y años
                datasets: [{
                    label: 'Total de Registros por Mes',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Meses'
                        },
                        ticks: {
                            autoSkip: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total de Registros'
                        }
                    }
                }
            }
        });
    }
});
</script>



@stop