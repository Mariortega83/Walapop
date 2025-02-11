@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Usuarios Registrados</h1>

    @if($users->isEmpty())
        <p class="text-center text-muted">No hay usuarios registrados.</p>
    @else
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                            </form>

                            <!-- Botón de verificación -->
                            <form action="{{ route('admin.users.cambiarVerificar', $user->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $user->hasVerifiedEmail() ? 'btn-outline-secondary' : 'btn-outline-primary' }}">
                                    {{ $user->hasVerifiedEmail() ? 'Desverificar' : 'Verificar' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
