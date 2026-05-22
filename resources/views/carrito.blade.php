<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Carrito - AYAFlora</title>
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
.producto-img{ height:80px; width:80px; object-fit:cover; border-radius:10px; }

.promo-aplicada-box {
    background: #fdf5f9;
    border: 1.5px dashed #7b2d5b;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}
.promo-aplicada-box .promo-left {
    display: flex;
    align-items: center;
    gap: 10px;
}
.promo-aplicada-box .promo-icono { font-size: 1.4rem; }
.promo-aplicada-box .promo-texto {
    font-size: 0.82rem;
    color: #4a1b35;
    margin: 0;
}
.promo-aplicada-box .promo-texto strong {
    display: block;
    font-size: 0.9rem;
}
.promo-aplicada-box .promo-badge {
    background: #7b2d5b;
    color: white;
    border-radius: 999px;
    padding: 4px 16px;
    font-weight: 700;
    font-size: 0.9rem;
    white-space: nowrap;
}
.total-row {
    border-top: 2px solid #f0dce9;
    padding-top: 0.75rem;
    margin-top: 0.5rem;
}
.descuento-row {
    color: #2e7d32;
    font-weight: 600;
}
</style>
</head>
<body>
<div class="fondo">

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/principal">🌸 AYAFlora</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="/principal">Catálogo</a>
            <a class="nav-link text-warning" href="/logout">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container py-5">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-flor p-4 mb-4">
        <h2>🛒 Mi Carrito</h2>
    </div>

    @if($items->isEmpty())
        <div class="card card-flor p-4 text-center">
            <h4>Tu carrito está vacío</h4>
            <a href="/principal" class="btn btn-flor mt-3">Ver catálogo</a>
        </div>
    @else
        <div class="card card-flor p-4 mb-4">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @if($item->imagen)
                                    <img src="{{ $item->imagen }}" class="producto-img">
                                @else
                                    <div class="producto-img d-flex align-items-center justify-content-center bg-light">🌸</div>
                                @endif
                                {{ $item->nombre }}
                            </div>
                        </td>
                        <td>${{ number_format($item->precio, 2) }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td>${{ number_format($item->cantidad * $item->precio, 2) }}</td>
                        <td>
                            <a href="/carrito/{{ $item->id_carrito }}/eliminar" class="btn btn-sm btn-danger">Quitar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card card-flor p-4">
            <div class="row">
                <div class="col-md-6">
                    <form method="POST" action="/carrito/vaciar">
                        @csrf
                        <button class="btn btn-outline-danger">🗑️ Vaciar carrito</button>
                    </form>
                </div>
                <div class="col-md-6 text-end">

                    <p>Subtotal: <strong>${{ number_format($subtotal, 2) }}</strong></p>

                    {{-- Promoción aplicada --}}
                    @if(session('promo_aplicada') && $descuento > 0)
                    <div class="promo-aplicada-box">
                        <div class="promo-left">
                            <span class="promo-icono">🎉</span>
                            <p class="promo-texto">
                                <strong>{{ session('promo_aplicada')['titulo'] }}</strong>
                                {{ session('promo_aplicada')['descripcion'] }}
                            </p>
                        </div>
                        <span class="promo-badge">{{ session('promo_aplicada')['descuento'] }}</span>
                    </div>
                    <p class="descuento-row">
                        Descuento: <strong>-${{ number_format($descuento, 2) }}</strong>
                    </p>
                    @endif

                    <p>IVA (16%): <strong>${{ number_format($iva, 2) }}</strong></p>

                    <div class="total-row">
                        <h4>Total: <strong>${{ number_format($total, 2) }}</strong></h4>
                    </div>

                    <div class="mt-3">
                        <a href="/principal" class="btn btn-secondary me-2">Seguir comprando</a>
                        <a href="/pago" class="btn btn-flor">Proceder al pago</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>