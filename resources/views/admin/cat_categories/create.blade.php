@extends('layouts.admin')

@section('title', 'Nueva Categoría')

@section('content')
<div class="container">
    <h2 class="mb-4">Agregar nueva categoría</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}">
            @error('slug')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="icon" class="form-label">Ícono / Imagen</label>
            <input class="form-control" type="file" id="icon" name="icon" accept="image/*">
            @error('icon')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fa-solid fa-plus me-2"></i>Guardar categoría
        </button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Opcional: generar el slug automáticamente a partir del nombre
    document.getElementById('name').addEventListener('input', function () {
        const slug = this.value.toLowerCase()
                               .trim()
                               .replace(/[\s\-]+/g, '-')
                               .replace(/[^\w\-]+/g, '');
        document.getElementById('slug').value = slug;
    });
</script>
@endsection