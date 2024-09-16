@extends('adminlte::auth.login')

@section('title', 'Inicio Sesion Web // Despacho')
<link rel="icon" href="{{ asset('img/Claro.svg.png') }}" type="image/x-icon">

@section('auth_body')


<form action="{{ route('login') }}" method="post" id="login-form'">
    @csrf

    <div class="input-group mb-3">
        <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="input-group mb-3">
        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
</form>

@endsection('auth_body')

@section('css')
<!-- Incluir CSS de DataTables -->
<link rel="stylesheet" href="{{ asset('assets/css/dataTables_bootstrap.min.css') }}">
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />


<style>
.card-footer.text-center p {
    display: none;
}

.login-logo img:first-of-type {
    display: none;
}

body {
    background: #1f2d3d !important;
}
</style>
@stop

@section('js')


<script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Encuentra el elemento que contiene el texto que quieres cambiar
    const titleElement = document.querySelector('.card-title.float-none.text-center');
    if (titleElement) {
        // Cambia el texto al que desees
        titleElement.textContent = 'Comenzar Sesión';
    }
});

document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita que el formulario se envíe automáticamente

    // Obtener los valores de los campos
    let email = document.getElementById('email').value.trim();
    let password = document.getElementById('password').value.trim();

    // Validar si el email y password están vacíos
    if (email === '' || password === '') {
        Swal.fire({
            title: 'Error',
            text: 'Todos los campos son obligatorios.',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
        return; // Evitar el envío del formulario
    }

    // Validar si el formato de email es correcto
    let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailPattern.test(email)) {
        Swal.fire({
            title: 'Error',
            text: 'Por favor, ingresa un correo electrónico válido.',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
        return; // Evitar el envío del formulario
    }

    // Validar si la contraseña tiene al menos 6 caracteres
    if (password.length < 6) {
        Swal.fire({
            title: 'Error',
            text: 'La contraseña debe tener al menos 6 caracteres.',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
        return; // Evitar el envío del formulario
    }

    // Si todo está bien, enviar el formulario
    this.submit(); // Esto enviará el formulario al servidor
});
</script>



@stop