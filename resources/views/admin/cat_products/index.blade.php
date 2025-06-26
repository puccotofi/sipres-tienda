@extends('layouts.admin')

@section('title', $title ?? 'Productos')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">{{ $title ?? 'Productos' }}</h2>
        @if (!isset($readOnly) || !$readOnly)
            <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                <i class="fa-solid fa-plus me-2"></i> Nuevo producto
            </a>
        @endif
    </div>

    <table id="crudTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Imagen</th> 
                @if ($showBrand ?? false)
                    <th>Marca</th>
                @endif
                <th>Precio</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>
                    @if ($product->image)
                        <img src="{{ full_asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            class="img-thumbnail"
                            style="width: 60px; height: auto;">
                    @else
                        <span class="text-muted">Sin imagen</span>
                    @endif
                </td>
                @if ($showBrand ?? false)
                    <td>{{ $product->brand->name ?? '-' }}</td>
                @endif
                <td>${{ number_format($product->price, 2) }}</td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary w-100" title="Editar">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <button type="button"
                            class="btn btn-sm btn-outline-danger w-100"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmDeleteModal"
                            data-action="{{ route('admin.products.destroy', $product) }}"
                            data-name="{{ $product->name }}"
                            title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

