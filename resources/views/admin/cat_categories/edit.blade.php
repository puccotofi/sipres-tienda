@extends('layouts.admin')

@section('title', 'Editar Categoría')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar categoría</h2>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $category->name) }}">
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $category->slug) }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="icon" class="form-label">Ícono / Imagen</label>
            @if ($category->icon)
                <div class="mb-2">
                    <img src="{{ full_asset('storage/' . $category->icon) }}" alt="Icono actual" width="200">
                </div>
            @endif
            <input class="form-control" type="file" id="icon" name="icon" accept="image/*">
            <small class="text-muted">Si cargas una nueva imagen, reemplazará la existente.</small>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-save me-2"></i>Guardar cambios
        </button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('name').addEventListener('input', function () {
        const slug = this.value.toLowerCase()
            .trim()
            .replace(/[\s\-]+/g, '-')
            .replace(/[^\w\-]+/g, '');
        document.getElementById('slug').value = slug;
    });
</script>
@endsection