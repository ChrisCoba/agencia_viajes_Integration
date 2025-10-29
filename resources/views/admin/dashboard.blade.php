@extends('layouts.main')

@section('title', 'Panel de Administración')

@section('content')
<div class="container mt-5">
    <h2>Panel de Administración</h2>
    <div class="row">
        <div class="col-md-3">
            <ul class="list-group">
                <li class="list-group-item"><a href="{{ route('admin.tours') }}">Gestionar Tours</a></li>
                <li class="list-group-item"><a href="{{ route('admin.packages') }}">Gestionar Paquetes</a></li>
                <li class="list-group-item"><a href="{{ route('admin.reservations') }}">Gestionar Reservaciones</a></li>
                <li class="list-group-item"><a href="{{ route('admin.users') }}">Gestionar Usuarios</a></li>
            </ul>
        </div>
        <div class="col-md-9">
            <h3>Bienvenido al Panel de Administración</h3>
            <p>Selecciona una opción del menú para comenzar.</p>
        </div>
    </div>
</div>
@endsection