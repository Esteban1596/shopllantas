<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <title>Abaccor Pos</title>
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/logo-abaccor.png') }}" alt="Logo" style="height: 40px;">
            </a>

            <!-- Botón para menú en dispositivos móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menú -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Facturación</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ventas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contabilidad</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Bancos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Reportes</a>
                    </li>
                </ul>

                <!-- Elementos de la derecha -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item me-2">
                        <button class="btn" style="background-color: #28a745; color: white;" >
                            Conexión estable <i class="fas fa-wifi"></i> 
                        </button>
                    </li>
                    <li class="nav-item me-2">
                        <button class="btn" style="background-color:rgb(0, 12, 92); color: white;">
                         Soporte <i class="fas fa-headset"></i>
                        </button>
                    </li>
                    <li class="nav-item me-2">
                        <button class="btn btn-link nav-link">
                            <i class="fas fa-bell"></i>
                        </button>
                    </li>
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @auth
                            {{ Auth::user()->name }}
                        @else
                            Invitado
                        @endauth
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Cerrar sesión</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
     
    <!-- Botones del Dashboard -->
    <div class="container mt-4 mb-2 p-2 option-table">
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
            <div class="row">
                <!-- Botón Dashboard -->
                <div class="col-3">
                    <button class="btn btn-dashboard">
                        Dashboard
                    </button>
                </div>

                <!-- Botón Analíticas -->
                <div class="col-3">
                    <button class="btn btn-analiticas">
                        Analíticas
                    </button>
                </div>

                <!-- Botón CxC -->
                <div class="col-3">
                    <button class="btn btn-cxc">
                        CxC
                    </button>
                </div>

                <!-- Botón CxP -->
                <div class="col-3">
                    <button class="btn btn-cxp">
                        CxP
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-2 mb-2 p-2">
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
            <a href="{{ route('productos.index') }}" class="btn btn-primary">Productos</a>
            <a href="{{ route('clientes.index') }}" class="btn btn-primary">Clientes</a>
            <a href="{{ route('cotizaciones.index') }}" class="btn btn-primary">Cotizaciones</a>
            <a href="{{ route('ventas.index') }}" class="btn btn-primary">Ventas</a>
     
            @if(auth()->check() && auth()->user()->isAdmin())  
            <a href="{{ route('usuarios.index') }}" class="btn btn-primary">Usuarios</a>
        @endif
           
        </div>
    </div>
    
    <!-- Contenido principal -->
    <div class="container">
        @yield('content')
    </div>

    <!-- Scripts de página -->
    @stack('scripts')

</body>

</html>
