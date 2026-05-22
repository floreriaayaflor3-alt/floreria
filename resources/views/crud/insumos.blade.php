<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Insumos - AYAFlora Admin</title>
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
        <h4>{{ isset($insumo) ? '✏️ Editar Insumo' : '➕ Agregar Insumo' }}</h4>
        <form method="POST" action="{{ isset($insumo) ? '/crud/insumos/'.$insumo->id_insumo.'/actualizar' : '/crud/insumos' }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ isset($insumo) ? $insumo->nombre : '' }}" required>
                </div>
                <div class="col-md-4">
                    <label>Categoría</label>
                    <select name="categoria" class="form-select">
                        @foreach(['Material Floral','Accesorio','Empaque','Peluche','Alimento','Otro'] as $cat)
                            <option {{ isset($insumo) && $insumo->categoria == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Proveedor</label>
                    <select name="id_proveedor" class="form-select">
                        <option value="">Sin proveedor</option>
                        @foreach($proveedores as $p)
                            <option value="{{ $p->id_proveedor }}" {{ isset($insumo) && $insumo->id_proveedor == $p->id_proveedor ? 'selected' : '' }}>{{ $p->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Unidad</label>
                    <select name="unidad_medida" class="form-select">
                        @foreach(['Pieza','Tallo','Rollo','Caja','Kg','Lt','Paquete'] as $u)
                            <option {{ isset($insumo) && $insumo->unidad_medida == $u ? 'selected' : '' }}>{{ $u }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Precio Unitario</label>
                    <input type="number" name="precio_unitario" step="0.01" class="form-control" value="{{ isset($insumo) ? $insumo->precio_unitario : '' }}">
                </div>
                <div class="col-md-2">
                    <label>Stock Actual</label>
                    <input type="number" name="stock_actual" class="form-control" value="{{ isset($insumo) ? $insumo->stock_actual : '' }}">
                </div>
                <div class="col-md-2">
                    <label>Stock Mínimo</label>
                    <input type="number" name="stock_minimo" class="form-control" value="{{ isset($insumo) ? $insumo->stock_minimo : '' }}">
                </div>
                <div class="col-md-2">
                    <label>Fecha Compra</label>
                    <input type="date" name="fecha_compra" class="form-control" value="{{ isset($insumo) ? $insumo->fecha_compra : '' }}">
                </div>
                <div class="col-md-2">
                    <label>Fecha Vencimiento</label>
                    <input type="date" name="fecha_vencimiento" class="form-control" value="{{ isset($insumo) ? $insumo->fecha_vencimiento : '' }}">
                </div>
                <div class="col-md-12">
                    <label>Descripción</label>
                    <input type="text" name="descripcion" class="form-control" value="{{ isset($insumo) ? $insumo->descripcion : '' }}">
                </div>
            </div>
            <div class="mt-3">
                <button class="btn btn-flor">{{ isset($insumo) ? 'Actualizar' : 'Guardar Insumo' }}</button>
                @if(isset($insumo))
                    <a href="/crud/insumos" class="btn btn-secondary ms-2">Cancelar</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card p-4">
        <h4>📋 Lista de Insumos</h4>
        <table class="table table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Unidad</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Stock Mín.</th>
                    <th>Proveedor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($insumos as $i)
                <tr>
                    <td>{{ $i->id_insumo }}</td>
                    <td>{{ $i->nombre }}</td>
                    <td>{{ $i->categoria }}</td>
                    <td>{{ $i->unidad_medida }}</td>
                    <td>${{ number_format($i->precio_unitario, 2) }}</td>
                    <td>{{ $i->stock_actual }}</td>
                    <td>{{ $i->stock_minimo }}</td>
                    <td>{{ $i->nombre_proveedor ?? 'N/A' }}</td>
                    <td>
                        <a href="/crud/insumos/{{ $i->id_insumo }}/editar" class="btn btn-sm btn-warning">Editar</a>
                        <a href="/crud/insumos/{{ $i->id_insumo }}/eliminar" class="btn btn-sm btn-danger"
                            onclick="return confirm('¿Eliminar este insumo?')">Eliminar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
</body>
</html>