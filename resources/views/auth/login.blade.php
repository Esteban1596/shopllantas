<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<form action="{{ route('login.submit') }}" method="POST" class="p-4 border rounded shadow bg-white" autocomplete="off" style="max-width: 400px; margin: auto;">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="email">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" name="password" class="form-control" required autocomplete="new-password">
    </div>
    
    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
</form>
