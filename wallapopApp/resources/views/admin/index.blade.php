@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Panel de Administración</h1>
    <div class="row mt-4">
        <div class="col-md-4">
            <a href="{{ route('admin.users') }}" class="btn btn-primary btn-block w-100 py-3">Gestionar Usuarios</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.utilities') }}" class="btn btn-secondary btn-block w-100 py-3">Gestionar Anuncios y Categorías</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('sales.index') }}" class="btn btn-outline-dark btn-block w-100 py-3">Volver al Inicio</a>
        </div>
    </div>
</div>
@endsection
