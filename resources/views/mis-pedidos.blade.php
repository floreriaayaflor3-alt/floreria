<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mis Pedidos - AYAFlora</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
    min-height:100vh;
    background-image:url("https://images.unsplash.com/photo-1604400247036-e0b38afce25c");
    background-size:cover;
    background-position:center;
}
.fondo{ min-height:100vh; background:rgba(255,255,255,0.75); }
.navbar{ background:#7b2d5b !important; }
.card-flor{ background:white; border-radius:18px; box-shadow:0 4px 15px rgba(0,0,0,0.15); border:none; }
.btn-flor{ background:#7b2d5b; color:white; border:none; }
.btn-flor:hover{ background:#5f2146; color:white; }
</style>
</head>
<body>
<div class="fondo">

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/principal">🌸 AYAFlora</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="/principal">Catálogo</a>
            <a class="nav-link" href="/carrito">🛒 Carrito</a>
            <a class="nav-link text-warning" href="/logout">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container py-5">

    <div class="card card-flor p-4 mb-4">
        <h2>📦 Mis Pedidos</h2>
    </div>

    @if($pedidos->isEmpty())
        <div class="card card-flor p-4 text-center">
            <h4>No tienes pedidos aún</h4>
            <a href="/principal" class="btn btn-flor mt-3">Ver catálogo</a>
        </div>
    @else
        @foreach($pedidos as $pedido)
        <div class="card card-flor p-4 mb-3">
            <div class="row">
                <div class="col-md-8">
                    <h5>Folio: <strong>{{ $pedido->folio }}</strong></h5>
                    <p class="mb-1">Fecha: {{ $pedido->fecha }}</p>
                    <p class="mb-1">Método de pago: {{ $pedido->metodo_nombre }}</p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-success fs-6 mb-2">{{ $pedido->estado }}</span>
                    <p>Subtotal: ${{ number_format($pedido->subtotal, 2) }}</p>
                    <p>IVA: ${{ number_format($pedido->iva, 2) }}</p>
                    <h5>Total: ${{ number_format($pedido->total, 2) }}</h5>
                    <a href="/comprobante/{{ $pedido->id_venta }}" class="btn btn-flor btn-sm">Ver comprobante</a>
                </div>
            </div>
        </div>
        @endforeach
    @endif

</div>
</div>
</body>
</html>