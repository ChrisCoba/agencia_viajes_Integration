@extends('layouts.main')

@section('title', 'Login')

@section('content')
<div class="container mt-5">
    <h2>Iniciar Sesión</h2>
    <form id="loginForm">
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
    </form>
</div>

<script>
    import { login } from '/js/services.js';

    document.getElementById('loginForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        try {
            const response = await login(email, password);
            if (response.success) {
                alert('Inicio de sesión exitoso');
                window.location.href = '/';
            } else {
                alert('Error: ' + response.message);
            }
        } catch (error) {
            console.error('Error al iniciar sesión:', error);
            alert('Ocurrió un error. Inténtalo de nuevo.');
        }
    });
</script>
@endsection