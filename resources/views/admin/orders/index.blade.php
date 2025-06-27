@extends('layouts.admin')

@section('title', 'Pedidos')

@section('content')
<div class="container">
    <h2 class="mb-4">Listado de Pedidos</h2>

    <table id="crudTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th># Pedido</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>IVA</th>
                <th>Estado</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td>${{ number_format($order->iva, 2) }}</td>
                    <td>{{ ucfirst($order->status ?? 'pendiente') }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
