{{-- resources/views/auth/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Técnicos')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">

@section('content_header')
<h1>Técnicos <img src="vendor/img/tecnicos.png" style="width:35px;" alt=""></h1>
@stop

@section('content')
<div class="card">
    <div class="d-flex justify-content-between align-items-center" style="padding: 0.9rem; padding-bottom:0 !important">
        <div class="">
            <h3 class="card-title" style="padding: 0.2rem;">Lista de Técnicos</h3>
        </div>
        <div class="d-flex">
            <div class="" style="padding-right: 1rem;">
                <a href="{{ route('tecnicos.export') }}" class="btn btn-success mb-3">
                    <i class="fas fa-file-excel"></i> Descargar Excel
                </a>
            </div>
            <div class="">
                @if (auth()->user()->hasRole(['admin', 'supervisor n2']))
                <button class="btn btn-primary" onclick="window.location.href='{{ route('tecnicos.create') }}'" style="font-size: 16px !important;
    padding: 10px 20px !important;">
                    <i class="fa fa-plus-circle"></i> </button>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <table id="tecnicoTable" class="table table-bordered ">
            <thead style="background-color: #343a40; color:white;">
                <tr>
                    <th>Nombre Técnico</th>
                    <th>Código</th>
                    <th>Número</th>
                    <th>Cédula</th>
                    <th>Status</th>
                    <th>Fecha creacion</th>
                    <th>Ultima actualizacion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tecnicos as $tecnico)
                <tr>
                    <td>{{ $tecnico->nombre_tecnico }}</td>
                    <td>{{ $tecnico->codigo }}</td>
                    <td>{{ $tecnico->numero }}</td>
                    <td>{{ $tecnico->cedula }}</td>

                    <td>
                        <span
                            class="btn btn-{{ $tecnico->status == 'Activo' ? 'success' : 'danger' }} btn-sm text-white">
                            {{ $tecnico->status }}
                        </span>
                    </td>
                    <td>{{ $tecnico->created_at->format('d/m/Y') }}</td>
                    <td>{{ $tecnico->updated_at->format('d/m/Y') }}</td>
                    <td>
                        @if (auth()->user()->hasRole(['admin', 'supervisor n2']))

                        <a href="{{ route('tecnicos.edit', $tecnico->id) }}" class="btn btn-dark"><i
                                class="fas fa-edit"></i> </a>


                        <form id="delete-tecnico-form-{{ $tecnico->id }}"
                            action="{{ route('tecnicos.destroy', $tecnico->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')

                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $tecnico->id }})">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        @else

                        Sin Acceso ⛔

                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="card-footer">

        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(tecnicoId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará al técnico de forma permanente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Realizar solicitud DELETE al servidor para eliminar el técnico
            fetch(`/tecnicos/${tecnicoId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            '¡Eliminado!',
                            'El técnico ha sido eliminado con éxito.',
                            'success'
                        ).then(() => {
                            // Recargar la página para actualizar la lista de técnicos
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            'Hubo un problema al eliminar el técnico.',
                            'error'
                        );
                    }
                })
                .catch(error => {
                    Swal.fire(
                        'Error',
                        'Hubo un problema al procesar la solicitud.',
                        'error'
                    );
                });
        }
    });
}
</script>

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


@stop


@section('css')
<!-- Incluir CSS de DataTables -->
<link rel="stylesheet" href="{{ asset('assets/css/dataTables_bootstrap.min.css') }}">
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />

@stop


@section('js')
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>




<script>
$(document).ready(function() {
    $('#tecnicoTable').DataTable({
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
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
        }
    });



});
</script>

@stop