@extends('layouts.admin')

@section('title', 'Editar Producto')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar producto</h2>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $product->name) }}">
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $product->slug) }}">
        </div>

        <div class="mb-3">
            <label for="brand_id" class="form-label">Marca</label>
            <select name="brand_id" class="form-select" required>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Categoría</label>
            <select name="category_id" class="form-select" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="suppliers" class="form-label">Proveedores</label>
            <select name="suppliers[]" id="suppliers" class="form-select" multiple>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}"
                        {{ $product->suppliers->contains($supplier->id) ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Usa Ctrl o Cmd para seleccionar varios.</small>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" class="form-control" name="price" step="0.01" value="{{ old('price', $product->price) }}">
        </div>

        <div class="mb-3">
            <label for="price2" class="form-label">IVA</label>
            <input type="number" class="form-control" name="price2" step="0.01" value="{{ old('price2', $product->price2) }}">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Imagen del producto</label>
            @if ($product->image)
                <div class="mb-2">
                    <img src="{{ full_asset('storage/' . $product->image) }}" alt="Imagen actual" style="max-height: 150px;">
                </div>
            @endif
            <input type="file" class="form-control" name="image" accept="image/*">
            <small class="text-muted">Sube una nueva imagen solo si deseas reemplazar la actual.</small>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-save me-2"></i> Guardar cambios
        </button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancelar</a>
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
