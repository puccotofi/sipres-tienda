@extends('layouts.admin')

@section('title', 'Editar Marca')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar marca</h2>

    <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $brand->name) }}">
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $brand->slug) }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $brand->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="icon" class="form-label">Ícono / Imagen</label>
            @if ($brand->icon)
                <div class="mb-2">
                    <img src="{{ full_asset('storage/' . $brand->icon) }}" alt="Ícono actual" style="max-width: 200px;">
                </div>
            @endif
            <input class="form-control" type="file" id="icon" name="icon" accept="image/*">
            <small class="text-muted">Sube una nueva imagen solo si deseas reemplazar la actual.</small>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-save me-2"></i>Guardar cambios
        </button>
        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Cancelar</a>
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