@extends('layouts.admin')

@section('title', 'Editar Proveedor')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar proveedor</h2>

    <form action="{{ route('admin.suppliers.update', $supplier) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="name" required value="{{ old('name', $supplier->name) }}">
        </div>

        <div class="mb-3">
            <label for="contact_name" class="form-label">Nombre del contacto</label>
            <input type="text" class="form-control" name="contact_name" value="{{ old('contact_name', $supplier->contact_name) }}">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="text" class="form-control" name="phone" value="{{ old('phone', $supplier->phone) }}">
        </div>

        <div class="mb-3">
            <label for="phone2" class="form-label">Teléfono alternativo</label>
            <input type="text" class="form-control" name="phone2" value="{{ old('phone2', $supplier->phone2) }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', $supplier->email) }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Dirección</label>
            <textarea class="form-control" name="address" rows="3">{{ old('address', $supplier->address) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-save me-2"></i> Guardar cambios
        </button>
        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection