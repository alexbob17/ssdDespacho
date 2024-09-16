<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="card">
        <h1 class="mb-4">Reporte de {{ ucfirst($reportType) }}</h1>
        @if ($data->isEmpty())
        <p>No hay datos disponibles para el rango de fechas seleccionado.</p>
        @else

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        @if ($reportType === 'instalaciones')
                        <th>Fecha</th>
                        <th>Consecutivo</th>
                        <th>Código Técnico</th>
                        <th>Número</th>
                        <th>Nombre Técnico</th>
                        <th>Actividad</th>
                        <th>Tipo Orden</th>
                        <th>Orden Tv</th>
                        <th>Orden Internet</th>
                        <th>Orden Linea</th>
                        <th>Observaciones</th>
                        <th>Motivo Objetada</th>
                        <th>Motivo Anulada</th>
                        <th>Status</th>
                        <th>Usuario</th>

                        @elseif ($reportType === 'reparacion')
                        <th>Fecha</th>
                        <th>Boleta</th>
                        <th>Código Técnico</th>
                        <th>Número</th>
                        <th>Nombre Técnico</th>
                        <th>Actividad</th>
                        <th>Tipo Orden</th>
                        <th>Orden</th>
                        <th>Codigo Causa</th>
                        <th>Tipo Causa</th>
                        <th>Tipo Daño</th>
                        <th>Ubicacion Causa</th>
                        <th>Comentarios</th>
                        <th>Motivo Objetada</th>
                        <th>Motivo Transferida</th>
                        <th>Status</th>
                        <th>Usuario</th>
                        @elseif ($reportType === 'postventa')
                        <th>Fecha</th>
                        <th>Consecutivo</th>
                        <th>Código Técnico</th>
                        <th>Número</th>
                        <th>Nombre Técnico</th>
                        <th>Actividad</th>
                        <th>Tipo Orden</th>
                        <th>Orden</th>
                        <th>Observaciones</th>
                        <th>Motivo Objetada</th>
                        <th>Motivo Anulada</th>
                        <th>Motivo Transferida</th>
                        <th>Status</th>
                        <th>Usuario</th>
                        @elseif ($reportType === 'consulta')
                        <th>Fecha</th>
                        <th>Consecutivo</th>
                        <th>Código Técnico</th>
                        <th>Número</th>
                        <th>Nombre Técnico</th>
                        <th>Motivo Consulta</th>
                        <th>Orden</th>
                        <th>Observaciones</th>
                        <th>Usuario</th>
                        @elseif ($reportType === 'agendamiento')
                        <th>Fecha</th>
                        <th>Consecutivo</th>
                        <th>Código Técnico</th>
                        <th>Número</th>
                        <th>Nombre Técnico</th>
                        <th>Tipo Agendamiento</th>
                        <th>Fecha agendamiento</th>
                        <th>Hora Agendamiento</th>
                        <th>Orden</th>
                        <th>Observaciones</th>
                        <th>Usuario</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        @if ($reportType === 'instalaciones')
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->numConsecutivo }}</td>
                        <td>{{ $item->codigo }}</td>
                        <td>{{ $item->numero}}</td>
                        <td>{{ $item->nombre_tecnico }}</td>
                        <td>{{ $item->tipoactividad }}</td>
                        <td>{{ $item->tipoOrden}}</td>
                        <td>{{ $item->ordenTv }}</td>
                        <td>{{ $item->ordenInternet }}</td>
                        <td>{{ $item->ordenLinea }}</td>
                        <td>{{ $item->observaciones }}</td>
                        <td>{{ $item->motivoObjetada }}</td>
                        <td>{{ $item->motivo_anulacion }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->user_name }}</td>


                        @elseif ($reportType === 'reparacion')
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->numConsecutivo }}</td>
                        <td>{{ $item->codigo }}</td>
                        <td>{{ $item->numero}}</td>
                        <td>{{ $item->nombre_tecnico }}</td>
                        <td>{{ $item->tipoactividad }}</td>
                        <td>{{ $item->tipoOrden }}</td>
                        <td>{{ $item->orden }}</td>
                        <td>{{ $item->codigocausa }}</td>
                        <td>{{ $item->tipocausa }}</td>
                        <td>{{ $item->tipodaño }}</td>
                        <td>{{ $item->ubicaciondaño }}</td>
                        <td>{{ $item->comentarios }}</td>
                        <td>{{ $item->motivoObjetada }}</td>
                        <td>{{ $item->ObservacionesTransferida }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->user_name }}</td>

                        @elseif ($reportType === 'postventa')
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->numConsecutivo }}</td>
                        <td>{{ $item->codigo }}</td>
                        <td>{{ $item->numero}}</td>
                        <td>{{ $item->nombre_tecnico }}</td>
                        <td>{{ $item->tipoactividad }}</td>
                        <td>{{ $item->tipoOrden}}</td>
                        <td>{{ $item->orden }}</td>
                        <td>{{ $item->observaciones }}</td>
                        <td>{{ $item->motivoObjetada }}</td>
                        <td>{{ $item->motivo_anulacion }}</td>
                        <td>{{ $item->motivoTransferido }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->user_name }}</td>

                        @elseif ($reportType === 'consulta')
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->idconsulta }}</td>
                        <td>{{ $item->codigo_tecnico }}</td>
                        <td>{{ $item->numero }}</td>
                        <td>{{ $item->nombre_tecnico }}</td>
                        <td>{{ $item->motivo_consulta }}</td>
                        <td>{{ $item->numero_orden }}</td>
                        <td>{{ $item->observaciones }}</td>
                        <td>{{ $item->user_name }}</td>
                        @elseif ($reportType === 'agendamiento')
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->numeroid }}</td>
                        <td>{{ $item->codigo }}</td>
                        <td>{{ $item->numero }}</td>
                        <td>{{ $item->nombre_tecnico }}</td>
                        <td>{{ $item->tipo_agendamiento }}</td>
                        <td>{{ $item->fecha_agendamiento }}</td>
                        <td>{{ $item->hora_agendamiento }}</td>
                        <td>{{ $item->numero_orden }}</td>
                        <td>{{ $item->observaciones }}</td>
                        <td>{{ $item->user_name }}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <!-- Botón de descarga de Excel -->
        @endif
    </div>
</body>

</html>