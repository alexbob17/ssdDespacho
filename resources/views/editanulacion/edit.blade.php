@extends('adminlte::page')

@section('title', 'Editar Motivo de Anulación')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">

@section('content_header')
<h1>Editar Motivo de Anulación</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ route('editanulacion.update', $anulacion->id) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Especifica que se está usando el método PUT para actualizar -->

            <div class="form-group">
                <label for="MotivoAnulacion">Motivo de la Anulación</label>
                <input type="text" class="form-control" id="MotivoAnulacion" name="MotivoAnulacion"
                    value="{{ old('MotivoAnulacion', $anulacion->MotivoAnulacion) }}" required
                    style="text-transform:uppercase;" placeholder="Ej: ERROR EN PROCESO - SOLICITUD DEL CLIENTE">
            </div>

            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Actualizar Motivo de
                Anulación</button>
            <a href="{{ route('editanulacion.index') }}" class="btn btn-secondary">Volver</a>
        </form>
    </div>
</div>

@endsection