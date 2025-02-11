@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Carrusel de imágenes -->
        <div class="col-md-6">
            @if ($sale->images->count() > 0)
            <div id="saleImagesCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($sale->images as $index => $image)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $image->ruta) }}" 
                             alt="Imagen del producto" 
                             class="d-block w-100 rounded shadow" 
                             style="height: 400px; object-fit: fill;">
                    </div>
                    @endforeach
                </div>
                <!-- Controles del carrusel -->
                <button class="carousel-control-prev" type="button" data-bs-target="#saleImagesCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#saleImagesCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
            @endif
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
</div>
@endsection
