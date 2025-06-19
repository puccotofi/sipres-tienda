@extends('layouts.admin')

@section('title', 'Nueva Marca')

@section('content')
<div class="container">
    <h2 class="mb-4">Agregar nueva marca</h2>

    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
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
            <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}">
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
            <i class="fa-solid fa-plus me-2"></i>Guardar marca
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