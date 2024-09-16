<!-- resources/views/instalaciones/create.blade.php -->
{{-- resources/views/auth/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Instalaciones')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">

@section('content_header')
<h1> Instalaciones</h1>
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
            <h5>Registrar Instalaciones <img src="vendor/img/instalaciones1.png" style="width:35px;" alt=""></h5>

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
        <form action="{{route ('instalaciones.store')}}" method="POST" id="instalaciones-form">
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
                        <option value="Anulacion" class="form-control-uppercase">ANULACION</option>
                        <option value="Transferida" class="form-control-uppercase">TRANSFERIDA</option>
                    </select>
                </div>

                <div class="form-group col-md-5">
                    <label for="tipoOrden">Tipo Orden</label>
                    <select name="tipoOrden" id="tipoOrden" class="form-control select2 js-example-theme-single"
                        required style="width:100%;">
                        <option value="" class="form-control-uppercase">Selecciona una opción</option>

                        <!-- Sección HFC -->
                        <optgroup label="HFC">
                            <option value="TRIPLE INSTALACION HFC">TRIPLE INSTALACION HFC</option>
                            <option value="DOBLE INSTALACION TV + INTERNET HFC">DOBLE INSTALACION TV + INTERNET HFC
                            </option>
                            <option value="DOBLE INSTALACION INTERNET + LINEA HFC">DOBLE INSTALACION INTERNET + LINEA
                                HFC</option>
                            <option value="INDIVIDUAL ANALOGO HFC">INDIVIDUAL ANALOGO HFC</option>
                            <option value="INDIVIDUAL DIGITAL TV HFC">INDIVIDUAL DIGITAL TV HFC</option>
                            <option value="INDIVIDUAL INTERNET HFC">INDIVIDUAL INTERNET HFC</option>
                            <option value="INDIVIDUAL LINEA HFC">INDIVIDUAL LINEA HFC</option>
                        </optgroup>

                        <!-- Sección GPON -->
                        <optgroup label="GPON">
                            <option value="TRIPLE INSTALACION GPON">TRIPLE INSTALACION GPON</option>
                            <option value="DOBLE INSTALACION IPTV + LINEA GPON">DOBLE INSTALACION IPTV + LINEA GPON
                            </option>
                            <option value="DOBLE INSTALACION INTERNET + IPTV GPON">DOBLE INSTALACION INTERNET + IPTV
                                GPON</option>
                            <option value="DOBLE INSTALACION INTERNET + LINEA GPON">DOBLE INSTALACION INTERNET + LINEA
                                GPON</option>
                            <option value="INDIVIDUAL INTERNET GPON">INDIVIDUAL INTERNET GPON</option>
                            <option value="INDIVIDUAL IPTV GPON">INDIVIDUAL IPTV GPON</option>
                            <option value="INDIVIDUAL LINEA GPON">INDIVIDUAL LINEA GPON</option>
                        </optgroup>

                        <!-- Sección ADSL -->
                        <optgroup label="ADSL">
                            <option value="INSTALACION INTERNET ADSL">INSTALACION INTERNET ADSL</option>
                            <!-- Agrega más opciones para ADSL si es necesario -->
                        </optgroup>

                        <!-- Sección COBRE -->
                        <optgroup label="COBRE">
                            <option value="INSTALACION LINEA COBRE">INSTALACION LINEA COBRE</option>
                            <!-- Agrega más opciones para COBRE si es necesario -->
                        </optgroup>

                        <!-- Sección DTH -->
                        <optgroup label="DTH">
                            <option value="INSTALACION TV SATELITAL DTH">INSTALACION TV SATELITAL DTH</option>
                            <!-- Agrega más opciones para DTH si es necesario -->
                        </optgroup>
                    </select>

                </div>

                <div class="form-group col-md-4">
                    <label for="depto">DPTO / COLONIA</label>
                    <select name="depto" id="depto" class="form-control select2 js-example-theme-single" required
                        style="margin-bottom: 200px;">
                        <option value="" class="form-control-uppercase">Selecciona una opción</option>
                        @foreach($dptos as $dpto)
                        <option value="{{ $dpto->id }}">{{ $dpto->depto }} - {{ $dpto->colonia }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="form-group-container form-row">
                <div class="form-group col-md-3" style="margin-top: 3rem; text-align: center;">
                    <label for="" style="color: #3e69d6; font-size: 18px;">SOLICITUDES</label>
                </div>

                <div class="form-group col-md-3">
                    <label for="ordenTv">Orden Tv</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-tv"></i></span>
                        </div>
                        <input type="number" name="ordenTv" id="ordenTv" class="form-control form-control-uppercase"
                            placeholder="Número Orden" value="">
                    </div>
                    @error('ordenTv')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="ordenInternet">Orden Internet</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-wifi"></i></span>
                        </div>
                        <input type="number" name="ordenInternet" id="ordenInternet"
                            class="form-control form-control-uppercase" placeholder="Número Orden" value="">
                    </div>
                    @error('ordenInternet')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="ordenLinea">Orden Línea</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                        </div>
                        <input type="number" name="ordenLinea" id="ordenLinea"
                            class="form-control form-control-uppercase" placeholder="Número Orden" value="">
                    </div>
                    @error('ordenLinea')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

            </div>


            <div id="">
                <div class="form-group-container form-row">
                    <div class="form-group col-md-3 hiddenDiv" id="hiddenEquiposTv">
                        <label for="equipos_tv">Equipos Tv 📺</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tv"></i></span>
                            </div>
                            <input type="text" name="equiposTvnumero1" id="equiposTvnumero1"
                                class="form-control form-control-uppercase" placeholder="Equipos Tv 1 " value="">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tv"></i></span>
                            </div>
                            <input type="text" name="equiposTvnumero2" id="equiposTvnumero2"
                                class="form-control form-control-uppercase" placeholder="Equipos Tv 2 " value="">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tv"></i></span>
                            </div>
                            <input type="text" name="equiposTvnumero3" id="equiposTvnumero3"
                                class="form-control form-control-uppercase" placeholder="Equipos Tv 3 " value="">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tv"></i></span>
                            </div>
                            <input type="text" name="equiposTvnumero4" id="equiposTvnumero4"
                                class="form-control form-control-uppercase" placeholder="Equipos Tv 4 " value="">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tv"></i></span>
                            </div>
                            <input type="text" name="equiposTvnumero5" id="equiposTvnumero5"
                                class="form-control form-control-uppercase" placeholder="Equipos Tv 5 " value="">
                        </div>
                    </div>

                    <div class="form-group col-md-3 " id="hiddenSmartcard" style="display:none;">
                        <label for="smartcardnumero1">SmartCard 💳</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            </div>
                            <input type="number" name="smartcardnumero1" id="smartcardnumero1"
                                class="form-control form-control-uppercase" placeholder="SmartCard 1 " value="">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            </div>
                            <input type="number" name="smartcardnumero2" id="smartcardnumero2"
                                class="form-control form-control-uppercase" placeholder="SmartCard 2 " value="">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            </div>
                            <input type="number" name="smartcardnumero3" id="smartcardnumero3"
                                class="form-control form-control-uppercase" placeholder="SmartCard 3 " value="">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            </div>
                            <input type="number" name="smartcardnumero4" id="smartcardnumero4"
                                class="form-control form-control-uppercase" placeholder="SmartCard 4 " value="">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            </div>
                            <input type="number" name="smartcardnumero5" id="smartcardnumero5"
                                class="form-control form-control-uppercase" placeholder="SmartCard 5 " value="">
                        </div>
                    </div>

                    <div class="form-group col-md-4 hiddenDiv" id="hiddenEquipoModem">
                        <label for="equipoModem">Equipo Modem</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-wifi"></i></span>
                            </div>
                            <input type="text" name="equipoModem" id="equipoModem"
                                class="form-control form-control-uppercase" placeholder="Equipo Modem 🌐" value="">
                        </div>
                        @error('equipoModem')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4 hiddenDiv" id="hiddenNumeroVoip">
                        <label for="numeroLinea">Numero Voip</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                            </div>
                            <input type="number" name="numeroLinea" id="numeroLinea"
                                class="form-control form-control-uppercase" placeholder="Número Voip" value="">
                        </div>
                        @error('numeroLinea')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4 hiddenDiv" id="hiddenSap">
                        <label for="sap">SAP</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                            </div>
                            <input type="text" name="sap" id="sap" class="form-control form-control-uppercase"
                                placeholder="SAP" value="">
                        </div>
                        @error('sap')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4 hiddenDiv" id="hiddenCoordenadas">
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

                    <div class="form-group col-md-2" style="margin-left: 1rem;">
                        <label for="status"></label>
                        <div class="form-check" style="margin-top: 1rem;">
                            <input type="checkbox" name="status" id="status" class="form-check-input" value="Trabajado"
                                style="transform: scale(1.4) !important;">
                            <label class="form-check-label" for="status"
                                style="font-size: 1.1rem;font-weight: bold;">TRABAJADO</label>
                        </div>

                        @error('status')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="form-group-container hiddenDiv" id="hidddenCamposcomentarios">
                    <div class="form-row">
                        <!-- Campo para Observaciones -->
                        <div class="form-group col-md-12">
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

                <div class="form-group-container hiddenDiv" id="hiddenElementosRed">
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
                            <label for="tapCaja">CAJA / TAP </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-box"></i></span>
                                </div>
                                <input type="text" name="tapCaja" id="tapCaja"
                                    class="form-control form-control-uppercase" placeholder="Ingrese la caja o TAP"
                                    value="">
                            </div>
                            @error('tapCaja')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo para Posición -->
                        <div class="form-group col-md-4">
                            <label for="posicion">Posición / Puerto</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <input type="text" name="posicion" id="posicion"
                                    class="form-control form-control-uppercase"
                                    placeholder="Ingrese la posición o Puerto" value="">
                            </div>
                            @error('posicion')
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
                        <label for="ObservacionesObj">Observaciones</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                            </div>
                            <input type="text" name="ObservacionesObj" id="ObservacionesObj"
                                class="form-control form-control-uppercase" placeholder="Ingrese los Observaciones"
                                value="">
                        </div>
                        @error('ObservacionesObj')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>


            <div id="hiddenAnuladas" style="display:none;">
                <div class="form-group-container">
                    <div class="form-group col-md-4">
                        <label for="motivoAnulada" class="form-control-uppercase">Motivo Anulación</label>
                        <select name="motivoAnulada" id="motivoAnulada"
                            class="form-control select2 js-example-theme-single">
                            <option selected="selected" value="">SELECCIONE UNA OPCION</option>
                            @foreach($anulacion as $anulaciones)
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

            <div id="hiddenTransferidas" style="display:none;">
                <div class="form-group-container">
                    <div class="form-group col-md-12">
                        <label for="motivoTransferido">Motivo Transferido</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                            </div>
                            <input type="text" name="motivoTransferido" id="motivoTransferido"
                                class="form-control form-control-uppercase" placeholder="Ingrese el motivo" value="">
                        </div>
                        @error('motivoTransferido')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Campo para observaciones -->
                    <div class="form-group col-md-12">
                        <label for="ObservacionesTransferido">Observaciones</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                            </div>
                            <input type="text" name="ObservacionesTransferido" id="ObservacionesTransferido"
                                class="form-control form-control-uppercase" placeholder="Ingrese los Observaciones"
                                value="">
                        </div>
                        @error('ObservacionesTransferido')
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

    $('#instalaciones-form').on('submit', function() {
        // Habilitar todos los campos antes de enviar el formulario
        $('#codigo_hidden').val($('#codigo').val());
        $('#numero_hidden').val($('#numero').val());
        $('#nombre_tecnico_hidden').val($('#nombre_tecnico').val());

        // $('#codigo').prop('disabled', false);
        // $('#numero').prop('disabled', false);
        // $('#nombre_tecnico').prop('disabled', false);


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
        width: '100%', // Ajusta el ancho al 100% del contenedor
        theme: "classic",
        placeholder: "Selecciona una opción",
    });

    $('#tipoOrden').select2({
        width: '100%', // Ajusta el ancho al 100% del contenedor
        theme: "classic",
        placeholder: "Selecciona una opción",
    });


    $('#motivoObjetada').select2({
        width: '100%', // Ajusta el ancho al 100% del contenedor
        theme: "classic",
        placeholder: "Selecciona una opción",
    });

    $('#motivoAnulada').select2({
        width: '100%', // Ajusta el ancho al 100% del contenedor
        theme: "classic",
        placeholder: "Selecciona una opción",
    });


    $('#tipoOrden').on('change',
        toggleFields); // 
    $('#tipoactividad').on('change', toggleFields);




    function toggleFields() {

        // Selecciona todos los elementos con la clase 'mi-clase'
        const elementos = document.querySelectorAll('.hiddenDiv');


        console.log("Cambio detectado en tipo de actividad u orden");

        // Limpiar los valores de los campos
        numeroLinea.value = "";
        ordenLinea.value = "";
        ordenTv.value = "";
        equiposTvnumero1.value = "";
        equiposTvnumero2.value = "";
        equiposTvnumero3.value = "";
        equiposTvnumero4.value = "";
        equiposTvnumero5.value = "";
        ordenInternet.value = "";
        equipoModem.value = "";
        coordenadas.value = "";
        nodo.value = "";
        tapCaja.value = "";
        posicion.value = "";
        materiales.value = "";

        // Habilitar todos los campos por defecto
        numeroLinea.disabled = false;
        ordenLinea.disabled = false;
        ordenTv.disabled = false;
        ordenInternet.disabled = false;
        equiposTvnumero1.disabled = false;
        equiposTvnumero2.disabled = false;
        equiposTvnumero3.disabled = false;
        equiposTvnumero4.disabled = false;
        equiposTvnumero5.disabled = false;
        smartcardnumero1.disabled = false;
        smartcardnumero2.disabled = false;
        smartcardnumero3.disabled = false;
        smartcardnumero4.disabled = false;
        smartcardnumero5.disabled = false;
        equipoModem.disabled = false;
        coordenadas.disabled = false;
        nodo.disabled = false;
        tapCaja.disabled = false;
        posicion.disabled = false;
        materiales.disabled = false;


        //Ocultar Elementos
        hiddenEquiposTv.style.display = "block";
        hiddenNumeroVoip.style.display = "block";
        hiddenElementosRed.style.display = "block";
        hiddenSmartcard.style.display = "none";
        hiddenEquipoModem.style.display = "block";
        hiddenSap.style.display = "block";
        //hiddenRealizadas.style.display = "block";
        hiddenObjetadas.style.display = "none";
        hiddenAnuladas.style.display = "none";
        hiddenTransferidas.style.display = "none";

        elementos.forEach(elemento => {
            elemento.style.display = 'block';
        });


        if (tipoactividad.value === "Realizada") {
            hiddenSmartcard.style.display = "none";
            hiddenObjetadas.style.display = "none";
            hiddenAnuladas.style.display = "none";
            hiddenTransferidas.style.display = "none";

            //Ocultar campos de realizada
            elementos.forEach(elemento => {
                elemento.style.display = 'block';
            });
            switch (tipoOrden.value) {
                case "Selecciona una opción":
                    // Mantener todos los campos habilitados

                    break;
                case "TRIPLE INSTALACION HFC":
                    // Mantener todos los campos habilitados

                    break;
                case "DOBLE INSTALACION TV + INTERNET HFC":
                    numeroLinea.disabled = true;
                    ordenLinea.disabled = true;
                    break;
                case "DOBLE INSTALACION INTERNET + LINEA HFC":
                    ordenTv.disabled = true;
                    equiposTvnumero1.disabled = true;
                    equiposTvnumero2.disabled = true;
                    equiposTvnumero3.disabled = true;
                    equiposTvnumero4.disabled = true;
                    equiposTvnumero5.disabled = true;

                    break;
                case "INDIVIDUAL ANALOGO HFC":
                    equiposTvnumero1.disabled = true;
                    equiposTvnumero2.disabled = true;
                    equiposTvnumero3.disabled = true;
                    equiposTvnumero4.disabled = true;
                    equiposTvnumero5.disabled = true;
                    ordenInternet.disabled = true;
                    ordenLinea.disabled = true;
                    numeroLinea.disabled = true;
                    equipoModem.disabled = true;

                    break;
                case "INDIVIDUAL DIGITAL TV HFC":
                    ordenInternet.disabled = true;
                    ordenLinea.disabled = true;
                    numeroLinea.disabled = true;
                    equipoModem.disabled = true;

                    break;
                case "INDIVIDUAL INTERNET HFC":
                    ordenTv.disabled = true;
                    equiposTvnumero1.disabled = true;
                    equiposTvnumero2.disabled = true;
                    equiposTvnumero3.disabled = true;
                    equiposTvnumero4.disabled = true;
                    equiposTvnumero5.disabled = true;
                    numeroLinea.disabled = true;
                    ordenLinea.disabled = true;

                    break;
                case "INDIVIDUAL LINEA HFC":
                    ordenInternet.disabled = true;
                    ordenTv.disabled = true;
                    equiposTvnumero1.disabled = true;
                    equiposTvnumero2.disabled = true;
                    equiposTvnumero3.disabled = true;
                    equiposTvnumero4.disabled = true;
                    equiposTvnumero5.disabled = true;

                    break;
                case "TRIPLE INSTALACION GPON":
                    coordenadas.disabled = true;

                    break;
                case "DOBLE INSTALACION IPTV + LINEA GPON":
                    ordenInternet.disabled = true;
                    equipoModem.disabled = true;
                    coordenadas.disabled = true;

                    nodo.disabled = true;
                    tapCaja.disabled = true;
                    posicion.disabled = true;
                    materiales.disabled = true;
                    break;
                case "DOBLE INSTALACION INTERNET + IPTV GPON":
                    ordenLinea.disabled = true;
                    numeroLinea.disabled = true;
                    coordenadas.disabled = true;

                    break;
                case "DOBLE INSTALACION INTERNET + LINEA GPON":
                    ordenTv.disabled = true;
                    equiposTvnumero1.disabled = true;
                    equiposTvnumero2.disabled = true;
                    equiposTvnumero3.disabled = true;
                    equiposTvnumero4.disabled = true;
                    equiposTvnumero5.disabled = true;
                    coordenadas.disabled = true;

                    break;
                case "INDIVIDUAL INTERNET GPON":
                    ordenTv.disabled = true;
                    equiposTvnumero1.disabled = true;
                    equiposTvnumero2.disabled = true;
                    equiposTvnumero3.disabled = true;
                    equiposTvnumero4.disabled = true;
                    equiposTvnumero5.disabled = true;
                    numeroLinea.disabled = true;
                    ordenLinea.disabled = true;
                    coordenadas.disabled = true;

                    break;
                case "INDIVIDUAL IPTV GPON":
                    ordenInternet.disabled = true;
                    ordenLinea.disabled = true;
                    numeroLinea.disabled = true;
                    coordenadas.disabled = true;
                    equipoModem.disabled = true;
                    nodo.disabled = true;
                    tapCaja.disabled = true;
                    posicion.disabled = true;
                    materiales.disabled = true;

                    break;
                case "INDIVIDUAL LINEA GPON":
                    ordenInternet.disabled = true;
                    ordenTv.disabled = true;
                    equiposTvnumero1.disabled = true;
                    equiposTvnumero2.disabled = true;
                    equiposTvnumero3.disabled = true;
                    equiposTvnumero4.disabled = true;
                    equiposTvnumero5.disabled = true;
                    coordenadas.disabled = true;
                    nodo.disabled = true;
                    tapCaja.disabled = true;
                    posicion.disabled = true;
                    materiales.disabled = true;

                    break;
                case "INSTALACION INTERNET ADSL":
                    ordenTv.disabled = true;
                    ordenLinea.disabled = true;
                    equiposTvnumero1.disabled = true;
                    equiposTvnumero2.disabled = true;
                    equiposTvnumero3.disabled = true;
                    equiposTvnumero4.disabled = true;
                    equiposTvnumero5.disabled = true;
                    nodo.disabled = true;
                    tapCaja.disabled = true;
                    posicion.disabled = true;
                    materiales.disabled = true;

                    hiddenSap.style.display = "none";


                    // Oculta los div del form

                    hiddenEquiposTv.style.display = "none";
                    hiddenNumeroVoip.style.display = "none";
                    hiddenElementosRed.style.display = "none";

                    break;
                case "INSTALACION LINEA COBRE":
                    ordenTv.disabled = true;
                    ordenInternet.disabled = true;
                    equiposTvnumero1.disabled = true;
                    equiposTvnumero2.disabled = true;
                    equiposTvnumero3.disabled = true;
                    equiposTvnumero4.disabled = true;
                    equiposTvnumero5.disabled = true;
                    nodo.disabled = true;
                    tapCaja.disabled = true;
                    posicion.disabled = true;
                    materiales.disabled = true;

                    hiddenEquipoModem.style.display = "none";

                    // Oculta los div del form

                    hiddenEquiposTv.style.display = "none";
                    hiddenNumeroVoip.style.display = "none";
                    hiddenElementosRed.style.display = "none";

                    break;
                case "INSTALACION TV SATELITAL DTH":
                    ordenInternet.disabled = true;
                    ordenLinea.disabled = true;
                    nodo.disabled = true;
                    tapCaja.disabled = true;
                    posicion.disabled = true;
                    materiales.disabled = true;
                    hiddenSmartcard.style.display = "block";
                    hiddenEquipoModem.style.display = "none";

                    // Oculta los div del form

                    hiddenEquiposTv.style.display = "block";
                    hiddenNumeroVoip.style.display = "none";
                    hiddenElementosRed.style.display = "none";

                    break;
                default:
                    console.warn("Tipo de orden no manejado:", tipoOrden.value);
                    break;
            }
        }
        if (tipoactividad.value === "Objetada") {
            // Itera sobre cada elemento y le aplica display: none
            elementos.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenObjetadas.style.display = "block";
            hiddenAnuladas.style.display = "none";
            hiddenTransferidas.style.display = "none";



            switch (tipoOrden.value) {
                case "Selecciona una opción":
                    // Mantener todos los campos habilitados

                    break;
                case "TRIPLE INSTALACION HFC":
                    // Mantener todos los campos habilitados
                    hiddenSmartcard.style.display = "none";
                    break;
                case "DOBLE INSTALACION TV + INTERNET HFC":
                    ordenLinea.disabled = true;

                    hiddenSmartcard.style.display = "none";
                    break;
                case "DOBLE INSTALACION INTERNET + LINEA HFC":
                    ordenTv.disabled = true;

                    hiddenSmartcard.style.display = "none";
                    break;
                case "INDIVIDUAL ANALOGO HFC":
                    ordenLinea.disabled = true;
                    ordenInternet.disabled = true;
                    hiddenSmartcard.style.display = "none";
                    break;
                case "INDIVIDUAL DIGITAL TV HFC":
                    ordenLinea.disabled = true;
                    ordenInternet.disabled = true;

                    hiddenSmartcard.style.display = "none";
                    break;
                case "INDIVIDUAL INTERNET HFC":
                    ordenTv.disabled = true;
                    ordenLinea.disabled = true;

                    hiddenSmartcard.style.display = "none";
                    break;
                case "INDIVIDUAL LINEA HFC":
                    ordenTv.disabled = true;
                    ordenInternet.disabled = true;


                    break;
                case "TRIPLE INSTALACION GPON":

                    break;
                case "DOBLE INSTALACION IPTV + LINEA GPON":
                    ordenInternet.disabled = true;
                    break;
                case "DOBLE INSTALACION INTERNET + IPTV GPON":
                    ordenLinea.disabled = true;

                    break;
                case "DOBLE INSTALACION INTERNET + LINEA GPON":
                    ordenTv.disabled = true;
                    break;
                case "INDIVIDUAL INTERNET GPON":
                    ordenLinea.disabled = true;
                    ordenTv.disabled = true;

                    break;
                case "INDIVIDUAL IPTV GPON":
                    ordenLinea.disabled = true;
                    ordenInternet.disabled = true;

                    break;
                case "INDIVIDUAL LINEA GPON":
                    ordenTv.disabled = true;
                    ordenInternet.disabled = true;

                    break;
                case "INSTALACION INTERNET ADSL":
                    ordenTv.disabled = true;
                    ordenLinea.disabled = true;

                    break;
                case "INSTALACION LINEA COBRE":
                    ordenInternet.disabled = true;
                    ordenTv.disabled = true;

                    break;
                case "INSTALACION TV SATELITAL DTH":
                    ordenLinea.disabled = true;
                    ordenInternet.disabled = true;

                    break;
                default:
                    console.warn("Tipo de orden no manejado:", tipoOrden.value);
                    break;
            }
        }
        if (tipoactividad.value === "Anulacion") {
            //  hiddenRealizadas.style.display = "none";
            hiddenObjetadas.style.display = "none";
            hiddenAnuladas.style.display = "block";
            hiddenTransferidas.style.display = "none";

            elementos.forEach(elemento => {
                elemento.style.display = 'none';
            });

            switch (tipoOrden.value) {
                case "Selecciona una opción":
                    // Mantener todos los campos habilitados

                    break;
                case "TRIPLE INSTALACION HFC":
                    // Mantener todos los campos habilitados

                    break;
                case "DOBLE INSTALACION TV + INTERNET HFC":
                    ordenLinea.disabled = true;


                    break;
                case "DOBLE INSTALACION INTERNET + LINEA HFC":
                    ordenTv.disabled = true;


                    break;
                case "INDIVIDUAL ANALOGO HFC":
                    ordenLinea.disabled = true;
                    ordenInternet.disabled = true;
                    hiddenSmartcard.style.display = "none";
                    break;
                case "INDIVIDUAL DIGITAL TV HFC":
                    ordenLinea.disabled = true;
                    ordenInternet.disabled = true;


                    break;
                case "INDIVIDUAL INTERNET HFC":
                    ordenTv.disabled = true;
                    ordenLinea.disabled = true;


                    break;
                case "INDIVIDUAL LINEA HFC":
                    ordenTv.disabled = true;
                    ordenInternet.disabled = true;


                    break;
                case "TRIPLE INSTALACION GPON":

                    break;
                case "DOBLE INSTALACION IPTV + LINEA GPON":
                    ordenInternet.disabled = true;
                    break;
                case "DOBLE INSTALACION INTERNET + IPTV GPON":
                    ordenLinea.disabled = true;

                    break;
                case "DOBLE INSTALACION INTERNET + LINEA GPON":
                    ordenTv.disabled = true;
                    break;
                case "INDIVIDUAL INTERNET GPON":
                    ordenLinea.disabled = true;
                    ordenTv.disabled = true;

                    break;
                case "INDIVIDUAL IPTV GPON":
                    ordenLinea.disabled = true;
                    ordenInternet.disabled = true;

                    break;
                case "INDIVIDUAL LINEA GPON":
                    ordenTv.disabled = true;
                    ordenInternet.disabled = true;

                    break;
                case "INSTALACION INTERNET ADSL":
                    ordenTv.disabled = true;
                    ordenLinea.disabled = true;

                    break;
                case "INSTALACION LINEA COBRE":
                    ordenInternet.disabled = true;
                    ordenTv.disabled = true;

                    break;
                case "INSTALACION TV SATELITAL DTH":
                    ordenLinea.disabled = true;
                    ordenInternet.disabled = true;

                    break;
                default:
                    console.warn("Tipo de orden no manejado:", tipoOrden.value);
                    break;
            }
        }
        if (tipoactividad.value === "Transferida") {
            //  hiddenRealizadas.style.display = "none";
            hiddenObjetadas.style.display = "none";
            hiddenAnuladas.style.display = "none";
            hiddenTransferidas.style.display = "none";
            hiddenTransferidas.style.display = "block";

            elementos.forEach(elemento => {
                elemento.style.display = 'none';
            });



            switch (tipoOrden.value) {
                case "Selecciona una opción":
                    // Mantener todos los campos habilitados

                    break;
                case "TRIPLE INSTALACION HFC":
                    // Mantener todos los campos habilitados

                    break;
                case "DOBLE INSTALACION TV + INTERNET HFC":
                    ordenLinea.disabled = true;


                    break;
                case "DOBLE INSTALACION INTERNET + LINEA HFC":
                    ordenTv.disabled = true;


                    break;
                case "INDIVIDUAL ANALOGO HFC":
                    ordenLinea.disabled = true;
                    ordenInternet.disabled = true;
                    hiddenSmartcard.style.display = "none";
                    break;
                case "INDIVIDUAL DIGITAL TV HFC":
                    ordenLinea.disabled = true;
                    ordenInternet.disabled = true;


                    break;
                case "INDIVIDUAL INTERNET HFC":
                    ordenTv.disabled = true;
                    ordenLinea.disabled = true;


                    break;
                case "INDIVIDUAL LINEA HFC":
                    ordenTv.disabled = true;
                    ordenInternet.disabled = true;


                    break;
                case "TRIPLE INSTALACION GPON":

                    break;
                case "DOBLE INSTALACION IPTV + LINEA GPON":
                    ordenInternet.disabled = true;
                    break;
                case "DOBLE INSTALACION INTERNET + IPTV GPON":
                    ordenLinea.disabled = true;

                    break;
                case "DOBLE INSTALACION INTERNET + LINEA GPON":
                    ordenTv.disabled = true;
                    break;
                case "INDIVIDUAL INTERNET GPON":
                    ordenLinea.disabled = true;
                    ordenTv.disabled = true;

                    break;
                case "INDIVIDUAL IPTV GPON":
                    ordenLinea.disabled = true;
                    ordenInternet.disabled = true;

                    break;
                case "INDIVIDUAL LINEA GPON":
                    ordenTv.disabled = true;
                    ordenInternet.disabled = true;

                    break;
                case "INSTALACION INTERNET ADSL":
                    ordenTv.disabled = true;
                    ordenLinea.disabled = true;

                    break;
                case "INSTALACION LINEA COBRE":
                    ordenInternet.disabled = true;
                    ordenTv.disabled = true;

                    break;
                case "INSTALACION TV SATELITAL DTH":
                    ordenLinea.disabled = true;
                    ordenInternet.disabled = true;

                    break;
                default:
                    console.warn("Tipo de orden no manejado:", tipoOrden.value);
                    break;
            }
        }


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
        $('input[name^="equiposTvnumero"]').val('');
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
        $('input[name^="equiposTvnumero"]').val('');
    });


    $('#instalaciones-form').on('submit', function(e) {
        e.preventDefault(); // Prevenir el envío del formulario

        // Limpiar los errores anteriores
        $('.is-invalid').removeClass('is-invalid');
        $('.is-valid').removeClass('is-valid');

        // Restaurar los placeholders originales
        $('input').each(function() {
            $(this).attr('placeholder', $(this).data('placeholder'));
        });

        // Definir los campos de orden
        let orderFields = ['ordenTv', 'ordenInternet', 'ordenLinea'];

        // Validar los campos de órdenes que están habilitados
        let hasOrderErrors = false;

        orderFields.forEach(function(field) {
            let input = $('input[name="' + field + '"]');
            let value = input.val().trim();
            let isDisabled = input.is(':disabled');

            // Solo agregar clase 'is-invalid' a campos que no están deshabilitados
            if (!isDisabled && value === '') {
                input.addClass('is-invalid');
                hasOrderErrors = true;
            }
        });

        if (hasOrderErrors) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, ingresa un numero de orden.',
                confirmButtonText: 'Aceptar'
            });
            return; // Detener el script aquí
        }

        // Obtener los datos del formulario
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