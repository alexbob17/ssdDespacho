{{-- resources/views/auth/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Editar consultas')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">

@section('content_header')
<h1>Editar Consultas</h1>
@stop

@section('content')
<div class="card">
    <div class="d-flex justify-content-between align-items-center" style="padding: 0.9rem; padding-bottom:0 !important">
        <div class="">
            <h3 class="card-title" style="padding: 0.2rem;">Lista de Consultas</h3>
        </div>
        <div class="d-flex">
            <div class="" style="padding-right: 1rem;">
            </div>
            <div class="">
                @if (auth()->user()->hasRole(['admin', 'supervisor n2']))

                <button class="btn btn-primary" onclick="window.location.href='{{ route('editarconsultas.create') }}'">
                    <i class="fa fa-plus-circle"></i> </button>

                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <table id="consultaTable" class="table table-bordered ">
            <thead style="background-color: #343a40; color:white;">
                <tr>
                    <th>Id</th>
                    <th>Motivo Consultas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

                @foreach($consultas as $consulta)
                <tr>
                    <td>{{ $consulta->id }}</td>
                    <td>{{ $consulta->MotivoConsulta }}</td>
                    <td>

                        @if (auth()->user()->hasRole(['admin', 'supervisor n2']))

                        <a href="{{ route('editarconsultas.edit', $consulta->id) }}" class=" btn btn-dark">
                            <i class="fa fa-edit"></i> Editar
                        </a>
                        <form id="delete-consulta-form-{{ $consulta->id }}"
                            action="{{ route('editarconsultas.destroy', $consulta->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $consulta->id }})">
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
function confirmDelete(consultaId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará la consulta de forma permanente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Realizar solicitud DELETE al servidor para eliminar la consulta
            fetch(`/editarconsultas/${consultaId}`, {
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
                            'La consulta ha sido eliminada con éxito.',
                            'success'
                        ).then(() => {
                            // Recargar la página para actualizar la lista de consultas
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            'Hubo un problema al eliminar la consulta.',
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
    $('#consultaTable').DataTable({
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