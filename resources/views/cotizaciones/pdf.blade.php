<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización #{{ $cotizacion->codigo_pedido }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            padding: 0;
            font-size: 14px;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            color: #007BFF;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 2px solid #007BFF;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: #fff;
            text-align: left;
            padding: 8px;
        }
        td {
            padding: 8px;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .total-table {
            width: 100%;
            margin-top: 15px;
            border: none;
        }
        .total-table th, .total-table td {
            border: none;
            padding: 8px;
            font-size: 14px;
        }
        .total-table th {
            text-align: left;
        }
        .total-table td {
            text-align: right;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        
        <!-- Encabezado 
        <div class="header">
            <h2>ABACCOR</h2>
            <p>Email: contacto@abaccor.com | Web: https://www.abaccor.com/</p>
        </div>-->

        <!-- Detalle de Cotización -->
        <div class="section">
            <p class="section-title">Detalle de Cotización</p>
            <p><strong>Código de Pedido:</strong> {{ $cotizacion->codigo_pedido }}</p>
            <p><strong>Fecha:</strong> {{ $cotizacion->fecha }}</p>
            <p><strong>Cliente:</strong> {{ $cotizacion->cliente->nombre }}</p>
            <p><strong>Cliente:</strong> {{ $cotizacion->cliente->nombre_comercial }}</p>
            <p><strong>Total de Productos:</strong> {{ $cotizacion->productosRelacionados->count() }}</p>
        </div>
        
        <!-- Tabla de productos -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $subtotal = 0; @endphp
                @foreach ($cotizacion->productosRelacionados as $producto)
                    @php
                        $productoSubtotal = $producto->pivot->cantidad * $producto->pivot->precio_unitario;
                        $subtotal += $productoSubtotal;
                    @endphp
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->codigo }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->pivot->cantidad }}</td>
                        <td>${{ number_format($producto->pivot->precio_unitario, 2) }}</td>
                        <td>${{ number_format($productoSubtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Cálculo del total -->
        @php
            $iva = $subtotal * 0.16;  // IVA del 16%
            $total = $subtotal + $iva;
        @endphp

        <table class="total-table">
            <tr>
                <th>Subtotal</th>
                <td>${{ number_format($subtotal, 2) }}</td>
            </tr>
            <tr>
                <th>IVA (16%)</th>
                <td>${{ number_format($iva, 2) }}</td>
            </tr>
            <tr>
                <th>Total</th>
                <td>${{ number_format($total, 2) }}</td>
            </tr>
        </table>

        <!-- Pie de página -->
        <div class="footer">
            <p>Gracias por su preferencia. Si tiene preguntas, contáctenos.</p>
        </div>

    </div>

</body>
</html>
