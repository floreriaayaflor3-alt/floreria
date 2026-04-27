<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>CRUD - AYAFlora</title>

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
    background:rgba(255,255,255,0.78);
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

.titulo{
    color:#7b2d5b;
    font-weight:bold;
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

.btn-editar{
    background:#d99ac5;
    color:white;
    border:none;
}

.btn-editar:hover{
    background:#c77ab0;
    color:white;
}

.btn-eliminar{
    background:#b23a48;
    color:white;
    border:none;
}

.btn-eliminar:hover{
    background:#8f2f3a;
    color:white;
}

.table thead{
    background:#7b2d5b;
    color:white;
}

.form-control:focus{
    border-color:#7b2d5b;
    box-shadow:0 0 0 0.2rem rgba(123,45,91,0.25);
}
</style>
</head>

<body>

<div class="fondo">

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/principal">🌸 AYAFlora Admin</a>

        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="/crud/insumo">Insumo</a>
            <a class="nav-link" href="/crud/proveedor">Proveedor</a>
            <a class="nav-link" href="/crud/cliente">Cliente</a>
            <a class="nav-link" href="/crud/trabajador">Trabajador</a>
            <a class="nav-link text-warning" href="/logout">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container py-5">

    <div class="card card-flor p-4 mb-4">
        <h2 class="titulo mb-1">CRUD de {{ ucfirst($tipo) }} 🌸</h2>
        <p class="text-muted mb-0">Administra la información de {{ $tipo }} en AYAFlora.</p>
    </div>

    <div class="card card-flor p-4 mb-4">
        <h5 class="titulo mb-3">Agregar {{ ucfirst($tipo) }}</h5>

        <form>
            <div class="row">
                <div class="col-md-5">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control mb-3" placeholder="Escribe el nombre">
                </div>

                <div class="col-md-5">
                    <label class="form-label">Descripción</label>
                    <input type="text" class="form-control mb-3" placeholder="Escribe la descripción">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-flor w-100 mb-3">Guardar</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card card-flor p-4">
        <h5 class="titulo mb-3">Lista de {{ ucfirst($tipo) }}</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Ejemplo {{ $tipo }}</td>
                        <td>Descripción de ejemplo</td>
                        <td>
                            <button class="btn btn-editar btn-sm">Editar</button>
                            <button class="btn btn-eliminar btn-sm">Eliminar</button>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>{{ ucfirst($tipo) }} demo</td>
                        <td>Registro de prueba</td>
                        <td>
                            <button class="btn btn-editar btn-sm">Editar</button>
                            <button class="btn btn-eliminar btn-sm">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</div>

</div>

</body>
</html>