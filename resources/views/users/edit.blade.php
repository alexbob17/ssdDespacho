@extends('adminlte::page')

@section('title', 'Editar Usuario')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">

@section('content_header')
<h1>Editar Usuario</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Editar usuario</h3>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('users.update', $user) }}" method="POST" id="updateForm">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                    required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" class="form-control"
                    value="{{ old('email', $user->email) }}" required>
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña (deja en blanco si no deseas cambiarla)</label>
                <input type="password" id="password" name="password" class="form-control"
                    placeholder="Ingresa la nueva contraseña">
                @if ($errors->has('password'))
                <div class="alert alert-danger">
                    Las contraseñas no coinciden. Verifica que sean iguales.
                </div>
                @endif
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                    placeholder="Ingresa nuevamente la nueva contraseña">
                @if ($errors->has('password'))
                <div class="alert alert-danger">
                    Las contraseñas no coinciden. Verifica que sean iguales.
                </div>
                @endif
            </div>

            <div class="form-group">
                <label for="role">Rol</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="" disabled>Selecciona un rol</option>
                    <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Administrador</option>
                    <option value="supervisor n1" {{ $user->hasRole('supervisor n1') ? 'selected' : '' }}>Supervisor N1
                    </option>
                    <option value="supervisor n2" {{ $user->hasRole('supervisor n2') ? 'selected' : '' }}>Supervisor N2
                    </option>
                    <option value="operador n1" {{ $user->hasRole('operador n1') ? 'selected' : '' }}>Operador N1
                    </option>
                    <option value="operador n2" {{ $user->hasRole('operador n2') ? 'selected' : '' }}>Operador N2
                    </option>
                </select>
                @error('role')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
        </form>

    </div>
</div>

@endsection

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

@section('js')

<script>
document.getElementById('updateForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita el envío del formulario

    const form = event.target;
    const formData = new FormData(form);

    fetch(form.action, {
            method: form.method,
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            // Limpia las clases y mensajes de error previos
            document.querySelectorAll('.is-invalid').forEach(input => {
                input.classList.remove('is-invalid');
                const feedback = input.parentElement.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.remove();
                }
            });

            if (data.errors) {
                // Mostrar errores en los placeholders y añadir clases
                Object.keys(data.errors).forEach(field => {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid'); // Añadir clase de error
                        input.placeholder = data.errors[field][0];

                        // Crear y mostrar el mensaje de error
                        const feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        feedback.textContent = data.errors[field][0];
                        if (!input.parentElement.querySelector('.invalid-feedback')) {
                            input.parentElement.appendChild(feedback);
                        }
                    }
                });

                Swal.fire({
                    title: 'Error!',
                    text: 'Por favor, corrige los errores en el formulario.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            } else if (data.success) {
                Swal.fire({
                    title: 'Éxito!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'Ok'
                }).then(() => {
                    window.location.href = '/users'; // Redirige a la página /users
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Hubo un problema al procesar la solicitud.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        });
});
</script>
@stop