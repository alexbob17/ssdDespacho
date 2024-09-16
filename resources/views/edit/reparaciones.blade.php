<!-- resources/views/instalaciones/create.blade.php -->
{{-- resources/views/auth/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Editar Reparaciones')
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
        <div>

        </div>
        <div class="" style="text_aling:center;">
            <h5
                style="color: black;font-size: 25px;font-style: italic;font-weight: 600;background: yellow;padding: 2px 4px;border-radius: 5px;">
                📑 BOLETA
                #{{ old('numConsecutivo', $record->numConsecutivo) }}
            </h5>

        </div>

        <div class="">

            <div class="" style="padding-bottom:10px;">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('reparaciones.update', $record->id) }}" method="POST" id="reparaciones-form">
            @csrf
            @method('PUT')

            <div class="form-group-container form-row">
                <div class="form-group col-md-3">
                    <label for="codigo">Código Técnico</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="text" name="codigo" id="codigo" class="form-control form-control-uppercase"
                            placeholder="Código Técnico 🆔" value="{{ old('codigo', $record->codigo) }}" required
                            readonly>
                    </div>
                    @error('codigo')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group col-md-3">
                    <label for="numero">Número</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                        </div>
                        <input type="text" name="numero" id="numero" class="form-control form-control-uppercase"
                            placeholder="Número 🔢" value="{{ old('numero', $record->numero) }}" required readonly>
                    </div>
                    @error('numero')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-5">
                    <label for="nombre_tecnico">Nombre Técnico</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="nombre_tecnico" id="nombre_tecnico"
                            class="form-control form-control-uppercase" placeholder="Nombre Técnico 👨‍🔧"
                            value="{{ old('nombre_tecnico', $record->nombre_tecnico) }}" required readonly>
                    </div>
                    @error('nombre_tecnico')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group-container form-row">
                <div class="form-group col-md-3">
                    <label for="tipoactividad">Tipo Actividad</label>
                    <select name="tipoactividad" id="tipoactividad" class="form-control select2" required>
                        <option value="{{ $record->tipoactividad }}" selected>{{ strtoupper($record->tipoactividad) }}
                    </select>
                </div>

                <div class="form-group col-md-5">
                    <label for="tipoOrden">Tipo Orden</label>
                    <select name="tipoOrden" id="tipoOrden" class="form-control select2 js-example-theme-single"
                        required style="width:100%;">
                        <option value="{{ $record->tipoOrden }}" selected>{{ strtoupper($record->tipoOrden) }}
                    </select>

                </div>

                <div class="form-group col-md-4">
                    <label for="Depto">DPTO / COLONIA</label>
                    <select name="Depto" id="Depto" class="form-control select2 js-example-theme-single" required
                        style="margin-bottom: 200px;">
                        <option value="" class="form-control-uppercase">Selecciona una opción</option>
                        @foreach($dptos as $dpto)
                        <option value="{{ $dpto->id }}" {{ $record->Depto == $dpto->id ? 'selected' : '' }}>
                            {{ $dpto->depto }} - {{ $dpto->colonia }}
                        </option>
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
                                class="form-control form-control-uppercase" placeholder="Código Causa ⛔"
                                value="{{ old('codigocausa', $record->codigocausa) }}" readonly>
                        </div>
                        @error('codigocausa')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group-container form-row">
                    <div class="form-group col-md-4 hiddenDiv">
                        <label for="tipocausa">Tipo Causa</label>
                        <select name="tipocausa" id="tipocausa" class="form-control">
                            <option value="{{ $record->tipocausa }}" selected>{{ strtoupper($record->tipocausa) }}

                        </select>
                    </div>
                    <div class="form-group col-md-4 hiddenDiv">
                        <label for="tipodaño">Tipo Daño</label>
                        <select name="tipodaño" id="tipodaño" class="form-control">
                            <option value="{{ $record->tipodaño }}" selected>{{ strtoupper($record->tipodaño) }}

                        </select>
                    </div>
                    <div class="form-group col-md-4 hiddenDiv">
                        <label for="ubicaciondaño">Ubicación Causa</label>
                        <select name="ubicaciondaño" id="ubicaciondaño" class="form-control">
                            <option value="{{ $record->tipoOrden }}" selected>{{ strtoupper($record->tipoOrden) }}

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
                                placeholder="Ingresa el número de orden" value="{{ old('orden', $record->orden) }}">
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
                                value="{{ old('solicitudcambio', $record->solicitudcambio) }}">
                        </div>
                        @error('solicitudcambio')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Trabajado -->
                    <div class="form-group col-md-2" style="margin-left: 1rem;">
                        <label for="status"></label>
                        <div class="form-check" style="margin-top: 1rem;">
                            <input type="checkbox" class="form-check-input" id="status" name="status" value="Trabajado"
                                style="transform: scale(1.4) !important;"
                                {{ $record->status == 'Trabajado' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status" style="font-size: 1.1rem;font-weight: bold;">
                                TRABAJADO
                            </label>
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
                                    value="{{ old('comentarios', $record->comentarios) }}">
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
                                    placeholder="Nombre de quien recibe " value="{{ old('recibe', $record->recibe) }}">
                            </div>
                            @error('recibe')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div id="hiddenObjetadas" class="form-group-container form-row" style="display:none;">
                <div class="form-group-container">
                    <div class="form-group col-md-4">
                        <label for="motivoObjetada">MOTIVO OBJETADA</label>
                        <select name="motivoObjetada" id="motivoObjetada"
                            class="form-control select2 js-example-theme-single">
                            <option value="">Selecciona una opción</option>
                            <option value="COORDENADAS ERRONEAS"
                                {{ $record->motivoObjetada == 'COORDENADAS ERRONEAS' ? 'selected' : '' }}>
                                COORDENADAS ERRONEAS
                            </option>
                            <option value="EQUIPO NO INVENTARIADO EN SAP"
                                {{ $record->motivoObjetada == 'EQUIPO NO INVENTARIADO EN SAP' ? 'selected' : '' }}>
                                EQUIPO NO INVENTARIADO EN SAP
                            </option>
                            <option value="EQUIPOS CON PROBLEMAS EN SAP"
                                {{ $record->motivoObjetada == 'EQUIPOS CON PROBLEMAS EN SAP' ? 'selected' : '' }}>
                                EQUIPOS CON PROBLEMAS EN SAP
                            </option>
                            <option value="PROBLEMAS DE INVENTARIADO OPEN"
                                {{ $record->motivoObjetada == 'PROBLEMAS DE INVENTARIADO OPEN' ? 'selected' : '' }}>
                                PROBLEMAS DE INVENTARIADO OPEN
                            </option>
                            <option value="ROUTER NO SINCRONIZA"
                                {{ $record->motivoObjetada == 'ROUTER NO SINCRONIZA' ? 'selected' : '' }}>
                                ROUTER NO SINCRONIZA
                            </option>
                            <option value="NODO INCORRECTO"
                                {{ $record->motivoObjetada == 'NODO INCORRECTO' ? 'selected' : '' }}>
                                NODO INCORRECTO
                            </option>
                            <option value="OTROS" {{ $record->motivoObjetada == 'OTROS' ? 'selected' : '' }}>
                                OTROS
                            </option>
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
                                value="{{ old('comentariosObjetado', $record->comentariosObjetado) }}">
                        </div>
                        @error('comentariosObjetado')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div id="hiddenTransferidas" class="form-group-container form-row" style="display:none;">
                <div class="form-group-container">
                    <div class="form-group col-md-12">
                        <label for="ObservacionesTransferida">Observaciones</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                            </div>
                            <input name="ObservacionesTransferida" id="ObservacionesTransferida"
                                class="form-control form-control-uppercase"
                                value="{{ old('ObservacionesTransferida', $record->ObservacionesTransferida) }}"
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

    const tipoActividadSelect = document.getElementById('tipoactividad');
    const classhidden = document.getElementById('classRemove');
    const elementos = document.querySelectorAll('.hiddenDiv');


    function updateVisibility(tipoActividad) {
        // Mostrar todos los divs primero
        elementos.forEach(elemento => {
            elemento.style.display = 'block';
        });

        // Ocultar todos los divs
        document.getElementById('hiddenObjetadas').style.display = 'none';
        document.getElementById('hiddenTransferidas').style.display = 'none';

        classhidden.classList.remove("elementohidden");



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
    }

    // Actualizar la visibilidad basada en el valor actual del select
    updateVisibility(tipoActividadSelect.value);

    // Manejar el evento change
    tipoActividadSelect.addEventListener('change', function() {
        updateVisibility(this.value);
    });


});
</script>

@stop