{{-- resources/views/postventas/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Postventas')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">


@section('content_header')
<h1>Postventas</h1>
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
            <h5>Registrar Postventas <img src="vendor/img/postventas.png" style="width:35px;" alt=""></h5>

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
        <form action="{{ route('postventas.store') }}" method="POST" id="postventas-form">
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

                <div class="" style="padding-top: 2rem;">
                    <div class="form-group col-md-12">
                        <button type="button" class="btn btn-primary" id="buscarTecnico">
                            <i class="fas fa-search"></i>
                        </button>
                        <button type="button" class="btn btn-dark" id="resetButton" style="padding:10px;">
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
                        <option value="Anulacion" class="form-control-uppercase">ANULACION</option>
                        <option value="Transferida" class="form-control-uppercase">TRANSFERIDA</option>
                    </select>
                </div>

                <div class="form-group col-md-5">
                    <label for="tipoOrden">Tipo Orden</label>
                    <select name="tipoOrden" id="tipoOrden" class="form-control select2 js-example-theme-single"
                        required style="width:100%;">
                        <option value="" class="form-control-uppercase">Selecciona una opción</option>

                        <!-- Sección Traslados -->
                        <optgroup label="SELECCIONA TIPO TRASLADO">
                            <option value="TRASLADO TRIPLE HFC">TRASLADO TRIPLE HFC</option>
                            <option value="TRASLADO DOBLE HFC">TRASLADO DOBLE HFC
                            </option>
                            <option value="TRASLADO INDIVIDUAL HFC">TRASLADO INDIVIDUAL HFC</option>
                            <option value="TRASLADO TRIPLE GPON">TRASLADO TRIPLE GPON</option>
                            <option value="TRASLADO DOBLE GPON">TRASLADO DOBLE GPON
                            </option>
                            <option value="TRASLADO INDIVIDUAL GPON">TRASLADO INDIVIDUAL GPON</option>
                            <option value="TRASLADO ADSL">TRASLADO ADSL</option>
                            <option value="TRASLADO COBRE">TRASLADO COBRE</option>
                            <option value="TRASLADO DTH">TRASLADO DTH</option>
                        </optgroup>

                        <!-- Sección Adiccion -->
                        <optgroup label="SELECCIONA TIPO DE ADICION">
                            <option value="ADICION ANOLOGA HFC">ADICION ANOLOGA HFC</option>
                            <option value="ADICION DTA HFC">ADICION DTA HFC</option>
                            <option value="ADICION DIGITAL HFC">ADICION DIGITAL HFC</option>
                            <option value="ADICION IPTV GPON">ADICION IPTV GPON</option>
                            <option value="ADICION TV DTH">ADICION TV DTH</option>
                        </optgroup>

                        <!-- Sección Cambios de equipos -->

                        <optgroup label="SELECCIONA TIPO CAMBIO EQUIPO">
                            <option value="CAMBIO DE EQUIPO TV HFC">CAMBIO DE EQUIPO TV HFC</option>
                            <option value="CAMBIO DE EQUIPO INTERNET HFC">CAMBIO DE EQUIPO INTERNET HFC</option>
                            <option value="CAMBIO DE EQUIPO TV GPON">CAMBIO DE EQUIPO TV GPON</option>
                            <option value="CAMBIO DE EQUIPO INTERNET GPON">CAMBIO DE EQUIPO INTERNET GPON</option>
                            <option value="CAMBIO DE EQUIPO ADSL">CAMBIO DE EQUIPO ADSL</option>
                            <option value="CAMBIO DE EQUIPO TV DTH">CAMBIO DE EQUIPO TV DTH</option>
                        </optgroup>

                        <!-- Sección Migracion -->
                        <optgroup label="SELECCION TIPO MIGRACION">
                            <option value="MIGRACION DTA HFC">MIGRACION DTA HFC</option>
                            <option value="MIGRACION DIGITAL HFC">MIGRACION DIGITAL HFC</option>
                            <option value="MIGRACION X PROYECTO HFC">MIGRACION X PROYECTO HFC</option>
                        </optgroup>

                        <!-- Sección Reconexion // Retiro -->
                        <optgroup label="SELECCIONE TIPO DE RECONEXION / RETIRO">
                            <option value="RECONEXION HFC">RECONEXION HFC</option>
                            <option value="RETIRO ACOMETIDO HFC">RETIRO ACOMETIDO HFC</option>
                            <option value="RETIRO EQUIPOS STB HFC">RETIRO EQUIPOS STB HFC</option>
                            <option value="RETIRO EQUIPOS CM HFC">RETIRO EQUIPOS CM HFC</option>
                            <option value="RETIRO EQUIPOS STB DTH">RETIRO EQUIPOS STB DTH</option>
                        </optgroup>

                        <optgroup label="SELECCIONE CAMBIO NUMERO COBRE">
                            <option value="CAMBIO NUMERO COBRE">CAMBIO NUMERO COBRE</option>
                        </optgroup>
                    </select>

                </div>

                <div class="form-group col-md-4">
                    <label for="depto">DPTO / COLONIA</label>
                    <select name="depto" id="depto" class="form-control select2 js-example-theme-single" required>
                        <option value="" class="form-control-uppercase">Selecciona una opción</option>
                        @foreach($dptos as $dpto)
                        <option value="{{ $dpto->id }}">{{ $dpto->depto }} - {{ $dpto->colonia }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="form-group-container form-row">
                <div class="form-group col-md-3">
                    <label for="orden">Orden</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-tv"></i></span>
                        </div>
                        <input type="number" name="orden" id="orden" class="form-control form-control-uppercase"
                            placeholder="Número Orden" value="">
                    </div>
                    @error('orden')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div id="">
                <!-- EQUIPOS TV A INSTALAR // EQUIPO A RETIRAR TV -->

                <div class="form-group-container form-row">
                    <div class="form-group col-md-3 hiddenEquiposTv" id="hiddenEquiposTv" style="display:none;">
                        <label for="equipos_tv">Equipos Tv 📺</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tv"></i></span>
                            </div>
                            <input type="text" name="equipotv1" id="equipotv1"
                                class="form-control form-control-uppercase" placeholder="Equipos Tv 1 " value="">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tv"></i></span>
                            </div>
                            <input type="text" name="equipotv2" id="equipotv2"
                                class="form-control form-control-uppercase" placeholder="Equipos Tv 2 " value="">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tv"></i></span>
                            </div>
                            <input type="text" name="equipotv3" id="equipotv3"
                                class="form-control form-control-uppercase" placeholder="Equipos Tv 3 " value="">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tv"></i></span>
                            </div>
                            <input type="text" name="equipotv4" id="equipotv4"
                                class="form-control form-control-uppercase" placeholder="Equipos Tv 4 " value="">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tv"></i></span>
                            </div>
                            <input type="text" name="equipotv5" id="equipotv5"
                                class="form-control form-control-uppercase" placeholder="Equipos Tv 5 " value="">
                        </div>
                    </div>

                    <div class="form-group col-md-3 hiddenEquiposRetiro" style="display:none;">
                        <label for="equipotvretira1">Equipos a retirar</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            </div>
                            <input type="text" name="equipotvretira1" id="equipotvretira1"
                                class="form-control form-control-uppercase" placeholder="Equipo a retirar 1" value="">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            </div>
                            <input type="text" name="equipotvretira2" id="equipotvretira2"
                                class="form-control form-control-uppercase" placeholder="Equipo a retirar 2" value="">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            </div>
                            <input type="text" name="equipotvretira3" id="equipotvretira3"
                                class="form-control form-control-uppercase" placeholder="Equipo a retirar 3" value="">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            </div>
                            <input type="text" name="equipotvretira4" id="equipotvretira4"
                                class="form-control form-control-uppercase" placeholder="Equipo a retirar 4" value="">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            </div>
                            <input type="text" name="equipotvretira5" id="equipotvretira5"
                                class="form-control form-control-uppercase" placeholder="Equipo a retirar 5" value="">
                        </div>
                    </div>
                </div>
                <!-- NUMERO LINEA COBRE // COORDENANDAS -->
                <div class="form-group-container form-row ">
                    <div class="form-group col-md-4 hiddenNumeroCobre" id="hiddenNumeroVoip" style="display:none;">
                        <label for="numerocobre">Numero Voip</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                            </div>
                            <input type="number" name="numerocobre" id="numerocobre"
                                class="form-control form-control-uppercase" placeholder="Número Voip" value="">
                        </div>
                        @error('numerocobre')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4 hiddenCoordenadas" id="hiddenCoordenadas" style="display:none;">
                        <label for="coordenadas">Coordenadas</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <input type="text" name="coordenadas" id="coordenadas"
                                class="form-control form-control-uppercase" placeholder="Coordenadas 📍" value="">
                        </div>
                        @error('coordenadas')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- EQUIPO MODEM A INSTALAR // A RETIRAR-->
                <div class="form-group-container form-row ">
                    <div class="form-group col-md-4 hiddenModem" style="display:none;">
                        <label for="equipomodem">Equipo Modem</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-wifi"></i></span>
                            </div>
                            <input type="text" name="equipomodem" id="equipomodem"
                                class="form-control form-control-uppercase" placeholder="Equipo Modem 🌐" value="">
                        </div>
                        @error('equipomodem')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4 hiddenModemRet" style="display:none;">
                        <label for="equipomodemret">Equipo Modem retirar</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-wifi"></i></span>
                            </div>
                            <input type="text" name="equipomodemret" id="equipomodemret"
                                class="form-control form-control-uppercase" placeholder="Equipo Modem a retirar🌐"
                                value="">
                        </div>
                        @error('equipomodemret')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <!-- COMENTARIOS // OBSERVACIONES-->
                <div class="form-group-container ">
                    <div class="form-row">
                        <!-- Campo para Observaciones -->
                        <div class="form-group col-md-12 hidddenCamposcomentarios">
                            <label for="observaciones">Observaciones </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-comment-dots"></i></span>
                                </div>
                                <input type="text" name="observaciones" id="observaciones"
                                    class="form-control form-control-uppercase" placeholder="Ingrese las observaciones"
                                    value="">
                            </div>
                            @error('observaciones')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo para Recibe -->
                        <div class="form-group col-md-9 hidddenCamposcomentarios">
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

                        <!-- Status-->

                        <div class="form-group col-md-2" style="margin-left: 1rem;margin-top:1rem;">
                            <label for="status"></label>
                            <div class="form-check" style="margin-top: 1rem;">
                                <input type="checkbox" name="status" id="status" class="form-check-input"
                                    value="Trabajado" style="transform: scale(1.4) !important;">
                                <label class="form-check-label" for="status"
                                    style="font-size: 1.1rem;font-weight: bold;">TRABAJADO</label>
                            </div>

                            @error('status')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- ELEMTENTOS DE RED -->
                <div class="form-group-container hiddenElementosRed">
                    <h4 class="box-title"
                        style="color: #343A40;display: flex; justify-content: center;font-weight:600;">
                        ELEMENTOS DE RED
                    </h4>
                    <div style="margin-bottom: 12px; border-top: 1px solid #c0bfbf;"></div>
                    <div class="form-row">
                        <!-- Campo para Nodo -->
                        <div class="form-group col-md-4">
                            <label for="nodo">Nodo 🌐</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-network-wired"></i></span>
                                </div>
                                <input type="text" name="nodo" id="nodo" class="form-control form-control-uppercase"
                                    placeholder="Ingrese el nodo" value="">
                            </div>
                            @error('nodo')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo para Caja / TAP -->
                        <div class="form-group col-md-4">
                            <label for="tap_caja">CAJA / TAP </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-box"></i></span>
                                </div>
                                <input type="text" name="tap_caja" id="tap_caja"
                                    class="form-control form-control-uppercase" placeholder="Ingrese la caja o TAP"
                                    value="">
                            </div>
                            @error('tap_caja')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo para Posición -->
                        <div class="form-group col-md-4">
                            <label for="posicion_puerto">Posición / Puerto</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <input type="text" name="posicion_puerto" id="posicion_puerto"
                                    class="form-control form-control-uppercase"
                                    placeholder="Ingrese la posición o Puerto" value="">
                            </div>
                            @error('posicion_puerto')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo para otra Posición -->
                        <div class="form-group col-md-12">
                            <label for="materiales">Materiales</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                                </div>
                                <input type="text" name="materiales" id="materiales"
                                    class="form-control form-control-uppercase" placeholder="Ingrese los materiales 📦"
                                    value="">
                            </div>
                            @error('materiales')
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
                        <label for="ObservacionesObj">Observaciones</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                            </div>
                            <input type="text" name="ObservacionesObj" id="ObservacionesObj"
                                class="form-control form-control-uppercase" placeholder="Ingrese los Observaciones..."
                                value="">
                        </div>
                        @error('ObservacionesObj')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>


            <div id="hiddenAnuladas" class="form-group-container form-row" style="display:none;">
                <div class="form-group-container">
                    <div class="form-group col-md-4">
                        <label for="motivoAnulada" class="form-control-uppercase">Motivo Anulación</label>
                        <select name="motivoAnulada" id="motivoAnulada"
                            class="form-control select2 js-example-theme-single">
                            @foreach($anulacion as $anulaciones)
                            <option selected="selected" value="">SELECCIONE UNA OPCION</option>
                            <option value="{{ $anulaciones->id }}">{{ $anulaciones->MotivoAnulacion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Campo para observaciones -->
                    <div class="form-group col-md-12">
                        <label for="ObservacionesAnuladas">Observaciones</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                            </div>
                            <input type="text" name="ObservacionesAnuladas" id="ObservacionesAnuladas"
                                class="form-control form-control-uppercase" placeholder="Ingrese los Observaciones"
                                value="">
                        </div>
                        @error('ObservacionesAnuladas')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div id="hiddenTransferidas" class="form-group-container form-row" style="display:none;">
                <div class="form-group-container">
                    <div class="form-group col-md-12">
                        <label for="motivoTransferido">OBSERVACIONES</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                            </div>
                            <input type="text" name="motivoTransferido" id="motivoTransferido"
                                class="form-control form-control-uppercase" placeholder="Ingrese las observaciones..."
                                value="">
                        </div>
                        @error('motivoTransferido')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>



            <div class="form-group" style="display: flex; justify-content: center;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save" style="padding-right: 10px;"> </i>GUARDAR REGISTRO
                </button>
            </div>

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

    $('#motivoObjetada').select2({
        width: '100%',
        theme: "classic",
        placeholder: "Selecciona una opción",
    });

    $('#motivoAnulada').select2({
        width: '100%',
        theme: "classic",
        placeholder: "Selecciona una opción",
    });

    $('#tipoactividad option[value="Transferida"]').hide();

    $('#tipoOrden').on('change', function() {
        var tipoOrden = $(this).val();

        // Lista de tipos de orden que permiten "Transferida"
        var ordenesConTransferida = [
            'TRASLADO TRIPLE HFC',
            'TRASLADO DOBLE HFC',
            'TRASLADO INDIVIDUAL HFC',
            'TRASLADO TRIPLE GPON',
            'TRASLADO DOBLE GPON',
            'TRASLADO INDIVIDUAL GPON',
            'TRASLADO ADSL',
            'TRASLADO COBRE',
            'TRASLADO DTH',
            'MIGRACION DTA HFC',
            'MIGRACION DIGITAL HFC',
            'MIGRACION X PROYECTO HFC'
        ];

        // Mostrar u ocultar la opción "Transferida"
        if (ordenesConTransferida.includes(tipoOrden)) {
            $('#tipoactividad option[value="Transferida"]').show();
        } else {
            $('#tipoactividad option[value="Transferida"]').hide();

            // Si "Transferida" está seleccionada y no es válida para este tipo de orden
            if ($('#tipoactividad').val() === 'Transferida') {
                $('#tipoactividad').val('Realizada'); // Cambiar a "Realizada"
            }
        }
    });

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

    $('#postventas-form').on('submit', function() {
        $('#codigo_hidden').val($('#codigo').val());
        $('#numero_hidden').val($('#numero').val());
        $('#nombre_tecnico_hidden').val($('#nombre_tecnico').val());



    });

    var checkbox = document.querySelector('input[type="checkbox"][name="status"]');

    checkbox.addEventListener('change', function() {
        if (checkbox.checked) {
            checkbox.value = "Trabajado";
        } else {
            checkbox.value = "Pendiente";
        }
    });

    $('#depto').select2({
        width: '100%',
        theme: "classic",
        placeholder: "Selecciona una opción",
    });

    $('#tipoOrden').select2({
        width: '100%',
        theme: "classic",
        placeholder: "Selecciona una opción",
    });


    $('#tipoOrden').on('change',
        toggleFields); // 
    $('#tipoactividad').on('change', toggleFields);



    function toggleFields() {

        // Selecciona todos los elementos con la clase 'mi-clase'
        const hiddenEquiposTv = document.querySelectorAll('.hiddenEquiposTv');
        const hiddenEquiposRetiro = document.querySelectorAll('.hiddenEquiposRetiro');
        const hiddenNumeroCobre = document.querySelectorAll('.hiddenNumeroCobre');
        const hiddenCoordenadas = document.querySelectorAll('.hiddenCoordenadas');
        const hidddenCamposcomentarios = document.querySelectorAll('.hidddenCamposcomentarios');
        const hiddenElementosRed = document.querySelectorAll('.hiddenElementosRed');
        const hiddenModem = document.querySelectorAll('.hiddenModem');
        const hiddenModemRet = document.querySelectorAll('.hiddenModemRet');


        const nodo = document.getElementById('nodo');
        const tapCaja = document.getElementById('tap_caja');
        const posicionPuerto = document.getElementById('posicion_puerto');
        const materiales = document.getElementById('materiales');

        console.log("Cambio detectado en tipo de actividad u orden");

        nodo.disabled = false;
        tap_caja.disabled = false;
        posicion_puerto.disabled = false;
        materiales.disabled = false;

        hiddenObjetadas.style.display = "none";
        hiddenAnuladas.style.display = "none";
        hiddenTransferidas.style.display = "none";




        hiddenEquiposTv.forEach(elemento => {
            elemento.style.display = 'none';
        });
        hiddenEquiposRetiro.forEach(elemento => {
            elemento.style.display = 'none';
        });
        hiddenNumeroCobre.forEach(elemento => {
            elemento.style.display = 'none';
        });
        hiddenCoordenadas.forEach(elemento => {
            elemento.style.display = 'none';
        });
        hidddenCamposcomentarios.forEach(elemento => {
            elemento.style.display = 'block';
        });
        hiddenElementosRed.forEach(elemento => {
            elemento.style.display = 'block';
        });

        hiddenModem.forEach(elemento => {
            elemento.style.display = 'block';
        });
        hiddenModemRet.forEach(elemento => {
            elemento.style.display = 'block';
        });


        if (tipoactividad.value === "Realizada") {


            hiddenEquiposTv.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenEquiposRetiro.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenNumeroCobre.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenCoordenadas.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hidddenCamposcomentarios.forEach(elemento => {
                elemento.style.display = 'block';
            });
            hiddenElementosRed.forEach(elemento => {
                elemento.style.display = 'block';
            });

            hiddenModem.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenModemRet.forEach(elemento => {
                elemento.style.display = 'none';
            });
            switch (tipoOrden.value) {
                case "TRASLADO TRIPLE HFC":

                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    break;
                case "TRASLADO DOBLE HFC":

                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    break;
                case "TRASLADO INDIVIDUAL HFC":

                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    break;
                case "TRASLADO TRIPLE GPON":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    break;
                case "TRASLADO DOBLE GPON":

                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    break;
                case "TRASLADO INDIVIDUAL GPON":

                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    break;

                case "TRASLADO ADSL":

                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    nodo.disabled = true;
                    tap_caja.disabled = true;
                    posicion_puerto.disabled = true;

                    break;


                case "TRASLADO COBRE":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    nodo.disabled = true;
                    tap_caja.disabled = true;
                    posicion_puerto.disabled = true;
                    break;
                case "TRASLADO DTH":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    nodo.disabled = true;
                    tap_caja.disabled = true;
                    posicion_puerto.disabled = true;

                    break;
                case "ADICION ANOLOGA HFC":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    break;
                case "ADICION DTA HFC":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    break;
                case "ADICION DIGITAL HFC":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    break;
                case "ADICION IPTV GPON":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    break;

                case "ADICION TV DTH":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    break;
                case "CAMBIO DE EQUIPO TV HFC":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    break;
                case "CAMBIO DE EQUIPO INTERNET HFC":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    break;
                case "CAMBIO DE EQUIPO TV GPON":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    break;
                case "CAMBIO DE EQUIPO INTERNET GPON":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    break;
                case "CAMBIO DE EQUIPO ADSL":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    break;
                case "CAMBIO DE EQUIPO TV DTH":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    break;
                case "MIGRACION DTA HFC":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    break;
                case "MIGRACION DIGITAL HFC":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    break;
                case "MIGRACION X PROYECTO HFC":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    break;
                case "RECONEXION HFC":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    nodo.disabled = true;
                    tap_caja.disabled = true;
                    posicion_puerto.disabled = true;

                    break;
                case "RETIRO ACOMETIDO HFC":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    nodo.disabled = true;
                    tap_caja.disabled = true;
                    posicion_puerto.disabled = true;

                    break;
                case "RETIRO EQUIPOS STB HFC":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    nodo.disabled = true;
                    tap_caja.disabled = true;
                    posicion_puerto.disabled = true;

                    break;
                case "RETIRO EQUIPOS CM HFC":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    nodo.disabled = true;
                    tap_caja.disabled = true;
                    posicion_puerto.disabled = true;

                    break;
                case "RETIRO EQUIPOS STB DTH":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'block';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    nodo.disabled = true;
                    tap_caja.disabled = true;
                    posicion_puerto.disabled = true;

                    break;
                case "CAMBIO NUMERO COBRE":
                    hiddenEquiposTv.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenEquiposRetiro.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenNumeroCobre.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenCoordenadas.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hidddenCamposcomentarios.forEach(elemento => {
                        elemento.style.display = 'block';
                    });
                    hiddenElementosRed.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    hiddenModem.forEach(elemento => {
                        elemento.style.display = 'none';
                    });
                    hiddenModemRet.forEach(elemento => {
                        elemento.style.display = 'none';
                    });

                    nodo.disabled = true;
                    tap_caja.disabled = true;
                    posicion_puerto.disabled = true;

                    break;
                default:
                    console.warn("Tipo de orden no manejado:", tipoOrden.value);
                    break;
            }
        }

        if (tipoactividad.value === "Objetada") {
            hiddenObjetadas.style.display = "block";

            hiddenEquiposTv.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenEquiposRetiro.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenNumeroCobre.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenCoordenadas.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hidddenCamposcomentarios.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenElementosRed.forEach(elemento => {
                elemento.style.display = 'none';
            });

            hiddenModem.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenModemRet.forEach(elemento => {
                elemento.style.display = 'none';
            });

        }
        if (tipoactividad.value === "Anulacion") {
            hiddenAnuladas.style.display = "block";

            hiddenEquiposTv.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenEquiposRetiro.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenNumeroCobre.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenCoordenadas.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hidddenCamposcomentarios.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenElementosRed.forEach(elemento => {
                elemento.style.display = 'none';
            });

            hiddenModem.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenModemRet.forEach(elemento => {
                elemento.style.display = 'none';
            });

        }
        if (tipoactividad.value === "Transferida") {
            hiddenTransferidas.style.display = "block";

            hiddenEquiposTv.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenEquiposRetiro.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenNumeroCobre.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenCoordenadas.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hidddenCamposcomentarios.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenElementosRed.forEach(elemento => {
                elemento.style.display = 'none';
            });

            hiddenModem.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenModemRet.forEach(elemento => {
                elemento.style.display = 'none';
            });

        }



    }

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

        // Limpiar los valores de los campos especificados
        const camposALimpiar = [
            'observaciones',
            'recibe',
            'nodo',
            'tap_caja',
            'posicion_puerto',
            'materiales',
            'equipotv1',
            'equipotv2',
            'equipotv3',
            'equipotv4',
            'equipotv5',
            'equipotvretira1',
            'equipotvretira2',
            'equipotvretira3',
            'equipotvretira4',
            'equipotvretira5',
            'equipomodem',
            'equipomodemret',
            'coordenadas',
            'numerocobre'
        ];

        camposALimpiar.forEach(function(campo) {
            const inputElement = $('#' + campo);
            if (inputElement.length) {
                inputElement.val(''); // Limpia el campo
            }
        });
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


    $('#postventas-form').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario

        // Limpiar los errores anteriores
        $('.is-invalid').removeClass('is-invalid');
        $('.is-valid').removeClass('is-valid');

        // Restaurar los placeholders originales
        $('input').each(function() {
            $(this).attr('placeholder', $(this).data('placeholder'));
        });

        var formData = $(this).serialize();


        // Enviar la solicitud AJAX solo si no hay errores en los campos de órdenes
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
                        var input = $('input[name="' + field + '"]');
                        if (!input.is(':disabled')) {
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





    // Agregar el evento de input para quitar el icono de error y mostrar el check verde
    $('input').on('input', function() {
        var input = $(this);

        if (input.attr('id') !== 'codigo' && input.attr('id') !==
            'status') { // Excluir el campo 'codigo' de la validación visual
            if (input.val().trim() !== '') {
                input.removeClass('is-invalid').addClass('is-valid');
            } else {
                input.removeClass('is-valid is-invalid');
            }
        }
    });



});
</script>

@stop