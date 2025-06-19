@extends('layouts.admin')

@section('title', 'Marcas')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Marcas registradas</h2>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-success">
            <i class="fa-solid fa-plus me-2"></i> Nueva marca
        </a>
    </div>

    <table id="crudTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Slug</th>
                <th>Ícono</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $brand)
            <tr>
                <td>{{ $brand->name }}</td>
                <td>{{ $brand->slug }}</td>
                <td>
                    @if ($brand->icon)
                        <img src="{{ full_asset('storage/' . $brand->icon) }}" alt="Ícono de marca" width="40">
                    @endif
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">
                        <a href="{{ route('admin.brands.edit', $brand) }}"
                           class="btn btn-sm btn-outline-primary w-100" title="Editar">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <button type="button"
                                class="btn btn-sm btn-outline-danger w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmDeleteModal"
                                data-action="{{ route('admin.brands.destroy', $brand) }}"
                                data-name="{{ $brand->name }}"
                                title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                        <a href="{{ route('admin.brands.products', $brand) }}"
                           class="btn btn-sm btn-outline-secondary w-100" title="Ver productos">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#brandsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
            }
        });
    });
</script>
@endsection