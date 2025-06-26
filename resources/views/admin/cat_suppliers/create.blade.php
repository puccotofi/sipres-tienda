@extends('layouts.admin')

@section('title', 'Nuevo Proveedor')

@section('content')
<div class="container">
    <h2 class="mb-4">Agregar nuevo proveedor</h2>

    <form action="{{ route('admin.suppliers.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="contact_name" class="form-label">Nombre del contacto</label>
            <input type="text" class="form-control" name="contact_name" value="{{ old('contact_name') }}">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
        </div>

        <div class="mb-3">
            <label for="phone2" class="form-label">Teléfono alternativo</label>
            <input type="text" class="form-control" name="phone2" value="{{ old('phone2') }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Dirección</label>
            <textarea class="form-control" name="address" rows="3">{{ old('address') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fa-solid fa-check me-2"></i> Guardar proveedor
        </button>
        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
