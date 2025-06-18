@extends('layouts.admin')

@section('content')
    <div class="container py-5">
        <h1>Panel de Administración</h1>
        <p>Bienvenido, {{ auth()->user()->name }}.</p>
    </div>
@endsection