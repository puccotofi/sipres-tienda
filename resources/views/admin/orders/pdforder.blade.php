<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedido #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 2em;
            color: #333;
        }
        .container {
            border: 1px solid #ccc;
            border-radius: 12px;
            padding: .5em;
        }
        .logo {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo img {
            height: 40px;
        }
        .section {
            margin-bottom: 1.5em;
        }
        .section h3 {
            margin-bottom: 0.5em;
            border-bottom: 0px solid #ccc;
            padding-bottom: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0em;
            border-radius: 12px;
        }
        
        
        .right {
            text-align: right;
        }
        /*
         1. Creamos un contenedor para simular el "card" y darle las esquinas redondeadas.
            Aplicar border-radius directamente a una tabla es inconsistente en dompdf.
            Este método es mucho más fiable.
        */
        .info-container {
            border: 1px solid #dee2e6; /* Un borde gris claro */
            border-radius: 8px;      /* Las esquinas redondeadas */
            padding: 1px;            /* Un pequeño padding para que el borde no se pegue a la tabla */
            overflow: hidden;        /* Importante para que la tabla respete el borde redondeado */
        }
        /* 2. Estilos para nuestra tabla HTML pura */
        .info-table {
            width: 100%;
            border-collapse: collapse; /* Une los bordes de las celdas */
        }
        .info-table td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6; /* Línea separadora entre filas */
            vertical-align: top;
        }
        /* Estilo para la última fila, para que no tenga borde inferior */
        .info-table tr:last-child td {
            border-bottom: none;
        }
        /* 3. Estilo para la celda de la etiqueta (el antiguo dt) */
        .info-table .label-cell {
            font-weight: bold;
            text-align: right;
             /*width: 150px; Ancho fijo para una alineación perfecta */
            background-color: #f8f9fa; /* Un fondo sutil para diferenciarla */
        }
        .text-muted {
            color: #6c757d;
        }
    </style>
</head>
<body>
<div class="container">
    <table  style="width: 100%; border: none;">
        <tr>
            <td style="width: 30%;">
                <div class="info-container">
                    <table class="info-table">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="logo">
                    
                                        <img src="{{ public_path('assets/images/logo/mueblelogo.png') }}" alt="Logo">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Pedido # {{ $order->id }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Estatus:  {{ ucfirst($order->status) }} <br>
                                    Fecha del Pedido:{{ $order->created_at->format('d/m/Y') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </td>
            <td style="width: 70%;">
                <div class="info-container">
                    <table class="info-table">
                        <tbody>
                            <tr>
                                {{-- Columna para el valor (antes dd) --}}
                                <td class="label-cell">Nombre:</td>
                                {{-- Columna para la etiqueta (antes dt) --}}
                                <td>{{ $order->user->name }}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">Email:</td>
                                <td>{{ $order->user->email }}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">Teléfonos:</td>
                                <td>{{ $order->user->phone }} / {{ $order->user->phone2 }}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">Dirección:</td>
                                <td>
                                    @if ($order->shippingAddress)
                                        {{ $order->shippingAddress->address }}, {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}
                                        <br>
                                        <span class="text-muted">C.P. {{ $order->shippingAddress->zip_code }}</span>
                                    @else
                                        <span class="text-muted">No disponible</span>
                                    @endif
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    
    
    <div class="section">
       
        <table style="width: 100%; border: 1px; margin-top: 1em;  ">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th class="right">Cantidad</th>
                    <th class="right">Precio Unitario</th>
                    <th class="right">IVA</th>
                    <th class="right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalCantidad = 0;
                    $totalPrecio = 0;
                    $totaliva = 0;
                    $total = 0;
                @endphp
                {{-- Recorremos los items del pedido --}}
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td class="right">{{ $item->quantity }}</td>
                        <td class="right">${{ number_format($item->price, 2) }}</td>
                        <td class="right">${{ number_format($item->iva, 2) }}</td>
                        <td class="right">${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @php
                        $totalCantidad += $item->quantity;
                        $totalPrecio += $item->price * $item->quantity;
                        $totaliva += $item->iva * $item->quantity;
                        $total += $item->subtotal;
                    @endphp
                @endforeach
                <tr>
                    <td colspan="5" style="border-top: 2px solid #000;"></td>
                </tr>
                <tr style="font-weight: bold; background-color: #f2f2f2;">
                    <th class="right">Totales:</th>
                    <th class="right">{{ $totalCantidad }}</th>
                    <th class="right">${{ number_format($totalPrecio, 2) }}</th>
                    <th class="right">${{ number_format($totaliva, 2) }}</th>
                    <th class="right">${{ number_format($total, 2) }}</th>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>
<div style="position: fixed; bottom: 20px; left: 0; right: 0; text-align: center; font-size: 10px; color: #888;">
    Impreso el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    por {{ auth()->user()->name ?? 'Usuario no identificado' }}
</div>
</body>
</html>
