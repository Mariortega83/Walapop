@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Gestión de Anuncios y Categorías</h1>

    <!-- Sección: Listado de anuncios -->
    <h2 class="mt-5">Anuncios</h2>
    @if($sales->isEmpty())
    <p class="text-muted">No hay anuncios disponibles.</p>
    @else
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)

            <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $sale->product }}</td>
                <td>{{ $sale->description }}</td>
                <td>{{ $sale->price }}€</td>
                <td>
                    @if($sale->isSold == 1)
                    <span class="badge bg-success">Vendido</span>
                    @else
                    <span class="badge bg-warning">Disponible</span>
                    @endif
                </td>
                <td>

                    <form action="{{ route('sales.cambiarVerificar', $sale->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $sale->isSold ? 'btn-danger' : 'btn-success' }}">
                            {{ $sale->isSold ? 'Marcar como No Vendido' : 'Marcar como Vendido' }}
                        </button>
                    </form>

                    <form action="{{ route('admin.sales.delete', $sale->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este anuncio?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Sección: Listado de categorías -->
    <h2 class="mt-5">Categorías</h2>
    @if($categories->isEmpty())
    <p class="text-muted">No hay categorías disponibles.</p>
    @else
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>
                    @if($category->sales->isEmpty())
                    <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">Eliminar</button>
                    </form>
                    @else
                    <span class="text-muted">No se puede eliminar (asignada a anuncios)</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Sección: Añadir nueva categoría -->
    <h2 class="mt-5">Añadir Nueva Categoría</h2>
    <form action="{{ route('admin.categories.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="input-group">
            <input type="text" name="name" class="form-control" placeholder="Nombre de la categoría" required>
            <button type="submit" class="btn btn-success">Añadir</button>
        </div>
    </form>
</div>
@endsection