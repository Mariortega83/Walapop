@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Crear Anuncio</h1>
    <form action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data" class="bg-light p-5 rounded shadow">
        @csrf

        <!-- Campo Producto -->
        <div class="mb-3">
            <label for="product" class="form-label">Producto</label>
            <input type="text" name="product" id="product" class="form-control" placeholder="Nombre del producto" required>
        </div>

        <!-- Campo Descripción -->
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" rows="4" class="form-control" placeholder="Descripción del producto" required></textarea>
        </div>

        <!-- Campo Precio -->
        <div class="mb-3">
            <label for="price" class="form-label">Precio (€)</label>
            <input type="number" name="price" id="price" class="form-control" placeholder="Ejemplo: 25.99" step="0.01" required>
        </div>

        <!-- Campo Categoría -->
        <div class="mb-3">
            <label for="category_id" class="form-label">Categoría</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="" disabled selected>Selecciona una categoría</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Campo Imágenes -->
        <div class="mb-3">
            <label for="images" class="form-label">Imágenes (máximo: {{ $maxImages }})</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple required>
        </div>

        <!-- Botón de envío -->
        <button type="submit" class="btn btn-primary w-100">Crear Anuncio</button>
    </form>
</div>
@endsection
