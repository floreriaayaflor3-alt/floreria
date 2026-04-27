<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Principal - AYAFlora</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    min-height:100vh;
    background-image:url("https://images.unsplash.com/photo-1604400247036-e0b38afce25c");
    background-size:cover;
    background-position:center;
}

.fondo{
    min-height:100vh;
    background:rgba(255,255,255,0.75);
}

.navbar{
    background:#7b2d5b !important;
}

.card-flor{
    background:white;
    border-radius:18px;
    box-shadow:0 4px 15px rgba(0,0,0,0.15);
    border:none;
}

.btn-flor{
    background:#7b2d5b;
    color:white;
    border:none;
}

.btn-flor:hover{
    background:#5f2146;
    color:white;
}

.producto-img{
    height:180px;
    object-fit:cover;
    border-radius:15px 15px 0 0;
}
</style>
</head>

<body>

<div class="fondo">

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/principal">🌸 AYAFlora</a>

        <div class="navbar-nav ms-auto">

            @if(session('rol') == 'admin')
                <a class="nav-link" href="/crud/insumo">Insumo</a>
                <a class="nav-link" href="/crud/proveedor">Proveedor</a>
                <a class="nav-link" href="/crud/cliente">Cliente</a>
                <a class="nav-link" href="/crud/trabajador">Trabajador</a>
            @endif

            @if(session('rol') == 'vendedor')
                <a class="nav-link" href="/venta">Vender</a>
            @endif

            @if(session('rol') == 'cajero')
                <a class="nav-link" href="/cobro">Cobrar</a>
            @endif

            <a class="nav-link text-warning" href="/logout">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container py-5">

    <div class="card card-flor p-4 mb-4">
        <h1>Bienvenido a AYAFlora 🌸</h1>
        <p class="mb-0">
            Has iniciado sesión como:
            <strong>{{ session('rol') }}</strong>
        </p>
    </div>

    @if(session('rol') == 'admin')

        <div class="row g-4">
            <div class="col-md-3">
                <div class="card card-flor p-4 text-center">
                    <h4>Insumos</h4>
                    <p>Administra flores, listones y materiales.</p>
                    <a href="/crud/insumo" class="btn btn-flor">Entrar</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-flor p-4 text-center">
                    <h4>Proveedores</h4>
                    <p>Controla tus proveedores registrados.</p>
                    <a href="/crud/proveedor" class="btn btn-flor">Entrar</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-flor p-4 text-center">
                    <h4>Clientes</h4>
                    <p>Consulta y administra clientes.</p>
                    <a href="/crud/cliente" class="btn btn-flor">Entrar</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-flor p-4 text-center">
                    <h4>Trabajadores</h4>
                    <p>Gestiona vendedores y cajeros.</p>
                    <a href="/crud/trabajador" class="btn btn-flor">Entrar</a>
                </div>
            </div>
        </div>

    @elseif(session('rol') == 'cliente')

        <h2 class="mb-4">Catálogo de productos</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-flor">
                    <img src="https://images.unsplash.com/photo-1561181286-d3fee7d55364" class="producto-img">
                    <div class="card-body">
                        <h5>Ramo de Rosas</h5>
                        <p>$450.00</p>
                        <button class="btn btn-flor w-100">Agregar al carrito</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-flor">
                    <img src="https://images.unsplash.com/photo-1525310072745-f49212b5ac6d" class="producto-img">
                    <div class="card-body">
                        <h5>Arreglo Floral</h5>
                        <p>$650.00</p>
                        <button class="btn btn-flor w-100">Agregar al carrito</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-flor">
                    <img src="https://images.unsplash.com/photo-1518895949257-7621c3c786d7" class="producto-img">
                    <div class="card-body">
                        <h5>Detalle Especial</h5>
                        <p>$300.00</p>
                        <button class="btn btn-flor w-100">Agregar al carrito</button>
                    </div>
                </div>
            </div>
        </div>

    @elseif(session('rol') == 'vendedor')

        <div class="card card-flor p-4">
            <h2>Panel de vendedor</h2>
            <p>Aquí puedes registrar ventas y consultar productos disponibles.</p>
            <a href="/venta" class="btn btn-flor">Realizar venta</a>
        </div>

    @elseif(session('rol') == 'cajero')

        <div class="card card-flor p-4">
            <h2>Panel de cajero</h2>
            <p>Aquí puedes cobrar pedidos y confirmar pagos.</p>
            <a href="/cobro" class="btn btn-flor">Cobrar pedido</a>
        </div>

    @else

        <div class="card card-flor p-4">
            <h2>Rol no reconocido</h2>
            <p>Tu usuario no tiene un rol válido asignado.</p>
        </div>

    @endif

</div>

</div>

</body>
</html>