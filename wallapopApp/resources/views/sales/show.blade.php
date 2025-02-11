@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Imagen principal -->
        <div class="col-md-6">
            <img src="data:image/jpeg;base64,{{ base64_encode($sale->img) }}" 
                 alt="{{ $sale->product }}" 
                 class="img-fluid rounded shadow-sm">
        </div>

        <!-- Detalles del anuncio -->
        <div class="col-md-6">
            <h1 class="text-primary">{{ $sale->product }}</h1>
            <p class="text-muted">{{ $sale->description }}</p>
            <p class="text-success fw-bold">Precio: {{ number_format($sale->price, 2) }}€</p>
            <p class="text-secondary">Categoría: <span class="badge bg-info text-dark">{{ $sale->category->name }}</span></p>
            <p class="text-secondary">Publicado por: <strong>{{ $sale->user->name }}</strong></p>

            <!-- Botón de contacto o volver -->
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mt-3">Volver a la lista</a>
        </div>
    </div>

    <!-- Galería de imágenes adicionales -->
    @if ($sale->images->count() > 0)
        <h3 class="mt-5">Imágenes adicionales</h3>
        <div class="row g-3 mt-3">
            @foreach ($sale->images as $image)
                <div class="col-md-3">
                    <img src="{{ asset('storage/' . $image->ruta) }}" 
                         alt="Imagen adicional" 
                         class="img-fluid rounded shadow-sm">
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
