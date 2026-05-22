<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Comprobante - AYAFlora</title>
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
            <a class="nav-link text-warning" href="/logout">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="card card-flor p-4 text-center mb-4">
        <h1>✅ ¡Pago exitoso!</h1>
        <p class="text-muted">Tu pedido ha sido procesado correctamente.</p>
    </div>

    <div class="card card-flor p-4 mb-4">
        <h4>🧾 Comprobante de venta</h4>
        <div class="row mt-3">
            <div class="col-md-6">
                <p><strong>Folio:</strong> {{ $venta->folio }}</p>
                <p><strong>Fecha:</strong> {{ $venta->fecha }}</p>
                <p><strong>Método de pago:</strong> {{ $venta->metodo_nombre }}</p>
            </div>
            <div class="col-md-6 text-end">
                <p><strong>Subtotal:</strong> ${{ number_format($venta->subtotal, 2) }}</p>
                <p><strong>IVA (16%):</strong> ${{ number_format($venta->iva, 2) }}</p>
                <h5><strong>Total:</strong> ${{ number_format($venta->total, 2) }}</h5>
            </div>
        </div>

        <table class="table mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detalle as $d)
                <tr>
                    <td>{{ $d->nombre }}</td>
                    <td>{{ $d->cantidad }}</td>
                    <td>${{ number_format($d->precio_unitario, 2) }}</td>
                    <td>${{ number_format($d->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="text-center">
        <a href="/principal" class="btn btn-flor">Seguir comprando</a>
    </div>
</div>
</div>
</body>
</html>