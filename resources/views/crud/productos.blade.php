<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Productos - AYAFlora Admin</title>
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

    <div class="card p-4 mb-4">
        <h4>{{ isset($producto) ? '✏️ Editar Producto' : '➕ Agregar Producto' }}</h4>
        <form method="POST" action="{{ isset($producto) ? '/crud/productos/'.$producto->id_producto.'/actualizar' : '/crud/productos' }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control"
                        value="{{ isset($producto) ? $producto->nombre : '' }}" required>
                </div>
                <div class="col-md-4">
                    <label>Categoría</label>
                    <select name="id_categoria" class="form-select" required>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id_categoria }}"
                                {{ isset($producto) && $producto->id_categoria == $cat->id_categoria ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Precio</label>
                    <input type="number" name="precio" step="0.01" class="form-control"
                        value="{{ isset($producto) ? $producto->precio : '' }}" required>
                </div>
                <div class="col-md-2">
                    <label>Stock</label>
                    <input type="number" name="stock" class="form-control"
                        value="{{ isset($producto) ? $producto->stock : '' }}" required>
                </div>
                <div class="col-md-8">
                    <label>Descripción</label>
                    <input type="text" name="descripcion" class="form-control"
                        value="{{ isset($producto) ? $producto->descripcion : '' }}">
                </div>
                <div class="col-md-4">
                    <label>URL de imagen</label>
                    <input type="text" name="imagen" class="form-control"
                        value="{{ isset($producto) ? $producto->imagen : '' }}">
                </div>
            </div>
            <div class="mt-3">
                <button class="btn btn-flor">{{ isset($producto) ? 'Actualizar' : 'Guardar Producto' }}</button>
                @if(isset($producto))
                    <a href="/crud/productos" class="btn btn-secondary ms-2">Cancelar</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card p-4">
        <h4>📋 Lista de Productos</h4>
        <table class="table table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $p)
                <tr>
                    <td>{{ $p->id_producto }}</td>
                    <td>{{ $p->nombre }}</td>
                    <td>{{ $p->nombre_categoria }}</td>
                    <td>${{ number_format($p->precio, 2) }}</td>
                    <td>{{ $p->stock }}</td>
                    <td>
                        <span class="badge {{ $p->estado == 'Activo' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $p->estado }}
                        </span>
                    </td>
                    <td>
                        <a href="/crud/productos/{{ $p->id_producto }}/editar" class="btn btn-sm btn-warning">Editar</a>
                        <a href="/crud/productos/{{ $p->id_producto }}/eliminar" class="btn btn-sm btn-danger"
                            onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
</body>
</html>