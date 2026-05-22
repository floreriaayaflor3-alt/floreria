<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Clientes - AYAFlora Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background: #f8f0f4; }
.navbar { background: #7b2d5b !important; }
.btn-flor { background: #7b2d5b; color: white; border: none; }
.btn-flor:hover { background: #5f2146; color: white; }
.card { border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
</style>
</head>
<body>

<nav class="navbar navbar-dark navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/principal">🌸 AYAFlora Admin</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="/crud/productos">Productos</a>
            <a class="nav-link" href="/crud/insumos">Insumos</a>
            <a class="nav-link" href="/crud/proveedores">Proveedores</a>
            <a class="nav-link" href="/crud/clientes">Clientes</a>
            <a class="nav-link" href="/crud/trabajadores">Trabajadores</a>
            <a class="nav-link text-warning" href="/logout">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card p-4">
        <h4>👥 Lista de Clientes</h4>
        <div class="table-responsive">
            <table class="table table-hover mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Dirección</th>
                        <th>Colonia</th>
                        <th>Municipio</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $c)
                    <tr>
                        <td>{{ $c->id_cliente }}</td>
                        <td>{{ $c->nombre }}</td>
                        <td>{{ $c->telefono }}</td>
                        <td>{{ $c->correo }}</td>
                        <td>{{ $c->direccion }}</td>
                        <td>{{ $c->colonia }}</td>
                        <td>{{ $c->municipio }}</td>
                        <td>{{ $c->estado }}</td>
                        <td>
                            <a href="/crud/clientes/{{ $c->id_cliente }}/eliminar" class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Eliminar este cliente?')">Eliminar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>