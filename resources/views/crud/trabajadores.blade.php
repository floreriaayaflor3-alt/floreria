<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Trabajadores - AYAFlora Admin</title>
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
            <a class="nav-link" href="/crud/promociones">Promociones</a>
            <a class="nav-link text-warning" href="/logout">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card p-4 mb-4">
        <h4>{{ isset($trabajador) ? '✏️ Editar Trabajador' : '➕ Agregar Trabajador' }}</h4>
        <form method="POST" action="{{ isset($trabajador) ? '/crud/trabajadores/'.$trabajador->id_trabajador.'/actualizar' : '/crud/trabajadores' }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ isset($trabajador) ? $trabajador->nombre : '' }}" required>
                </div>
                <div class="col-md-4">
                    <label>Usuario</label>
                    <input type="text" name="usuario" class="form-control" value="{{ isset($trabajador) ? $trabajador->usuario : '' }}" required>
                </div>
                <div class="col-md-4">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control" placeholder="{{ isset($trabajador) ? 'Dejar vacío para no cambiar' : '' }}">
                </div>
                <div class="col-md-4">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="{{ isset($trabajador) ? $trabajador->telefono : '' }}">
                </div>
                <div class="col-md-4">
                    <label>Rol</label>
                    <select name="id_rol" class="form-select" required>
                        <option value="2" {{ isset($trabajador) && $trabajador->id_rol == 2 ? 'selected' : '' }}>Empleado</option>
                        <option value="3" {{ isset($trabajador) && $trabajador->id_rol == 3 ? 'selected' : '' }}>Vendedor</option>
                        <option value="5" {{ isset($trabajador) && $trabajador->id_rol == 5 ? 'selected' : '' }}>Cajero</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Fecha Ingreso</label>
                    <input type="date" name="fecha_ingreso" class="form-control" value="{{ isset($trabajador) ? $trabajador->fecha_ingreso : '' }}">
                </div>
                <div class="col-md-8">
                    <label>Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="{{ isset($trabajador) ? $trabajador->direccion : '' }}">
                </div>
            </div>
            <div class="mt-3">
                <button class="btn btn-flor">{{ isset($trabajador) ? 'Actualizar' : 'Guardar Trabajador' }}</button>
                @if(isset($trabajador))
                    <a href="/crud/trabajadores" class="btn btn-secondary ms-2">Cancelar</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card p-4">
        <h4>👷 Lista de Trabajadores</h4>
        <table class="table table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trabajadores as $t)
                <tr>
                    <td>{{ $t->id_trabajador }}</td>
                    <td>{{ $t->nombre }}</td>
                    <td>{{ $t->usuario }}</td>
                    <td>{{ $t->nombre_rol }}</td>
                    <td>{{ $t->telefono }}</td>
                    <td>
                        <span class="badge {{ $t->estado == 'Activo' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $t->estado }}
                        </span>
                    </td>
                    <td>
                        <a href="/crud/trabajadores/{{ $t->id_trabajador }}/toggle"
                           class="btn btn-sm {{ $t->estado == 'Activo' ? 'btn-warning' : 'btn-success' }}">
                            {{ $t->estado == 'Activo' ? '🔴 Desactivar' : '🟢 Activar' }}
                        </a>
                        <a href="/crud/trabajadores/{{ $t->id_trabajador }}/editar" class="btn btn-sm btn-warning">Editar</a>
                        <a href="/crud/trabajadores/{{ $t->id_trabajador }}/eliminar" class="btn btn-sm btn-danger"
                            onclick="return confirm('¿Eliminar este trabajador?')">Eliminar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
</body>
</html>