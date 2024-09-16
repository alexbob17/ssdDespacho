{{-- resources/views/auth/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Agendamientos')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">

@section('content_header')
<h1>Agendamientos</h1>
@stop

@push('css')
<style>
input[type=number] {
    -moz-appearance: textfield;
    /* Firefox */
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    /* Chrome, Safari, Edge */
    margin: 0;
}
</style>
@endpush

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="d-flex justify-content-between align-items-center"
            style="padding: 0.9rem; padding-bottom:0 !important; background: #343a40; color:white;">
            <div class="">
                <h5>Registrar agendamiento <img src="vendor/img/calendar.png" style="width:35px;" alt=""></h5>

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
            <form action="{{ route('agendamientos.store') }}" method="POST" id="agendamiento-form">
                @csrf

                <!-- Campo para Código -->
                <div class="form-row align-items-center">
                    <div class="form-group col-md-3">
                        <label for="codigo">Código Técnico</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="codigo" id="codigo" class="form-control form-control-uppercase"
                                placeholder="Código Técnico" value="" required>
                        </div>
                        @error('codigo')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row" style="padding-top: 2rem;">
                        <div class="form-group col-md-12">
                            <button type="button" class="btn btn-primary" id="buscarTecnico">
                                <i class="fas fa-search"></i>
                            </button>
                            <button type="button" class="btn btn-dark" id="resetButton">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="numero">Número</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                            </div>
                            <input type="text" name="numero" id="numero" class="form-control form-control-uppercase"
                                placeholder="Número" value="" required readonly>
                        </div>
                        @error('numero')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="nombre_tecnico">Nombre Técnico</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                            </div>
                            <input type="text" name="nombre_tecnico" id="nombre_tecnico"
                                class="form-control form-control-uppercase" placeholder="Nombre Técnico" value=""
                                required readonly>
                        </div>
                        @error('nombre_tecnico')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Campo para Tipo de Agendamiento -->
                <div class="form-row align-items-center">
                    <div class="form-group col-md-3">
                        <label for="tipo_agendamiento">Tipo de Agendamiento:</label>
                        <select class="form-control" id="tipo_agendamiento" name="tipo_agendamiento" required
                            class="form-control-uppercase">
                            <option value="" class="form-control-uppercase">SELECCIONE TIPO AGENDAMIENTO</option>
                            <option value="INSTALACIONES"
                                {{ old('tipo_agendamiento') == 'INSTALACIONES' ? 'selected' : '' }}>INSTALACIONES
                            </option>
                            <option value="POSTVENTAS" {{ old('tipo_agendamiento') == 'POSTVENTAS' ? 'selected' : '' }}>
                                POSTVENTAS
                            </option>
                            <option value="REPARACIONES"
                                {{ old('tipo_agendamiento') == 'REPARACIONES' ? 'selected' : '' }}>
                                REPARACIONES
                            </option>
                            <!-- Agregar más opciones según sea necesario -->
                        </select>
                        @error('tipo_agendamiento')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="fecha_agendamiento">Fecha de Agendamiento:</label>
                        <input type="date" class="form-control form-control-uppercase flatpickr" id="fecha_agendamiento"
                            name="fecha_agendamiento" value="{{ old('fecha_agendamiento') }}"
                            placeholder="Selecciona una fecha" required>
                        @error('fecha_agendamiento')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="hora_agendamiento">Hora de Agendamiento:</label>
                        <input type="time" class="form-control form-control-uppercase" id="hora_agendamiento"
                            name="hora_agendamiento" value="{{ old('hora_agendamiento') }}" required>
                        @error('hora_agendamiento')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Campo para Número de Orden -->
                    <div class="form-group col-md-3">
                        <label for="numero_orden">Orden Principal:</label>
                        <input type="number" class="form-control form-control-uppercase" id="numero_orden"
                            name="numero_orden" value="{{ old('numero_orden') }}" required
                            placeholder="Orden Principal...">
                        @error('numero_orden')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Campo para Observaciones -->
                    <div class="form-group col-md-12">
                        <label for="observaciones">Observaciones:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                            </div>
                            <textarea class="form-control form-control-uppercase" id="observaciones"
                                name="observaciones" placeholder="Observaciones..."
                                rows="3">{{ old('observaciones') }}</textarea>
                        </div>
                        @error('observaciones')
                        <span class="text-danger">El campo Observaciones es requerido.</span>
                        @enderror
                    </div>
                </div>
                <!-- Botón de enviar -->
                <div class="row justify-content-center">
                    <div class="col-3">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save"></i> REGISTRAR
                        </button>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="" style="padding-top: 1rem;
    padding-left: 1rem;">
        </div>
        <div class="card-body" style="spadding-top: 0 !important;">
            <div class="table-responsive">
                <table class="table table-light table-striped table-hover" id="tableAgendamientos">
                    <thead class="thead-dark">
                        <tr>
                            <th>Registro</th>
                            <th>Consecutivo</th>
                            <th>Codigo</th>
                            <th>Nombre tecnico</th>
                            <th>Tipo</th>
                            <th>Fecha Agendamiento</th>
                            <th>Orden</th>
                            <th>Observaciones</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agendamientos as $agendamiento)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($agendamiento->created_at)->format('d-m-Y H:i') }}</td>
                            <td>{{ $agendamiento->numeroid }}</td>
                            <td>{{ $agendamiento->codigo }}</td>
                            <td>{{ $agendamiento->nombre_tecnico }}</td>
                            <td>{{ $agendamiento->tipo_agendamiento }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($agendamiento->fecha_agendamiento . ' ' . $agendamiento->hora_agendamiento)->format('d/m/Y H:i') }}
                            </td>

                            <td>{{ $agendamiento->numero_orden}}</td>
                            <td>{{ $agendamiento->observaciones }}</td>
                            <td>{{ $agendamiento->user ? $agendamiento->user->name : 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>



@if(session('message'))
<script>
Swal.fire({
    title: '¡Éxito!',
    text: "{{ session('message') }}",
    icon: 'success',
    confirmButtonText: 'OK'
});
</script>
@endif

<script>
$(document).ready(function() {

    $('.js-example-theme-single').select2({
        theme: "classic",
        placeholder: "Selecciona una opción",
        allowClear: true,
        width: '100%'
    });


    $(".flatpickr").flatpickr({
        dateFormat: "Y-m-d", // Formato de fecha
        locale: "es", // Cambiar a español si lo necesitas
    });


    const table = $('#tableAgendamientos').DataTable({
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Tecnico sin agendamientos el dia de hoy",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "order": [
            [0, 'desc']
        ] // Asegúrate de que el índice de columna 6 sea 'created_at'
    });

    const buscarTecnico = () => {
        const codigo1 = $('#codigo').val();

        if (codigo1) {
            $.ajax({
                url: '{{ route("agendamientos.tecnico", ":codigo1") }}'.replace(':codigo1',
                    codigo1),
                method: 'GET',
                success: function(data) {
                    if (data.success) {
                        // Si el técnico fue encontrado y está activo
                        Swal.fire({
                            icon: 'success',
                            title: 'Técnico Encontrado 👨‍🔧',
                        });

                        $('#numero').val(data.tecnico.numero);
                        $('#nombre_tecnico').val(data.tecnico.nombre_tecnico);

                        // Desactivar el campo de código técnico
                        $('#codigo').prop('readonly', true);
                        $('#numero').prop('readonly', true);
                        $('#nombre_tecnico').prop('readonly', true);

                        // Procesar los datos de agendamientos
                        const dataTableData = data.agendamientos.map(agendamiento => {
                            // Formatear la fecha y hora de created_at
                            const formattedCreatedAt = new Date(agendamiento.created_at)
                                .toLocaleDateString('es-ES', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                }) + ' ' + new Date(agendamiento.created_at)
                                .toLocaleTimeString('es-ES', {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });

                            return [
                                formattedCreatedAt, // Fecha y hora formateadas
                                agendamiento.numeroid,
                                agendamiento.codigo,
                                agendamiento.nombre_tecnico,
                                agendamiento.tipo_agendamiento,
                                `${agendamiento.fecha_agendamiento} ${agendamiento.hora_agendamiento}`, // Unir fecha y hora
                                agendamiento.numero_orden,
                                agendamiento.observaciones,
                                agendamiento.user && agendamiento.user.name ?
                                agendamiento.user.name : 'N/A'
                            ];
                        });

                        table.clear().rows.add(dataTableData).draw();
                    } else {
                        // Mensaje de error basado en el mensaje recibido
                        if (data.message === 'Técnico no está activo') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Técnico Inactivo ⚠️',
                                text: data.message,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Técnico No Encontrado 🃏',
                                text: data.message,
                            });
                        }

                        $('#numero').val('');
                        $('#nombre_tecnico').val('');

                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un error al buscar el técnico. Inténtalo nuevamente.',
                    });

                    $('#numero').val('');
                    $('#nombre_tecnico').val('');
                }
            });
        } else {
            $('#numero').val('');
            $('#nombre_tecnico').val('');
        }
    };


    $('#codigo').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            buscarTecnico();
        }
    });

    $('#buscarTecnico').on('click', function(e) {
        e.preventDefault();
        buscarTecnico();
    });

    $('#resetButton').on('click', function() {
        // Limpiar los campos
        $('#codigo').val('');
        $('#numero').val('');
        $('#nombre_tecnico').val('');

        // Si quieres habilitar los campos nuevamente (si estaban deshabilitados)
        $('#codigo').prop('readonly', false);
        $('#numero').prop('readonly', true);
        $('#nombre_tecnico').prop('readonly', true);
    });



    document.getElementById('agendamiento-form').addEventListener('submit', function(event) {
        let isValid = true;
        let errorMessage = '';

        // Verificar campos requeridos
        const requiredFields = [
            'codigo',
            'numero',
            'nombre_tecnico',
            'tipo_agendamiento',
            'fecha_agendamiento',
            'hora_agendamiento',
            'numero_orden',
            'observaciones',
        ];

        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field || field.value.trim() === '') {
                isValid = false;
                errorMessage += `El campo ${field.getAttribute('placeholder')} es requerido.\n`;
            }
        });

        // Validar que 'numero_orden' tenga exactamente 8 dígitos
        const numeroOrdenField = document.getElementById('numero_orden');
        if (numeroOrdenField && numeroOrdenField.value.trim().length !== 8) {
            isValid = false;
            errorMessage += 'El campo Número Orden debe tener exactamente 8 dígitos.\n';
        }

        if (!isValid) {
            event.preventDefault(); // Evita el envío del formulario
            Swal.fire({
                title: 'Error!',
                text: errorMessage.trim(),
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }
    });

});
</script>



@stop