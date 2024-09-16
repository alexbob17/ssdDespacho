@extends('adminlte::page')

@section('title', 'Cambiar contraseña')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">

@section('content_header')
<h1>Cambiar contraseña</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="container">

            <form id="changePasswordForm" action="{{ route('profile.update-password') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="current_password">Contraseña Actual</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i> <!-- Icono de candado -->
                            </span>
                        </div>
                        <input type="password" id="current_password" name="current_password" class="form-control"
                            placeholder="Ingresa tu contraseña actual" required>
                    </div>
                    @error('current_password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new_password">Nueva Contraseña</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i> <!-- Icono de candado -->
                            </span>
                        </div>
                        <input type="password" id="new_password" name="new_password" class="form-control"
                            placeholder="Ingresa tu nueva contraseña" required>
                    </div>
                    @error('new_password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">Confirmar Nueva Contraseña</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i> <!-- Icono de candado -->
                            </span>
                        </div>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                            class="form-control" placeholder="Confirma tu nueva contraseña" required>
                    </div>
                    @error('new_password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
            </form>



            <form action="{{ route('profile.reset-password') }}" method="POST" style="margin-top: 20px;">
                @csrf
                <button type="submit" class="btn btn-dark">Resetear Contraseña a :12345678</button>
            </form>
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
<!-- Incluyendo los CSS y JS locales desde tu carpeta de assets -->
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />

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

@if(session('errormsg'))
<script>
Swal.fire({
    title: '¡Error!',
    text: "{{ session('errormsg') }}",
    icon: 'error',
    confirmButtonText: 'OK'
});
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Evita el envío del formulario

        const form = event.target;
        const formData = new FormData(form);

        fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
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
                    // Mostrar errores en los campos y añadir clases
                    Object.keys(data.errors).forEach(field => {
                        const input = document.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('is-invalid'); // Añadir clase de error

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
                        window.location.href = '/home'; // Redirige a la página /home
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
});
</script>

@stop