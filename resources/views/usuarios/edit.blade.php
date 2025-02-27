@extends('layouts.app')

@section('content')
@if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
<div class="container mt-2 mb-2 p-2">
    <h2>Editar Usuario</h2>
    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $usuario->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', $usuario->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Rol</label>
            <select class="form-control" name="role" required>
                <option value="admin" {{ $usuario->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="user" {{ $usuario->role === 'user' ? 'selected' : '' }}>Usuario</option>
            </select>
        </div>

        <div class="mb-3 position-relative">
            <label for="password" class="form-label">Contraseña (dejar en blanco si no deseas cambiarla)</label>
            <div class="input-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="Nueva contraseña">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password', 'togglePasswordIcon')">
                    <i id="togglePasswordIcon" class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <div class="mb-3 position-relative">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <div class="input-group">
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirmar nueva contraseña">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation', 'toggleConfirmPasswordIcon')">
                    <i id="toggleConfirmPasswordIcon" class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
<script>
    function togglePassword(fieldId, iconId) {
        let passwordField = document.getElementById(fieldId);
        let icon = document.getElementById(iconId);
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
@endsection
