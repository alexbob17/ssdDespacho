{{-- resources/views/auth/register.blade.php --}}
@extends('adminlte::page')

@section('title', 'Editar tecnico')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">

@section('content_header')
<h1>Editar Tecnico </h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Editar Técnico</h3>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('tecnicos.update', $tecnico->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre_tecnico" class="form-label">Nombre Técnico</label>
                <div class="input-group">
                    <input type="text" name="nombre_tecnico" id="nombre_tecnico" class="form-control"
                        placeholder="Contrata y nombre de técnico"
                        value="{{ old('nombre_tecnico', $tecnico->nombre_tecnico) }}" required
                        style="text-transform: uppercase;">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                @error('nombre_tecnico')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="codigo" class="form-label">Código</label>
                <div class="input-group">
                    <input type="text" name="codigo" id="codigo" class="form-control"
                        placeholder="Ej: TMANAC245,V69,ETC..." value="{{ old('codigo', $tecnico->codigo) }}" required
                        style="text-transform: uppercase;">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-barcode"></span>
                        </div>
                    </div>
                </div>
                @error('codigo')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror

            </div>

            <div class="mb-3">
                <label for="numero" class="form-label">Número</label>
                <div class="input-group">
                    <input type="text" name="numero" id="numero" class="form-control"
                        placeholder="Para registrar agentes de despacho, los números deben ser uno de los siguientes: MANAGUA, LEON, DESPACHO, CLARO."
                        value="{{ old('numero', $tecnico->numero) }}" required style="text-transform: uppercase;">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone"></span>
                        </div>
                    </div>
                </div>
                @error('numero')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cedula" class="form-label">Cédula</label>
                <div class="input-group">
                    <input type="text" name="cedula" id="cedula" class="form-control"
                        placeholder="Cédula sin espacios, símbolos o caracteres especiales"
                        value="{{ old('cedula', $tecnico->cedula) }}" style="text-transform: uppercase;">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-id-card"></span>
                        </div>
                    </div>
                </div>
                @error('cedula')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="status" class="form-label">Status</label>
                <div class="d-flex align-items-center" style="font-size:20px;">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="statusActivo" value="Activo"
                            {{ old('status', $tecnico->status) == 'Activo' ? 'checked' : '' }}>
                        <label class="form-check-label badge bg-success text-white" for="statusActivo">Activo</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="statusDesactivo" value="Inactivo"
                            {{ old('status', $tecnico->status) == 'Inactivo' ? 'checked' : '' }}>
                        <label class="form-check-label badge bg-danger text-white"
                            for="statusDesactivo">Inactivo</label>
                    </div>

                    @error('status')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i> Actualizar Técnico
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection