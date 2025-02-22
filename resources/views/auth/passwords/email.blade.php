@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Recuperar Contraseña</h3>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="email">Correo Electrónico</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="email">
    </div>
    <button type="submit" class="btn btn-primary">Enviar enlace de recuperación</button>
</form>

</div>
@endsection
