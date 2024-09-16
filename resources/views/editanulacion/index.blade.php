{{-- resources/views/auth/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Motivos Anulación')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">


@section('content_header')
<h1>Lista de Anulación</h1>
@stop

@section('content')

<div class="card">
    <div class="d-flex justify-content-between align-items-center" style="padding: 0.9rem; padding-bottom:0 !important">
        <div class="">
            <h3 class="card-title" style="padding: 0.2rem;">Anulaciones</h3>
        </div>
        <div class="d-flex">
            <div class="" style="padding-right: 1rem;">
            </div>
            <div class="">
                @if (auth()->user()->hasRole(['admin', 'supervisor n2']))

                <button class="btn btn-primary" onclick="window.location.href='{{ route('editanulacion.create') }}'">
                    <i class="fa fa-plus-circle"></i> </button>

                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <table id="anulacionTable" class="table table-bordered">
            <thead style="background-color: #343a40; color:white;">
                <tr>
                    <th>ID</th>
                    <th>Motivo Anulación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($anulacion as $anulaciones)
                <tr>
                    <td>{{ $anulaciones->id }}</td>
                    <td>{{ $anulaciones->MotivoAnulacion }}</td>
                    <td>
                        @if (auth()->user()->hasRole(['admin', 'supervisor n2']))
                        <a href="{{ route('editanulacion.edit', $anulaciones->id) }}" class="btn btn-dark">
                            <i class="fa fa-edit"></i> Editar
                        </a>
                        <form id="delete-anulacion-form-{{ $anulaciones->id }}"
                            action="{{ route('editanulacion.destroy', $anulaciones->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger"
                                onclick="confirmDelete({{ $anulaciones->id }})">
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
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>


<script>
function confirmDelete(anulacionId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará la anulación de forma permanente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Realizar solicitud DELETE al servidor para eliminar la anulación
            fetch(`/editanulacion/${anulacionId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            '¡Eliminado!',
                            'La anulación ha sido eliminada con éxito.',
                            'success'
                        ).then(() => {
                            // Recargar la página para actualizar la lista de anulaciones
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            'Hubo un problema al eliminar la anulación.',
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


<!-- Incluir JS de DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    $('#anulacionTable').DataTable({
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