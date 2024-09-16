{{-- resources/views/auth/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Busqueda')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">

@section('content_header')
<h1>Busqueda <img src="vendor/img/busqueda.png" style="width:35px;" alt=""></h1>
@stop

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="" style="padding-top: 1rem;
    padding-left: 1rem;">
        </div>
        <div class="card-body" style="padding-top: 0 !important;">
            <div class="table-responsive">
                <table class="table table-light table-striped table-hover" id="search-table"
                    style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th>#️⃣Boleta</th>
                            <th>Hora-Fecha</th>
                            <th>CodTecnico</th>
                            <th>Nombre Tecnico</th>
                            <th>Tipo</th>
                            <th>Tipo Orden</th>
                            <th>Actividad</th>
                            <th>Orden</th>
                            <th>Status</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
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

<script>
$(document).ready(function() {
    $('#search-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("busqueda.index") }}',
        columns: [{
                data: 'boleta',
                name: 'boleta'
            },
            {
                data: 'fecha',
                name: 'fecha'
            },
            {
                data: 'codTecnico',
                name: 'codTecnico'
            },
            {
                data: 'nombre_tecnico',
                name: 'nombre_tecnico'
            },
            {
                data: 'tipo',
                name: 'tipo'
            },
            {
                data: 'tipoOrden',
                name: 'tipoOrden'
            },
            {
                data: 'tipoactividad',
                name: 'tipoactividad'
            },
            {
                data: 'orden',
                name: 'orden',

            },

            {
                data: 'status',
                name: 'status',
                render: function(data) {
                    if (data === 'Trabajado') {
                        return `<span style="color: white; font-weight: bold; background: #28a745; padding: 2px; border-radius: 3px;">${data}</span>`;
                    } else if (data === 'Pendiente') {
                        return `<span style="color: white; font-weight: bold; background: #d83044; padding: 2px; border-radius: 3px;">${data}</span>`;
                    } else {
                        return data;
                    }
                }
            },
            {
                data: 'usuario',
                name: 'usuario'
            },
            {
                data: null,
                name: 'actions',
                render: function(data, type, row) {
                    var recordType = row.tipo === 'instalaciones' ? 'instalaciones' :
                        row.tipo === 'postventas' ? 'postventas' :
                        row.tipo === 'reparaciones' ? 'reparaciones' : '';
                    return `<button class="btn btn-dark btn-sm edit-btn" data-id="${row.id}" data-type="${recordType}">
                          <i class="fas fa-edit"></i>
                        </button>`;
                },
                orderable: false,
                searchable: false
            },
            {
                data: 'ordenTv',
                name: 'ordenTv',
                visible: false,
                orderable: false,
                searchable: true
            },
            {
                data: 'ordenInternet',
                name: 'ordenInternet',
                visible: false,
                orderable: false,
                searchable: true
            },
            {
                data: 'ordenLinea',
                name: 'ordenLinea',
                visible: false,
                orderable: false,
                searchable: true
            }
        ],
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "No hay datos disponibles",
            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            oAria: {
                sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                sSortDescending: ": Activar para ordenar la columna de manera descendente"
            }
        },
        order: [
            [0, 'desc']
        ]
    });




    // Manejo del clic en el botón de editar
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        var type = $(this).data('type');

        console.log("ID: ", id); // Verifica si el ID es correcto
        console.log("Tipo: ", type); // Verifica si el tipo es correcto

        if (id && type) {
            window.location.href = `/edit/${type}/${id}`;
        } else {
            console.error("El ID o el tipo no están definidos");
        }
    });




});
</script>

@stop