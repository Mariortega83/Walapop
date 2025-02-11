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
            <img src="{{ asset('storage/' . $sale->img) }}" alt="{{ $sale->product }}" class="card-img-top" style="height: 200px; object-fit: cover;">


                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-primary">{{ $sale->product }}</h5>
                    <p class="card-text text-muted mb-3">{{ $sale->description }}</p>
                    <p class="text-success fw-bold">Precio: {{ number_format($sale->price, 2) }}€</p>
                </div>

                <div class="card-footer bg-transparent border-0 text-center">
                    <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-outline-primary">Ver más</a>
                    <form action="{{ route('sales.toggleSold', $sale->id) }}" method="POST" class="d-inline-block">
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
                <img src="data:image/jpeg;base64,{{ base64_encode($sale->img) }}"
                    alt="{{ $sale->product }}"
                    class="card-img-top"
                    style="height: 200px; object-fit: cover;">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-secondary">{{ $sale->product }}</h5>
                    <p class="card-text text-muted mb-3">{{ $sale->description }}</p>
                    <p class="text-success fw-bold">Precio: {{ number_format($sale->price, 2) }}€</p>
                </div>

                <div class="card-footer bg-transparent border-0 text-center">
                    <form action="{{ route('sales.toggleSold', $sale->id) }}" method="POST" class="d-inline-block">
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
