@extends('layouts.admin')

@section('title', 'Detalle del Pedido')

@section('content')
<div class="container">
    <h2 class="mb-4">Detalles del Pedido #{{ $order->id }}</h2>
    {{-- Usamos el sistema de Grid de Bootstrap para dividir la información en columnas --}}
    <div class="card">
        <div class="card-body">
            <div class="row">
                {{-- COLUMNA IZQUIERDA: Información del Cliente --}}
                <div class="col-md-6">
                    <h5 class="card-title mb-3">Información del Cliente</h5>
                    {{-- Las Listas de Definición son perfectas para pares de clave-valor --}}
                    <dl class="row">
                        <dt class="col-sm-4">Nombre:</dt>
                        <dd class="col-sm-8">{{ $order->user->name }}</dd>

                        <dt class="col-sm-4">Email:</dt>
                        <dd class="col-sm-8">{{ $order->user->email }}</dd>
                        
                        <dt class="col-sm-4">Teléfonos:</dt>
                        <dd class="col-sm-8">{{ $order->user->phone }} Tel2: {{ $order->user->phone2 }}</dd>

                        <dt class="col-sm-4">Dirección:</dt>
                        <dd class="col-sm-8">
                            @if ($order->shippingAddress)
                                {{ $order->shippingAddress->address }}, {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} C.P. ({{ $order->shippingAddress->zip_code }})
                            @else
                                <span class="text-muted">No disponible</span>
                            @endif
                        </dd>
                    </dl>
                </div>

                {{-- COLUMNA DERECHA: Información del Pedido --}}
                <div class="col-md-6">
                    <h5 class="card-title mb-3">Datos del Pedido</h5>
                    <dl class="row">
                        <dt class="col-sm-4">Fecha:</dt>
                        <dd class="col-sm-8">{{ $order->created_at->format('d/m/Y H:i') }}</dd>

                        <dt class="col-sm-4">Estatus:</dt>
                        <dd class="col-sm-8">
                            @php
                                // Usar 'match' (PHP 8+) es más limpio que una cadena de @if/@elseif
                                $statusClass = match($order->status) {
                                    'pendiente'  => 'bg-warning text-dark',
                                    'procesando' => 'bg-info text-dark',
                                    'enviado'     => 'bg-primary',
                                    'entregado'  => 'bg-success',
                                    'cancelado'  => 'bg-danger',
                                    default      => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </dd>
                    </dl>
                </div>
            </div>

            {{-- Separador visual antes de los botones de acción --}}
            <hr class="my-4">

            {{-- Botones de acción --}}
            <div class="d-flex flex-wrap gap-2">
                <h5 class="me-3 mb-0 align-self-center">Acciones:</h5>
                <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="fa fa-plus me-1"></i> Agregar producto
                </button>
                <a href="{{ route('admin.orders.addresses', $order) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fa fa-map-marker-alt me-1"></i> Cambiar dirección
                </a>
                <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#changeStatusModal">
                    <i class="fa fa-exchange-alt me-1"></i> Cambiar estatus
                </button>
            </div>
        </div>
    </div>

    {{-- Detalle del pedido --}}
    <div class="card">
        <div class="card-header">
            <strong>Productos del pedido</strong>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Precio Unitario</th>
                            <th class="text-end">IVA</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">${{ number_format($item->price, 2) }}</td>
                                <td class="text-end">${{ number_format($item->iva, 2) }}</td>
                                <td class="text-end">${{ number_format($item->subtotal, 2) }}</td>
                                <td class="text-center">
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal"
                                        data-action="{{ route('admin.orders.removeProduct', [$order, $item]) }}"
                                        data-name="{{ $item->product->name }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="4" class="text-end">IVA total:</th>
                            <th class="text-end">${{ number_format($order->iva, 2) }}</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th class="text-end">${{ number_format($order->total_price, 2) }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
<hr class="my-4">
<table>
    <tr>
        <td><h5>Bitácora de seguimiento</h5></td>
        <td>
            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                <i class="fa fa-sticky-note me-1"></i> Agregar nota
            </button>
        </td>
    </tr>
</table>
@if ($order->histories->isEmpty())
    <p class="text-muted">No hay registros aún.</p>
@else
    <ul class="list-group">
        @foreach ($order->histories->sortByDesc('created_at') as $history)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <strong>{{ $history->action }}</strong>
                    <div class="text-muted small">
                        {{ $history->comment ?? 'Sin comentarios' }}
                    </div>
                    <div class="text-secondary small mt-1">
                        Por {{ $history->user->name ?? 'Sistema' }} el {{ $history->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@endif
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-4">
        <i class="fa fa-arrow-left me-1"></i> Volver
    </a>
</div>

<!-- Modal: Agregar producto desde DataTable -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar producto al pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <table id="productTable" class="table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (\App\Models\Product::orderBy('name')->get() as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>${{ number_format($product->price, 2) }}</td>
                                <td class="text-center">
                                    <form action="{{ route('admin.orders.addProduct', $order) }}" method="POST" class="d-inline-flex align-items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="number" name="quantity" value="1" min="1" class="form-control form-control-sm" style="width: 70px;">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fa fa-plus"></i> Agregar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Cambiar estatus del pedido -->
<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar estatus del pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Selecciona el nuevo estatus</label>
                        <select name="status" class="form-select" required>
                            @php
                                $statuses = [
                                    'recibida' => 'Recibida',
                                    'en_cotizacion' => 'En Cotización',
                                    'cotizada' => 'Cotizada',
                                    'enviada' => 'Enviada',
                                    'entregada' => 'Entregada',
                                    'pagada' => 'Pagada',
                                    'cerrada' => 'Cerrada',
                                    'cancelada' => 'Cancelada',
                                ];
                            @endphp
                            @foreach ($statuses as $key => $label)
                                <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Actualizar estatus</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Agregar nota manual -->
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.orders.addNote', $order) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar nota de seguimiento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comentario</label>
                        <textarea name="comment" id="comment" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar nota</button>
                </div>
            </div>
        </form>
    </div>
</div>








@endsection
