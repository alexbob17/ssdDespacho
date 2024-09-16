{{-- resources/views/auth/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Consultas')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

@section('content_header')
<h1>Consultas</h1>
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
                <h5>Registrar Consulta <img src="vendor/img/consulta6.png" style="width:35px;" alt=""></h5>

            </div>
            <div class="">

                <div class="" style="padding-bottom:10px;">
                    <a href=" {{ route('home') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('consultas.store') }}" method="POST" id="consulta-form">
                @csrf
                <div class="form-row align-items-center">
                    <div class="form-group col-md-3">
                        <label for="codigo_tecnico">Código Técnico</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="codigo_tecnico" id="codigo_tecnico"
                                class="form-control form-control-uppercase" placeholder="Código Técnico" value=""
                                required>
                        </div>
                        @error('codigo_tecnico')
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

                <div class="form-row">
                    <div class="form-group col-md-9">
                        <label for="motivo_consulta">Motivo Consulta</label>
                        <select name="motivo_consulta" id="motivo_consulta"
                            class="form-control select2 js-example-theme-single" required>
                            <option value="" class="form-control-uppercase">Selecciona una opción</option>
                            @foreach($motivos as $id => $motivo)
                            <option value="{{ $motivo }}"
                                {{ old('motivo_consulta', $consulta->motivo_consulta ?? '') == $motivo ? 'selected' : '' }}>
                                {{ $motivo }}
                            </option>
                            @endforeach
                        </select>
                        @error('motivo_consulta')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="numero_orden">Número Orden</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-sort-numeric-down"></i></span>
                            </div>
                            <input type="number" name="numero_orden" id="numero_orden"
                                class="form-control form-control-uppercase" placeholder="Número Orden" value=""
                                required>
                        </div>
                        @error('numero_orden')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="observaciones">Observaciones</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                        </div>
                        <textarea name="observaciones" id="observaciones" class="form-control form-control-uppercase"
                            placeholder="OBSERVACIONES..." rows="3"></textarea>
                    </div>
                    @error('observaciones')
                    <div class="text-danger">El campo Observaciones es Requerido.</div>
                    @enderror
                </div>

                <div class="form-group" style="display: flex; justify-content: center;">
                    <button type="submit" class="btn btn-primary" id="submit-button">
                        <i class="fas fa-save" style="padding-right: 10px;"> </i>GUARDAR CONSULTA
                    </button>
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
        <div class="card-body" style="padding-top: 0 !important;">
            <div class="table-responsive">
                <table class="table table-light table-striped table-hover" id="tableConsultas">
                    <thead>
                        <tr>
                            <th>NumConsulta</th>
                            <th>Hora</th>
                            <th>Fecha</th>
                            <th>CodTecnico</th>
                            <th>Nombre Tecnico</th>
                            <th>Motivo Consulta</th>
                            <th>Orden</th>
                            <th>Observaciones</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultas as $consulta)
                        <tr>
                            <td>{{ $consulta->idconsulta}}</td>
                            <td>{{ $consulta->created_at->format('d/m/Y') }}</td>
                            <td>{{ $consulta->created_at->format('H:i:s') }}</td>
                            <td>{{ $consulta->codigo_tecnico }}</td>
                            <td>{{ $consulta->nombre_tecnico }}</td>
                            <td>{{ $consulta->motivo_consulta }}</td>
                            <td>{{ $consulta->numero_orden }}</td>
                            <td>{{ $consulta->observaciones }}</td>
                            <td>{{ $consulta->user ? $consulta->user->name : 'N/A' }}</td>
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
@stop

@section('js')


<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>



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

    const table = $('#tableConsultas').DataTable({
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Tecnico sin consultas el dia de hoy",
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
        ]
    });

    const buscarTecnico = () => {
        const codigo = $('#codigo_tecnico').val();

        if (codigo) {
            $.ajax({
                url: '{{ route("consultas.tecnico", ":codigo") }}'.replace(':codigo', codigo),
                method: 'GET',
                success: function(data) {
                    if (data.numero) {
                        if (data.status ===
                            'Activo') { // Comparar directamente con "ACTIVO" en mayúsculas
                            Swal.fire({
                                icon: 'success',
                                title: 'Técnico Encontrado 👨‍🔧',
                            });

                            $('#numero').val(data.numero);
                            $('#nombre_tecnico').val(data.nombre_tecnico);

                            // Desactivar el campo de código técnico
                            $('#codigo_tecnico').prop('readonly', true);
                            $('#numero').prop('readonly', true);
                            $('#nombre_tecnico').prop('readonly', true);

                            const dataTableData = data.consultas.map(consulta => [
                                consulta.idconsulta,
                                new Date(consulta.created_at).toLocaleDateString(
                                    'es-ES', {
                                        day: '2-digit',
                                        month: '2-digit',
                                        year: 'numeric'
                                    }),
                                consulta.created_at.slice(11, 19),
                                consulta.codigo_tecnico,
                                consulta.nombre_tecnico,
                                consulta.motivo_consulta,
                                consulta.numero_orden,
                                consulta.observaciones,
                                consulta.user && consulta.user.name ? consulta.user
                                .name :
                                'N/A' // Verifica que user y user.name no sean nulos
                            ]);

                            table.clear().rows.add(dataTableData).draw();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Técnico Inactivo ⚠️',
                                text: 'El técnico con el código ingresado no está activo.',
                            });

                            // Limpiar los campos
                            $('#numero').val('');
                            $('#nombre_tecnico').val('');
                            $('#codigo_tecnico').prop('readonly', false);
                            $('#numero').prop('readonly', false);
                            $('#nombre_tecnico').prop('readonly', false);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Técnico No Encontrado 🃏',
                            text: 'No se encontró ningún técnico con el código ingresado.',
                        });

                        $('#numero').val('');
                        $('#nombre_tecnico').val('');
                        $('#codigo_tecnico').prop('readonly', false);
                        $('#numero').prop('readonly', false);
                        $('#nombre_tecnico').prop('readonly', false);
                    }
                },
                error: function() {
                    $('#numero').val('');
                    $('#nombre_tecnico').val('');
                }
            });
        } else {
            $('#numero').val('');
            $('#nombre_tecnico').val('');
        }
    };

    $('#resetButton').on('click', function() {
        // Limpiar los campos
        $('#codigo_tecnico').val('');
        $('#numero').val('');
        $('#nombre_tecnico').val('');

        // Si quieres habilitar los campos nuevamente (si estaban deshabilitados)
        $('#codigo_tecnico').prop('readonly', false);
        $('#numero').prop('readonly', true);
        $('#nombre_tecnico').prop('readonly', true);
    });


    $('#codigo_tecnico').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            buscarTecnico();
        }
    });

    $('#buscarTecnico').on('click', function(e) {
        e.preventDefault();
        buscarTecnico();
    });

    document.getElementById('consulta-form').addEventListener('submit', function(event) {
        let isValid = true;
        let errorMessage = '';

        // Verificar campos requeridos
        const requiredFields = [
            'codigo_tecnico',
            'numero',
            'nombre_tecnico',
            'motivo_consulta',
            'numero_orden',
            'observaciones'
        ];

        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field || field.value.trim() === '') {
                isValid = false;
                errorMessage += `El campo ${field.getAttribute('placeholder')} es requerido.\n`;
            }
        });

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