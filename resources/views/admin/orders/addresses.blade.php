@extends('layouts.admin')

@section('title', 'Cambiar dirección de envío')

@section('content')

<div class="container">
    <h2 class="mb-4">Direcciones de envío de {{ $order->user->name }}</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Domicilio</th>
                <th>Ciudad</th>
                <th>Código Postal</th>
                <th>Estado</th>
                <th class="text-center">Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($addresses as $address)
                <tr>
                    <td>{{ $address->address }}</td>
                    <td>{{ $address->city }}</td>
                    <td>{{ $address->zip_code }}</td>
                    <td>{{ $address->state }}</td>
                    <td class="text-center">
                        <form method="POST" action="{{ route('admin.orders.updateShipping', [$order, $address]) }}">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-sm btn-success" type="submit">
                                <i class="fa fa-check me-1"></i> Usar esta
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No hay direcciones registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <hr class="my-4">

    <h4 class="mb-3">Registrar nueva dirección</h4>

    <form method="POST" action="{{ route('admin.orders.addresses.store', $order) }}">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Calle y número</label>
                <input type="text" name="address" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Ciudad</label>
                <input type="text" name="city" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Estado</label>
                <input type="text" name="state" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Código Postal</label>
                <input type="text" name="zip_code" class="form-control" required>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save me-1"></i> Guardar nueva dirección
            </button>
        </div>
    </form>
    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary mt-3">
        <i class="fa fa-arrow-left me-1"></i> Volver al pedido
    </a>
</div>
@endsection
