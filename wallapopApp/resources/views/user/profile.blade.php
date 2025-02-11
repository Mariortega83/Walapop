@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Mi Perfil</h1>
    @if (Auth::user()->role === 'admin')
    <div class="text-end mb-4">
        <a class="btn btn-danger" href="{{ route('admin.index') }}">{{ __('ADMIN') }}</a>
    </div>
    @endif

    <!-- Anuncios Activos -->
    <h2 class="text-primary">Anuncios Activos</h2>
    @if($activeSales->isEmpty())
    <p class="text-center text-muted">No tienes anuncios activos.</p>
    @else
    <div class="row g-4">
        @foreach ($activeSales as $sale)
        <div class="col-md-4">
            <div class="card h-100 shadow">
            <div class="mb-3">
                    @if($sale->images->count() > 0)
                    <div id="carousel{{ $sale->id }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($sale->images as $key => $image)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                
                                <img src="{{ asset('storage/' . $image->ruta) }}" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Imagen de {{ $sale->product }}">

                            </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $sale->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $sale->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                    @else
                    <img src="{{ asset('images/default-thumbnail.jpg') }}" class="w-100" style="height: 200px; object-fit: cover;" alt="Sin imagen">
                    @endif
                </div>


                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-primary">{{ $sale->product }}</h5>
                    <p class="card-text text-muted mb-3">{{ $sale->description }}</p>
                    <p class="text-success fw-bold">Precio: {{ number_format($sale->price, 2) }}€</p>
                </div>

                <div class="card-footer bg-transparent border-0 text-center">
                    <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-outline-primary">Ver más</a>
                    <form action="{{ route('sales.cambiarVerificar', $sale->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-success"
                            onclick="return confirm('¿Estás seguro de marcar este anuncio como vendido?');">
                            Marcar como Vendido
                        </button>
                    </form>
                    <form action="{{ route('sales.delete', $sale->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('¿Estás seguro de eliminar este anuncio?');">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Anuncios Vendidos -->
    <h2 class="text-secondary mt-5">Anuncios Vendidos</h2>
    @if($soldSales->isEmpty())
    <p class="text-center text-muted">No tienes anuncios vendidos.</p>
    @else
    <div class="row g-4">
        @foreach ($soldSales as $sale)
        <div class="col-md-4">
            <div class="card h-100 shadow">
            <div class="mb-3">
                    @if($sale->images->count() > 0)
                    <div id="carousel{{ $sale->id }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($sale->images as $key => $image)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                
                                <img src="{{ asset('storage/' . $image->ruta) }}" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Imagen de {{ $sale->product }}">

                            </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $sale->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $sale->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                    @else
                    <img src="{{ asset('images/default-thumbnail.jpg') }}" class="w-100" style="height: 200px; object-fit: cover;" alt="Sin imagen">
                    @endif
                </div>

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-secondary">{{ $sale->product }}</h5>
                    <p class="card-text text-muted mb-3">{{ $sale->description }}</p>
                    <p class="text-success fw-bold">Precio: {{ number_format($sale->price, 2) }}€</p>
                </div>

                <div class="card-footer bg-transparent border-0 text-center">
                    <form action="{{ route('sales.cambiarVerificar', $sale->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-success"
                            onclick="return confirm('¿Estás seguro de reactivar este anuncio?');">
                            Reactivar
                        </button>
                    </form>
                    <form action="{{ route('sales.delete', $sale->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('¿Estás seguro de eliminar este anuncio?');">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
