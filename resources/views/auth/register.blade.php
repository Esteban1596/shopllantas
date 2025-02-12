<form action="{{ route('register.submit') }}" method="POST">
    @csrf
    <div>
        <label for="name">Nombre</label>
        <input type="text" name="name" value="{{ old('name') }}" required>
    </div>
    <div>
        <label for="email">Correo Electrónico</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div>
        <label for="password">Contraseña</label>
        <input type="password" name="password" required>
    </div>
    <div>
        <label for="password_confirmation">Confirmar Contraseña</label>
        <input type="password" name="password_confirmation" required>
    </div>
    <button type="submit">Registrar</button>
</form>
