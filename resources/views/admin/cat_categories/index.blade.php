@extends('layouts.admin')
@section('title', 'Categorías')

@section('content')
 <div class="d-flex justify-content-between mb-3">
    <h2>Categorías</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Nueva categoría</a>
</div>
<table id="crudTable" class="datatable table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Slug</th>
            <th>Icono</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>
                    @if($category->icon)
                        <img src="{{ full_asset('storage/' . $category->icon) }}" alt="icon" width="100">
                    @endif
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">
                        <!-- Botón de editar -->
                        <a href="{{ route('admin.categories.edit', $category) }}"
                        class="btn btn-sm btn-outline-primary w-100"
                        title="Editar">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <!-- Botón de eliminar -->
                        <button type="button"
                                class="btn btn-sm btn-outline-danger w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmDeleteModal"
                                data-action="{{ route('admin.categories.destroy', $category) }}"
                                data-name="{{ $category->name }}"
                                title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal de confirmación -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" id="deleteForm">
        @csrf
        @method('DELETE')
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Eliminar categoría</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar la categoría <strong id="categoryName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Sí, eliminar</button>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection
