{{-- resources/views/auth/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Reportes')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">

@section('content_header')
<h1> Reportes</h1>
@stop

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="d-flex justify-content-between align-items-center"
            style="padding: 0.9rem; padding-bottom:0 !important; background: #343a40; color:white;">
            <div class="">
                <h5>Reportes <img src="vendor/img/reportes.png" style="width:35px;" alt=""></h5>
            </div>
            <div class="">

                <div class="" style="padding-bottom:10px;">
                    <a href="{{ route('home') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-body">
                <form action="{{ route('reports.getData') }}" method="POST" id="report-form">
                    @csrf
                    <div class="form-group-container form-row">
                        <div class="form-group col-md-3">
                            <label for="start_date">Fecha de Inicio</label>
                            <input type="date" name="start_date" class="form-control flatpickr "
                                placeholder="Seleccioné una fecha" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="end_date">Fecha de Fin</label>
                            <input type="date" name="end_date" class="form-control  flatpickr"
                                placeholder="Seleccioné una fecha" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="report_type">Tipo de Reporte</label>
                            <select name="report_type" id="report_type" class="form-control" required>
                                <option value="">Seleccionar</option>
                                <option value="instalaciones">Instalaciones</option>
                                <option value="reparacion">Reparación</option>
                                <option value="postventa">Postventas</option>
                                <option value="consulta">Consultas</option>
                                <option value="agendamiento">Agendamientos</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="user_id">Usuario</label>
                            <select name="user_id" id="user_id" class="form-control select2 js-example-theme-single">
                                <option value="">Todos</option> <!-- Esta opción debe estar fuera del foreach -->
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Generar Reporte</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection



@section('css')
<!-- Incluir CSS de DataTables -->
<link rel="stylesheet" href="{{ asset('assets/css/dataTables_bootstrap.min.css') }}">
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/stylesssd.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/flatpickr.min.css') }}">

@stop


@section('js')
<!-- Incluyendo los CSS y JS locales desde tu carpeta de assets -->
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>




<script>
// Inicializar Date Range Picker
$(".flatpickr").flatpickr({
    dateFormat: "Y-m-d", // Formato de fecha
    locale: "es", // Cambiar a español si lo necesitas
});
</script>

<script>
$(document).ready(function() {
    $('#report-form').on('submit', function(e) {
        e.preventDefault(); // Evitar recarga de página

        // Obtener los datos del formulario
        var formData = $(this).serialize();

        // Realizar la solicitud AJAX
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            success: function(response) {
                if (response.error) {
                    // Mostrar mensaje de error si no se encontraron datos
                    Swal.fire({
                        icon: 'error',
                        title: '¡Sin Datos!',
                        text: response.error,
                        timer: 3000,
                        showConfirmButton: false
                    });
                } else if (response.success) {
                    // Mostrar mensaje de éxito y redirigir a la vista de resultados
                    Swal.fire({
                        icon: 'success',
                        title: '¡Reporte Encontrado!',
                        text: 'Se han encontrado datos. Redirigiendo...',
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        // Limpiar el formulario
                        $('#report-form')[0].reset();
                        // Redirigir a la vista de resultados con los parámetros
                        window.location.href = response.success;
                    });
                }
            },
            error: function(xhr) {
                // Mostrar mensaje de error si ocurre un error en la solicitud
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al procesar la solicitud.',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    });
});
</script>



@stop