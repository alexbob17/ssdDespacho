{{-- resources/views/auth/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Editar Motivo')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">

@section('content_header')
<h1>Editar Motivo</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('editarconsultas.update', $consulta->id) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Añadido método PUT para actualizaciones -->

            <!-- Token de seguridad CSRF -->
            <div class="form-group">
                <label for="MotivoConsulta">Motivo de la Consulta</label>
                <input type="text" class="form-control" id="MotivoConsulta" name="MotivoConsulta"
                    value="{{ old('MotivoConsulta', $consulta->MotivoConsulta) }}" required
                    style="text-transform:uppercase;" placeholder="Ej: COMPLETAR GESTION - TERMINAR PROCESO VENTA">
            </div>

            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Actualizar Consulta</button>
            <a href="{{ route('editarconsultas.index') }}" class="btn btn-secondary">Volver</a>
        </form>
    </div>
</div>

@stop