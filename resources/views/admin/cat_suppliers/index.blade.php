@extends('layouts.admin')

@section('title', 'Proveedores')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Listado de Proveedores</h2>
        <a href="{{ route('admin.suppliers.create') }}" class="btn btn-success">
            <i class="fa-solid fa-plus me-2"></i> Nuevo proveedor
        </a>
    </div>

    <table id="crudTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Contacto</th>
                <th>Teléfono</th>
                <th>Teléfono 2</th>
                <th>Email</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->contact_name }}</td>
                    <td>{{ $supplier->phone }}</td>
                    <td>{{ $supplier->phone2 }}</td>
                    <td>{{ $supplier->email }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('admin.suppliers.products', $supplier) }}"
                            class="btn btn-sm btn-outline-secondary w-100"
                            title="Ver productos">
                            <i class="fa-solid fa-boxes-stacked"></i>
                            </a>

                            <a href="{{ route('admin.suppliers.edit', $supplier) }}"
                            class="btn btn-sm btn-outline-primary w-100"
                            title="Editar">
                            <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <button type="button"
                                class="btn btn-sm btn-outline-danger w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmDeleteModal"
                                data-action="{{ route('admin.suppliers.destroy', $supplier) }}"
                                data-name="{{ $supplier->name }}"
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
