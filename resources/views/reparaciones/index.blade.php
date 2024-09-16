<!-- resources/views/instalaciones/create.blade.php -->
{{-- resources/views/auth/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Reparaciones')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">

@section('content_header')
<h1> Reparaciones</h1>
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

<div class="card">
    <div class="d-flex justify-content-between align-items-center"
        style="padding: 0.9rem; padding-bottom:0 !important; background: #343a40; color:white;">
        <div class="">
            <h5>Registrar Reparacion <img src="vendor/img/repair1.png" style="width:35px;" alt=""></h5>

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
        <form action="{{ route('reparaciones.store') }}" method="POST" id="reparaciones-form">
            @csrf
            <div class="form-group-container form-row">
                <div class="form-group col-md-3">
                    <label for="codigo">Código Técnico</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="text" name="codigo" id="codigo" class="form-control form-control-uppercase"
                            placeholder="Código Técnico 🆔" value="" required>
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
                            placeholder="Número 🔢" value="" required disabled>
                    </div>
                    @error('numero')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="nombre_tecnico">Nombre Técnico</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="nombre_tecnico" id="nombre_tecnico"
                            class="form-control form-control-uppercase" placeholder="Nombre Técnico 👨‍🔧" value=""
                            required disabled>
                    </div>
                    @error('nombre_tecnico')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <input type="hidden" id="codigo_hidden" name="codigo">
                <input type="hidden" id="numero_hidden" name="numero">
                <input type="hidden" id="nombre_tecnico_hidden" name="nombre_tecnico">
            </div>

            <div class="form-group-container form-row">
                <div class="form-group col-md-3">
                    <label for="tipoactividad">Tipo Actividad</label>
                    <select name="tipoactividad" id="tipoactividad" class="form-control select2" required>
                        <option value="Realizada" class="form-control-uppercase">REALIZADA</option>
                        <option value="Objetada" class="form-control-uppercase">OBJETADA</option>
                        <option value="Transferida" class="form-control-uppercase">TRANSFERIDA</option>
                    </select>
                </div>

                <div class="form-group col-md-5">
                    <label for="tipoOrden">Tipo Orden</label>
                    <select name="tipoOrden" id="tipoOrden" class="form-control select2 js-example-theme-single"
                        required style="width:100%;">
                        <option value="" class="form-control-uppercase">Selecciona una opción</option>
                        <option value="REPARACION TV HFC">REPARACION TV HFC</option>
                        <option value="REPARACION INTERNET HFC">REPARACION INTERNET HFC</option>
                        <option value="REPARACION LINEA HFC">REPARACION LINEA HFC</option>
                        <option value="REPARACION IPTV GPON">REPARACION IPTV GPON</option>
                        <option value="REPARACION INTERNET GPON">REPARACION INTERNET GPON</option>
                        <option value="REPARACION LINEA GPON">REPARACION LINEA GPON</option>
                        <option value="REPARACION TV DTH">REPARACION TV DTH</option>
                        <option value="REPARACION LINEA COBRE">REPARACION LINEA COBRE</option>
                        <option value="REPARACION INTERNET ADSL">REPARACION INTERNET ADSL</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="Depto">DPTO / COLONIA</label>
                    <select name="Depto" id="Depto" class="form-control select2 js-example-theme-single" required
                        style="margin-bottom: 200px;">
                        <option value="" class="form-control-uppercase">Selecciona una opción</option>
                        @foreach($dptos as $dpto)
                        <option value="{{ $dpto->id }}">{{ $dpto->depto }} - {{ $dpto->colonia }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div id="" style="">
                <div class="form-group-container form-row">
                    <div class="form-group col-md-3 hiddenDiv">
                        <label for="codigocausa">Codigo Causa</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-sort-numeric-up"></i></span>
                            </div>
                            <input type="text" name="codigocausa" id="codigocausa"
                                class="form-control form-control-uppercase" placeholder="Código Causa ⛔" value="">
                        </div>
                        @error('codigocausa')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-row " style="padding-top: 2rem;">
                        <div class="form-group col-md-12 hiddenDiv">
                            <button type="button" class="btn btn-dark" id="Searchcausa">
                                <i class="fas fa-search"></i>
                            </button>
                            <button type="button" class="btn btn-secondary" id="deletecausa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group-container form-row">
                    <div class="form-group col-md-4 hiddenDiv">
                        <label for="tipocausa">Tipo Causa</label>
                        <select name="tipocausa" id="tipocausa" class="form-control">
                            <option value="" class="form-control-uppercase">Seleccione una opción</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4 hiddenDiv">
                        <label for="tipodaño">Tipo Daño</label>
                        <select name="tipodaño" id="tipodaño" class="form-control">
                            <option value="" class="form-control-uppercase">Seleccione una opción</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4 hiddenDiv">
                        <label for="ubicaciondaño">Ubicación Causa</label>
                        <select name="ubicaciondaño" id="ubicaciondaño" class="form-control">
                            <option value="" class="form-control-uppercase">Seleccione una opción</option>
                        </select>
                    </div>
                </div>


                <div class="form-group-container form-row"
                    style="border-top:1px solid #d4d1d1; margin-top:1.5rem; padding-top:1rem;" id="classRemove">

                    <!-- Número de Orden -->
                    <div class="form-group col-md-3">
                        <label for="orden">Número de Orden
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-hashtag"></i>
                                </span>
                                <!-- Icono cambiado -->
                            </div>
                            <input type="text" name="orden" id="orden" class="form-control form-control-uppercase"
                                placeholder="Ingresa el número de orden" value="">
                        </div>
                        @error('orden')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Solicitud de Cambio -->
                    <div class="form-group col-md-3 hiddenDiv">
                        <label for="solicitudcambio">Solicitud de Cambio</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-edit"></i></span>
                            </div>
                            <input type="number" name="solicitudcambio" id="solicitudcambio"
                                class="form-control form-control-uppercase" placeholder="Ingresa la solicitud de cambio"
                                value="">
                        </div>
                        @error('solicitudcambio')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Estado Trabajado -->
                    <div class="form-group col-md-2" style="margin-left: 1rem;">
                        <label for="status"></label>
                        <div class="form-check" style="margin-top: 1rem;">
                            <input type="checkbox" name="status" id="status" class="form-check-input" value="Trabajado"
                                style="transform: scale(1.4) !important;">
                            <label class="form-check-label" for="status"
                                style="font-size: 1.1rem; font-weight: bold;">TRABAJADO</label>
                        </div>

                        @error('status')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="form-group-container hiddenDiv">
                    <div class="form-row">
                        <!-- Campo para Observaciones -->
                        <div class="form-group col-md-12">
                            <label for="comentarios">Comentarios </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-comment-dots"></i></span>
                                </div>
                                <input type="text" name="comentarios" id="comentarios"
                                    class="form-control form-control-uppercase" placeholder="Ingrese las comentarios"
                                    value="">
                            </div>
                            @error('comentarios')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo para Recibe -->
                        <div class="form-group col-md-12">
                            <label for="recibe">Recibe</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                                </div>
                                <input type="text" name="recibe" id="recibe" class="form-control form-control-uppercase"
                                    placeholder="Nombre de quien recibe " value="">
                            </div>
                            @error('recibe')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div id="hiddenObjetadas" style="display:none;">
                <div class="form-group-container">
                    <div class="form-group col-md-4">
                        <label for="motivoObjetada">MOTIVO OBJETADA</label>
                        <select name="motivoObjetada" id="motivoObjetada"
                            class="form-control select2 js-example-theme-single" <option value=""
                            class="form-control-uppercase">Selecciona una opción</option>
                            <option selected="selected" value="">SELECCIONE UNA OPCION</option>
                            <option value="COORDENADAS ERRONEAS">COORDENADAS ERRONEAS </option>
                            <option value="EQUIPO NO INVENTARIADO EN SAP">EQUIPO NO INVENTARIADO EN SAP
                            </option>
                            <option value="EQUIPOS CON PROBLEMAS EN SAP">EQUIPOS CON PROBLEMAS EN SAP </option>
                            <option value="PROBLEMAS DE INVENTARIADO OPEN"> PROBLEMAS DE INVENTARIADO OPEN
                            </option>
                            <option value="ROUTER NO SINCRONIZA">ROUTER NO SINCRONIZA </option>
                            <option value="TEC NO INICIA / PROGRAMA ETA"> TEC NO INICIA / PROGRAMA ETA </option>
                            <option value="NODO INCORRECTO"> NODO INCORRECTO </option>
                            <option value="OTROS"> OTROS </option>
                        </select>
                    </div>
                    <!-- Campo para observaciones -->
                    <div class="form-group col-md-12">
                        <label for="comentariosObjetado">Observaciones</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-file-alt"></i>
                                </span>
                            </div>
                            <input type="text" name="comentariosObjetado" id="comentariosObjetado"
                                class="form-control form-control-uppercase" placeholder="Ingrese los Observaciones"
                                value="">
                        </div>
                        @error('comentariosObjetado')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div id="hiddenTransferidas" style="display:none;">
                <div class="form-group-container">
                    <div class="form-group col-md-12">
                        <label for="ObservacionesTransferida">Observaciones</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                            </div>
                            <input name="ObservacionesTransferida" id="ObservacionesTransferida"
                                class="form-control form-control-uppercase"
                                placeholder="Ingresa los comentarios..."></input>
                        </div>
                        @error('ObservacionesTransferida')
                        <div class="text-danger">El campo Observaciones es Requerido.</div>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="form-group" style="display: flex; justify-content: center;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save" style="padding-right: 10px;"> </i>GUARDAR REGISTRO
                </button>
            </div>

        </form>
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
<!-- Incluyendo los CSS y JS locales desde tu carpeta de assets -->
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />

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

@if(session('errormsg'))
<script>
Swal.fire({
    title: '¡Error!',
    text: "{{ session('errormsg') }}",
    icon: 'error',
    confirmButtonText: 'OK'
});
</script>
@endif


<script>
$(document).ready(function() {

    const buscarTecnico = () => {
        const codigo1 = $('#codigo').val();

        if (codigo1) {
            $.ajax({
                url: '{{ route("instalaciones.tecnico", ":codigo1") }}'.replace(':codigo1',
                    codigo1),
                method: 'GET',
                success: function(data) {
                    if (data.success) {
                        // Si el técnico fue encontrado y está activo
                        Swal.fire({
                            icon: 'success',
                            title: 'Técnico Encontrado 👨‍🔧',
                            text: data.message,
                        });

                        $('#numero').val(data.tecnico.numero);
                        $('#nombre_tecnico').val(data.tecnico.nombre_tecnico);

                        // Desactivar el campo de código técnico
                        $('#codigo').prop('disabled', true);
                        $('#numero').prop('disabled', true);
                        $('#nombre_tecnico').prop('disabled', true);
                    } else {
                        // Si el técnico no está activo
                        if (data.message === 'Técnico no está activo') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Técnico Inactivo ⚠️',
                                text: data.message,
                            });
                        } else {
                            // Si el técnico no fue encontrado
                            Swal.fire({
                                icon: 'error',
                                title: 'Técnico No Encontrado 🃏',
                                text: data.message,
                            });
                        }

                        // Limpiar los campos pero no cambiar el estado de `disabled`
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

                    // Limpiar los campos pero no cambiar el estado de `disabled`
                    $('#numero').val('');
                    $('#nombre_tecnico').val('');
                }
            });
        } else {
            // Si el campo de código está vacío, limpiar los campos relacionados
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
        $('#codigo').prop('disabled', false);
        $('#numero').prop('disabled', true);
        $('#nombre_tecnico').prop('disabled', true);
    });

    $('#reparaciones-form').on('submit', function() {
        // Habilitar todos los campos antes de enviar el formulario
        $('#codigo_hidden').val($('#codigo').val());
        $('#numero_hidden').val($('#numero').val());
        $('#nombre_tecnico_hidden').val($('#nombre_tecnico').val());

        // $('#codigo').prop('disabled', false);
        // $('#numero').prop('disabled', false);
        // $('#nombre_tecnico').prop('disabled', false);


    });

    $('#Depto').select2({
        width: '100%', // Ajusta el ancho al 100% del contenedor
        theme: "classic",
        placeholder: "Selecciona una opción",
    });


    $('#tipoOrden').select2({
        width: '100%', // Ajusta el ancho al 100% del contenedor
        theme: "classic",
        placeholder: "Selecciona una opción",
    });

    $('#tipocausa').select2({
        width: '100%', // Ajusta el ancho al 100% del contenedor
        theme: "classic",
        placeholder: "Selecciona una opción",
    });

    $('#tipodaño').select2({
        width: '100%', // Ajusta el ancho al 100% del contenedor
        theme: "classic",
        placeholder: "Selecciona una opción",
    });

    $('#ubicaciondaño').select2({
        width: '100%', // Ajusta el ancho al 100% del contenedor
        theme: "classic",
        placeholder: "Selecciona una opción",
    });

    $('#motivoObjetada').select2({
        width: '100%', // Ajusta el ancho al 100% del contenedor
        theme: "classic",
        placeholder: "Selecciona una opción",
    });

    var checkbox = document.querySelector('input[type="checkbox"][name="status"]');

    checkbox.addEventListener('change', function() {
        if (checkbox.checked) {
            checkbox.value = "Trabajado";
        } else {
            checkbox.value = "Pendiente";
        }
    });

    function showAlert(title, text, icon) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            confirmButtonText: 'Aceptar'
        });
    }

    function performSearch() {
        const tipoOrden = $('#tipoOrden').val();
        const codigoCausa = $('#codigocausa').val();

        if (!tipoOrden || !codigoCausa) {
            showAlert('Error', 'Por favor, seleccione un tipo de orden e ingrese un código de causa.',
                'warning');
            return;
        }

        let jsonFile;
        switch (tipoOrden) {
            case 'REPARACION TV HFC':
                jsonFile = 'codigoHfcTv.json';
                break;
            case 'REPARACION INTERNET HFC':
                jsonFile = 'codigoHfcInternet.json';
                break;
            case 'REPARACION LINEA HFC':
                jsonFile = 'codigoHfcLinea.json';
                break;
            case 'REPARACION IPTV GPON':
                jsonFile = 'codigoGponTv.json';
                break;
            case 'REPARACION INTERNET GPON':
                jsonFile = 'codigoGponInternet.json';
                break;
            case 'REPARACION LINEA GPON':
                jsonFile = 'codigoGponLinea.json';
                break;
            case 'REPARACION TV DTH':
                jsonFile = 'codigoDth.json';
                break;
            case 'REPARACION LINEA COBRE':
                jsonFile = 'codigoCobre.json';
                break;
            case 'REPARACION INTERNET ADSL':
                jsonFile = 'codigoAdsl.json';
                break;
            default:
                showAlert('Error', 'Ingrese un tipo de orden.', 'warning');
                return;
        }

        $.getJSON(`/json/${jsonFile}`, function(data) {
            const results = data.filter(item => item.CODIGOCAUSA == codigoCausa);

            if (results.length > 0) {
                const uniqueCausa = new Set();
                $('#tipocausa').html(
                    '<option value="" class="form-control-uppercase">Seleccione una opción</option>'
                );
                $('#tipodaño').html(
                    '<option value="" class="form-control-uppercase">Seleccione una opción</option>'
                );
                $('#ubicaciondaño').html(
                    '<option value="" class="form-control-uppercase">Seleccione una opción</option>'
                );

                results.forEach(result => {
                    if (!uniqueCausa.has(result.DESCRIPCIONCAUSA)) {
                        uniqueCausa.add(result.DESCRIPCIONCAUSA);
                        $('#tipocausa').append(
                            `<option value="${result.DESCRIPCIONCAUSA}">${result.DESCRIPCIONCAUSA}</option>`
                        );
                    }
                    $('#tipodaño').append(
                        `<option value="${result.DESCRIPCIONTIPODAÑO}">${result.DESCRIPCIONTIPODAÑO}</option>`
                    );
                    $('#ubicaciondaño').append(
                        `<option value="${result.DESCRIPCIONUBICACIONDAÑO}">${result.DESCRIPCIONUBICACIONDAÑO}</option>`
                    );
                });

                if (results.length == 1) {
                    // Solo un resultado encontrado, rellenar automáticamente
                    const result = results[0];
                    $('#tipocausa').val(result.DESCRIPCIONCAUSA);
                    $('#tipodaño').val(result.DESCRIPCIONTIPODAÑO);
                    $('#ubicaciondaño').val(result.DESCRIPCIONUBICACIONDAÑO);
                }

                showAlert('Éxito', 'Código encontrado y datos cargados correctamente.', 'success');

                // Establecer el campo de código causa como solo lectura
                $('#codigocausa').prop('readonly', true);

                // Establecer el campo tipoOrden como solo lectura
                $('#tipoOrden').prop('readonly', true);

                // Habilitar el botón de eliminar
                $('#deletecausa').prop('disabled', false);
            } else {
                showAlert('Error', 'Código de causa no encontrado', 'error');
            }
        }).fail(function() {
            showAlert('Error', 'Error al cargar.', 'error');
        });
    }

    function clearFields() {
        $('#codigocausa').val('').prop('readonly', false); // Habilitar el campo
        $('#tipoOrden').val(null).trigger('change').prop('readonly',
            false); // Limpiar el valor y actualizar Select2, luego habilitar
        $('#tipocausa').html('<option value="" class="form-control-uppercase">Seleccione una opción</option>');
        $('#tipodaño').html('<option value="" class="form-control-uppercase">Seleccione una opción</option>');
        $('#ubicaciondaño').html(
            '<option value="" class="form-control-uppercase">Seleccione una opción</option>'
        );

        // Deshabilitar el botón de eliminar después de limpiar
        $('#deletecausa').prop('disabled', true);
    }

    // Nueva función para limpiar campos y habilitar nuevamente
    function resetFields() {
        $('#codigocausa').val('').prop('readonly', false);
        $('#tipocausa').html('<option value="" class="form-control-uppercase">Seleccione una opción</option>');
        $('#tipodaño').html('<option value="" class="form-control-uppercase">Seleccione una opción</option>');
        $('#ubicaciondaño').html(
            '<option value="" class="form-control-uppercase">Seleccione una opción</option>');
        $('#deletecausa').prop('disabled', true);
    }

    // Añadir controlador de evento para el cambio de opción en tipoOrden
    $('#tipoOrden').on('change', function() {
        resetFields();
    });

    $('#tipoactividad').on('change', function() {
        resetFields();
    });



    // Asignar la búsqueda al botón
    $('#Searchcausa').on('click', function() {
        performSearch();
    });

    // Asignar la búsqueda a la tecla Enter en el campo de código de causa
    $('#codigocausa').on('keypress', function(e) {
        if (e.which === 13) { // Enter key pressed
            e.preventDefault(); // Prevent form submission
            performSearch();
        }
    });

    // Asignar la función de limpiar a botón de eliminar
    $('#deletecausa').on('click', function() {
        clearFields();
    });

    // Guardar el placeholder original en los inputs
    // Guardar el placeholder original en los inputs
    $('input').each(function() {
        $(this).data('placeholder', $(this).attr('placeholder'));
    });

    $('#tipoOrden').on('change', function() {
        // Eliminar las clases de error y éxito en los inputs relacionados, excepto en los deshabilitados
        $('.is-invalid').removeClass('is-invalid');
        $('.is-valid').removeClass('is-valid');

        // Restaurar los placeholders originales
        $('input').each(function() {
            $(this).attr('placeholder', $(this).data('placeholder'));
        });

        // Opcional: Limpiar los valores de los campos si es necesario
    });

    $('#tipoactividad').on('change', function() {
        // Eliminar las clases de error y éxito en los inputs relacionados, excepto en los deshabilitados
        $('.is-invalid').removeClass('is-invalid');
        $('.is-valid').removeClass('is-valid');

        // Restaurar los placeholders originales
        $('input').each(function() {
            $(this).attr('placeholder', $(this).data('placeholder'));
        });

        // Opcional: Limpiar los valores de los campos si es necesario
    });

    $('input').on('input', function() {
        var input = $(this);

        // Excluir los campos 'codigo' y 'codigocausa' de la validación visual
        if (input.attr('id') !== 'codigo' && input.attr('id') !== 'codigocausa' && input.attr('id') !==
            'status') {
            if (input.val().trim() !== '') {
                input.removeClass('is-invalid').addClass('is-valid');
            } else {
                input.removeClass('is-valid');
            }
        }
    });


    $('#reparaciones-form').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario

        // Limpiar los errores anteriores
        $('.is-invalid').removeClass('is-invalid');
        $('.is-valid').removeClass('is-valid');


        $('input').each(function() {
            $(this).attr('placeholder', $(this).data(
                'placeholder')); // Restaurar el placeholder original
        });

        // Obtener los datos del formulario
        var formData = $(this).serialize();

        // Enviar la solicitud AJAX
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            success: function(response) {
                // Mostrar un SweetAlert con el mensaje de éxito
                if (response.message) {
                    Swal.mixin({
                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-danger"
                        },
                        buttonsStyling: false
                    });
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: true,
                        confirmButtonText: 'Aceptar',
                    }).then((result) => {
                        // Redirigir a la URL proporcionada en la respuesta
                        if (response.redirect_url) {
                            window.location.href = response.redirect_url;
                        }
                    });
                }
            },
            error: function(response) {
                if (response.status === 422) {
                    // Manejar errores de validación (código de estado 422)
                    var errors = response.responseJSON.errors;
                    for (var field in errors) {
                        if (field !==
                            'codigo') { // Excluir el campo 'codigo' de la validación visual
                            var input = $('input[name="' + field + '"]');
                            input.addClass('is-invalid').attr('placeholder', errors[field][
                                0
                            ]);
                        }
                    }
                } else if (response.status === 400) {
                    // Manejar errores específicos (código de estado 400)
                    var errors = response.responseJSON;
                    if (errors.errormsg) {
                        Swal.fire({
                            title: '¡Error!',
                            text: errors.errormsg,
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                } else {
                    // Manejar otros errores inesperados
                    Swal.fire({
                        icon: 'error',
                        title: 'Ocurrió un error inesperado',
                        text: 'Por favor, inténtalo de nuevo.',
                        confirmButtonText: 'Aceptar',
                    });
                }
            }
        });
    });





    document.getElementById('tipoactividad').addEventListener('change', function() {
        // Obtener el valor seleccionado
        let tipoActividad = this.value;

        const elementos = document.querySelectorAll('.hiddenDiv');
        const classhidden = document.getElementById('classRemove');

        elementos.forEach(elemento => {
            elemento.style.display = 'block';
        });

        // Ocultar todos los divs
        //document.getElementById('hiddenRealizadas').style.display = 'none';
        document.getElementById('hiddenObjetadas').style.display = 'none';
        document.getElementById('hiddenTransferidas').style.display = 'none';

        classhidden.classList.remove("elementohidden");

        // Limpiar todos los campos
        let fieldsToClear = [
            'codigocausa', 'tipocausa', 'tipodaño', 'ubicaciondaño', 'solicitudcambio', 'recibe',
            'comentarios',
            'motivoObjetada', 'comentariosObjetado', 'ObservacionesTransferida',
            'comentariosTransferida'
        ];

        fieldsToClear.forEach(function(field) {
            let input = document.querySelector('input[name="' + field + '"]');
            if (input) {
                input.value = '';
            }
        });

        // Mostrar el div correspondiente según el tipo de actividad
        if (tipoActividad === 'Realizada') {
            elementos.forEach(elemento => {
                elemento.style.display = 'block';

            });
            classhidden.classList.remove("elementohidden");

        } else if (tipoActividad === 'Objetada') {
            document.getElementById('hiddenObjetadas').style.display = 'block';
            elementos.forEach(elemento => {
                elemento.style.display = 'none';
            });
            classhidden.classList.add("elementohidden");

        } else if (tipoActividad === 'Transferida') {
            document.getElementById('hiddenTransferidas').style.display = 'block';
            elementos.forEach(elemento => {
                elemento.style.display = 'none';
            });
            classhidden.classList.add("elementohidden");
        }
    });




});
</script>

@stop