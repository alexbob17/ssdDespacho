<!-- resources/views/instalaciones/create.blade.php -->
{{-- resources/views/auth/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Editar Instalaciones')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">

@section('content_header')
<h1>Editar Instalaciones</h1>
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
        <form action="{{ route('instalaciones.update', ['id' => $record->id]) }}" method="POST" id="instalaciones-form">
            @csrf
            @method('PUT')
            <div class="form-group-container form-row">
                <div class="form-group col-md-4">
                    <label for="codigo">Código Técnico</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="text" name="codigo" id="codigo" class="form-control form-control-uppercase"
                            placeholder="Código Técnico 🆔" value="{{ old('codigo', $record->codigo) }}" readonly>
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
                            placeholder="Número 🔢" value="{{ old('numero', $record->numero) }}" readonly>
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
                            value="{{ old('nombre_tecnico', $record->nombre_tecnico) }}" readonly>
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
                        </option>
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
                    <label for="depto">DPTO / COLONIA</label>
                    <select name="depto" id="depto" class="form-control select2 js-example-theme-single" required>
                        <option value="" class="form-control-uppercase">Selecciona una opción</option>
                        @foreach($dptos as $dpto)
                        <option value="{{ $dpto->id }}" {{ $record->depto == $dpto->id ? 'selected' : '' }}>
                            {{ $dpto->depto }} - {{ $dpto->colonia }}
                        </option>
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
                        <input type="text" name="ordenTv" id="ordenTv" class="form-control form-control-uppercase"
                            placeholder="Número Orden" value="{{ old('ordenTv', $record->ordenTv) }}">
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
                        <input type="text" name="ordenInternet" id="ordenInternet"
                            class="form-control form-control-uppercase" placeholder="Número Orden"
                            value="{{ old('ordenInternet', $record->ordenInternet) }}">
                    </div>
                    @error('ordenInternet')
                    <div class=" text-danger">{{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="ordenLinea">Orden Línea</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                        </div>
                        <input type="text" name="ordenLinea" id="ordenLinea" class="form-control form-control-uppercase"
                            placeholder="Número Orden" value="{{ old('ordenLinea', $record->ordenLinea) }}">
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
                                class="form-control form-control-uppercase" placeholder="Equipos Tv 1 "
                                value="{{ old('equiposTvnumero1', $record->equiposTvnumero1) }}">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tv"></i></span>
                            </div>
                            <input type="text" name="equiposTvnumero2" id="equiposTvnumero2"
                                class="form-control form-control-uppercase" placeholder="Equipos Tv 2 "
                                value="{{ old('equiposTvnumero2', $record->equiposTvnumero2) }}">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tv"></i></span>
                            </div>
                            <input type="text" name="equiposTvnumero3" id="equiposTvnumero3"
                                class="form-control form-control-uppercase" placeholder="Equipos Tv 3 "
                                value="{{ old('equiposTvnumero3', $record->equiposTvnumero3) }}">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tv"></i></span>
                            </div>
                            <input type="text" name="equiposTvnumero4" id="equiposTvnumero4"
                                class="form-control form-control-uppercase" placeholder="Equipos Tv 4 "
                                value="{{ old('equiposTvnumero4', $record->equiposTvnumero4) }}">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tv"></i></span>
                            </div>
                            <input type="text" name="equiposTvnumero5" id="equiposTvnumero5"
                                class="form-control form-control-uppercase" placeholder="Equipos Tv 5 "
                                value="{{ old('equiposTvnumero5', $record->equiposTvnumero5) }}">
                        </div>
                    </div>

                    <div class="form-group col-md-3 " id="hiddenSmartcard" style="display:none;">
                        <label for="smartcardnumero1">SmartCard 💳</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            </div>
                            <input type="number" name="smartcardnumero1" id="smartcardnumero1"
                                class="form-control form-control-uppercase" placeholder="SmartCard 1 "
                                value="{{ old('smartcardnumero1', $record->smartcardnumero1) }}">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            </div>
                            <input type="number" name="smartcardnumero2" id="smartcardnumero2"
                                class="form-control form-control-uppercase" placeholder="SmartCard 2"
                                value="{{ old('smartcardnumero2', $record->smartcardnumero2) }}">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            </div>
                            <input type="number" name="smartcardnumero3" id="smartcardnumero3"
                                class="form-control form-control-uppercase" placeholder="SmartCard 3 "
                                value="{{ old('smartcardnumero3', $record->smartcardnumero3) }}">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            </div>
                            <input type="number" name="smartcardnumero4" id="smartcardnumero4"
                                class="form-control form-control-uppercase" placeholder="SmartCard 4"
                                value="{{ old('smartcardnumero4', $record->smartcardnumero4) }}">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                            </div>
                            <input type="number" name="smartcardnumero5" id="smartcardnumero5"
                                class="form-control form-control-uppercase" placeholder="SmartCard 5 "
                                value="{{ old('smartcardnumero5', $record->smartcardnumero5) }}">
                        </div>
                    </div>

                    <div class="form-group col-md-4 hiddenDiv" id="hiddenEquipoModem">
                        <label for="equipoModem">Equipo Modem</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-wifi"></i></span>
                            </div>
                            <input type="text" name="equipoModem" id="equipoModem"
                                class="form-control form-control-uppercase" placeholder="Equipo Modem 🌐"
                                value="{{ old('equipoModem', $record->equipoModem) }}">
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
                                class="form-control form-control-uppercase" placeholder="Número Voip"
                                value="{{ old('numeroLinea', $record->numeroLinea) }}">
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
                                placeholder="SAP" value="{{ old('sap', $record->sap) }}">
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
                                class="form-control form-control-uppercase" placeholder="Coordenadas 📍"
                                value="{{ old('coordenadas', $record->coordenadas) }}">
                        </div>
                        @error('coordenadas')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

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
                                    value="{{ old('observaciones', $record->observaciones) }}">
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
                                    placeholder="Nombre de quien recibe " value="{{ old('recibe', $record->recibe) }}">
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
                                    placeholder="Ingrese el nodo" value="{{ old('nodo', $record->nodo) }}">
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
                                    value="{{ old('tapCaja', $record->tapCaja) }}">
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
                                    placeholder="Ingrese la posición o Puerto"
                                    value="{{ old('posicion', $record->posicion) }}">
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
                                    value="{{ old('materiales', $record->materiales) }}">
                            </div>
                            @error('materiales')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>



                    </div>
                </div>
            </div>

            <div id="hiddenObjetadas" style="">
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
                        <label for="ObservacionesObj">Observaciones</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                            </div>
                            <input type="text" name="ObservacionesObj" id="ObservacionesObj"
                                class="form-control form-control-uppercase" placeholder="Ingrese los Observaciones"
                                value="{{ old('ObservacionesObj', $record->ObservacionesObj) }}">
                        </div>
                        @error('ObservacionesObj')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div id="hiddenAnuladas">
                <div class="form-group-container">
                    <div class="form-group col-md-4">
                        <select name="motivoAnulada" id="motivoAnulada"
                            class="form-control select2 js-example-theme-single">
                            @foreach($anulacion as $item)
                            <option value="{{ $item->id }}" {{ $record->motivoAnulada == $item->id ? 'selected' : '' }}>
                                {{ $item->MotivoAnulacion }}
                            </option>
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
                                value="{{ old('ObservacionesAnuladas', $record->ObservacionesAnuladas) }}">
                        </div>
                        @error('ObservacionesAnuladas')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div id="hiddenTransferidas">
                <div class="form-group-container">
                    <div class="form-group col-md-12">
                        <label for="motivoTransferido">Motivo Transferido</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                            </div>
                            <input type="text" name="motivoTransferido" id="motivoTransferido"
                                class="form-control form-control-uppercase" placeholder="Ingrese el motivo"
                                value="{{ old('motivoTransferido', $record->motivoTransferido) }}">
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
                                value="{{ old('ObservacionesTransferido', $record->ObservacionesTransferido) }}">
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


<script>
$(document).ready(function() {

    //$('#tipoactividad').on('change', toggleFields);

    function toggleFields() {

        // Selecciona todos los elementos con la clase 'mi-clase'
        const elementos = document.querySelectorAll('.hiddenDiv');


        console.log("Cambio detectado en tipo de actividad u orden");

        // Limpiar los valores de los campos

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
            // Itera sobre cada elemento y le aplica display: none
            elementos.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenObjetadas.style.display = "none";
            hiddenAnuladas.style.display = "block";
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
        if (tipoactividad.value === "Transferida") {
            // Itera sobre cada elemento y le aplica display: none
            elementos.forEach(elemento => {
                elemento.style.display = 'none';
            });
            hiddenObjetadas.style.display = "none";
            hiddenAnuladas.style.display = "none";
            hiddenTransferidas.style.display = "block";
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

    }

    toggleFields($('#tipoOrden').val());

    // Ejecutar la función cada vez que cambie el valor de tipoOrden
    $('#tipoOrden').on('change', function() {
        toggleFields($(this).val());
    });

    $('#tipoactividad').on('change', function() {
        toggleFields($(this).val());
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
                text: 'Por favor, ingresa un número de orden.',
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