{{-- resources/views/auth/register.blade.php --}}
@extends('adminlte::page')

@section('title', 'Registrar Usuario')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">

@section('content_header')
<h1>Registrar Usuario</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Crear nuevo usuario</h3>
            <a href="{{ route('home') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('register') }}" method="post" id="registerForm">
            @csrf

            <!-- Nombre Completo -->
            <div class="form-group">
                <label for="name">Nombre Completo</label>
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="Nombre completo"
                        value="{{ old('name') }}" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email Corporativo</label>
                <div class="input-group">
                    <input type="email" name="email" class="form-control" placeholder="Correo electrónico"
                        value="{{ old('email') }}" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Contraseña -->
            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <div class="input-group">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                        placeholder="Confirmar Contraseña" required>
                </div>
                @if ($errors->has('password'))
                <div class="alert alert-danger">
                    Las contraseñas no coinciden. Verifica que sean iguales.
                </div>
                @endif
            </div>

            <!-- Rol -->
            <div class="form-group">
                <label for="role">Rol</label>
                <div class="input-group">
                    <select name="role" class="form-control" required>
                        <option value="" disabled selected>Selecciona un rol</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                        <option value="supervisor n1" {{ old('role') == 'supervisor n1' ? 'selected' : '' }}>Supervisor
                            N1</option>
                        <option value="supervisor n2" {{ old('role') == 'supervisor n2' ? 'selected' : '' }}>Supervisor
                            N2</option>
                        <option value="operador n1" {{ old('role') == 'operador n1' ? 'selected' : '' }}>Operador N1
                        </option>
                        <option value="operador n2" {{ old('role') == 'operador n2' ? 'selected' : '' }}>Operador N2
                        </option>
                    </select>
                </div>
                @error('role')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Botón de registrar -->
            <div class="form-group" style="display: flex; justify-content: center;">
                <button type="submit" class="btn btn-primary"
                    style="font-size: 16px !important;padding: 10px 20px !important;">
                    <i class="fas fa-save" style="padding-right: 10px;"> </i>REGISTRAR USUARIO
                </button>
            </div>
        </form>

    </div>
</div>
@stop

@section('css')
<!-- Incluir CSS de DataTables -->
<link rel="stylesheet" href="{{ asset('assets/css/dataTables_bootstrap.min.css') }}">
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/stylesssd.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/flatpickr.min.css') }}">

@stop


@section('js')
<!-- Incluyendo los CSS y JS locales desde tu carpeta de assets -->
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>


<script>
document.getElementById('registerForm').addEventListener('submit', function(event) {
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