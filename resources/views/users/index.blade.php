{{-- resources/views/auth/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Usuarios')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">

@section('content_header')
<h1>Usuarios <img src="vendor/img/user.png" style="width:35px;" alt=""></h1>
@stop

@section('content')
<div class="card">
    <div class="d-flex justify-content-between align-items-center" style="padding: 0.9rem; padding-bottom:0 !important">
        <div class="">
            <h3 class="card-title" style="padding: 0.2rem;">Lista de Usuarios</h3>
        </div>

        <div class="">
            @if (auth()->user()->hasRole(['admin', 'supervisor n2']))
            <button class="btn btn-primary" onclick="window.location.href='{{ route('register') }}'" style="font-size: 16px !important;
                padding: 10px 20px !important;">
                <i class="fa fa-plus-circle"></i> </button>
            @endif
        </div>
    </div>
    <div class="card-body">
        <table id="userTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th> <!-- Nueva columna para los botones de acción -->
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <!-- Muestra los roles del usuario -->
                        @foreach($user->roles as $role)
                        {{ $role->name }}@if (!$loop->last), @endif
                        @endforeach
                    </td>
                    <td style="color: #007bff;">{{ $user->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        <!-- Mostrar botones solo para admin y supervisor n2 -->
                        @if (auth()->user()->hasRole(['admin', 'supervisor n2']))
                        <!-- Botón de Editar -->
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                        <!-- Botón de Eliminar -->
                        <form id="delete-user-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}"
                            method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="confirmDelete({{ $user->id }})">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </form>

                        <!-- Botón de Resetear Contraseña -->
                        <a href="javascript:void(0);" class="btn btn-success" onclick="resetPassword({{ $user->id }})">
                            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                        </a>
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


@section('css')
<!-- Incluir CSS de DataTables -->
<link rel="stylesheet" href="{{ asset('assets/css/dataTables_bootstrap.min.css') }}">
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/css/flatpickr.min.css') }}">
@stop


@section('js')
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>


<script>
$(document).ready(function() {
    $('#userTable').DataTable({
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

<script>
function confirmDelete(userId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará al usuario de forma permanente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Hacer una solicitud DELETE al servidor para eliminar el usuario
            fetch(`/users/${userId}`, {
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
                            'El usuario ha sido eliminado con éxito.',
                            'success'
                        ).then(() => {
                            // Recargar la página para actualizar la lista de usuarios
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            'Hubo un problema al eliminar el usuario.',
                            'error'
                        );
                    }
                });
        }
    });
}

function resetPassword(userId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción restablecerá la contraseña del usuario a '12345678'.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, restablecer',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Hacer una solicitud POST al servidor para restablecer la contraseña
            fetch(`/users/${userId}/reset-password`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            '¡Restablecida!',
                            'La contraseña ha sido restablecida a "12345678".',
                            'success'
                        );
                    } else {
                        Swal.fire(
                            'Error',
                            'Hubo un problema al restablecer la contraseña.',
                            'error'
                        );
                    }
                });
        }
    });
}
</script>

@stop