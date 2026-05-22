<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Proveedores - AYAFlora Admin</title>
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
        <h4>{{ isset($proveedor) ? '✏️ Editar Proveedor' : '➕ Agregar Proveedor' }}</h4>
        <form method="POST" action="{{ isset($proveedor) ? '/crud/proveedores/'.$proveedor->id_proveedor.'/actualizar' : '/crud/proveedores' }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label>Nombre o Razón Social</label>
                    <input type="text" name="nombre" class="form-control" value="{{ isset($proveedor) ? $proveedor->nombre : '' }}" required>
                </div>
                <div class="col-md-4">
                    <label>RFC</label>
                    <input type="text" name="rfc" class="form-control" value="{{ isset($proveedor) ? $proveedor->rfc : '' }}">
                </div>
                <div class="col-md-4">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="{{ isset($proveedor) ? $proveedor->telefono : '' }}">
                </div>
                <div class="col-md-4">
                    <label>Correo</label>
                    <input type="email" name="correo" class="form-control" value="{{ isset($proveedor) ? $proveedor->correo : '' }}">
                </div>
                <div class="col-md-4">
                    <label>Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="{{ isset($proveedor) ? $proveedor->direccion : '' }}">
                </div>
                <div class="col-md-4">
                    <label>Ciudad</label>
                    <input type="text" name="ciudad" class="form-control" value="{{ isset($proveedor) ? $proveedor->ciudad : '' }}">
                </div>
                <div class="col-md-4">
                    <label>Estado</label>
                    <input type="text" name="estado_rep" class="form-control" value="{{ isset($proveedor) ? $proveedor->estado_rep : '' }}">
                </div>
                <div class="col-md-4">
                    <label>Código Postal</label>
                    <input type="text" name="codigo_postal" class="form-control" value="{{ isset($proveedor) ? $proveedor->codigo_postal : '' }}">
                </div>
                <div class="col-md-4">
                    <label>Persona de Contacto</label>
                    <input type="text" name="contacto" class="form-control" value="{{ isset($proveedor) ? $proveedor->contacto : '' }}">
                </div>
                <div class="col-md-4">
                    <label>Teléfono de Contacto</label>
                    <input type="text" name="telefono_contacto" class="form-control" value="{{ isset($proveedor) ? $proveedor->telefono_contacto : '' }}">
                </div>
                <div class="col-md-8">
                    <label>Descripción</label>
                    <input type="text" name="descripcion" class="form-control" value="{{ isset($proveedor) ? $proveedor->descripcion : '' }}">
                </div>
            </div>
            <div class="mt-3">
                <button class="btn btn-flor">{{ isset($proveedor) ? 'Actualizar' : 'Guardar Proveedor' }}</button>
                @if(isset($proveedor))
                    <a href="/crud/proveedores" class="btn btn-secondary ms-2">Cancelar</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card p-4">
        <h4>📋 Lista de Proveedores</h4>
        <div class="table-responsive">
        <table class="table table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>RFC</th>
                    <th>Teléfono</th>
                    <th>Ciudad</th>
                    <th>Estado</th>
                    <th>Contacto</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proveedores as $p)
                <tr>
                    <td>{{ $p->id_proveedor }}</td>
                    <td>{{ $p->nombre }}</td>
                    <td>{{ $p->rfc }}</td>
                    <td>{{ $p->telefono }}</td>
                    <td>{{ $p->ciudad }}</td>
                    <td>{{ $p->estado_rep }}</td>
                    <td>{{ $p->contacto }}</td>
                    <td><span class="badge {{ $p->estado == 'Activo' ? 'bg-success' : 'bg-secondary' }}">{{ $p->estado }}</span></td>
                    <td>
                        <a href="/crud/proveedores/{{ $p->id_proveedor }}/editar" class="btn btn-sm btn-warning">Editar</a>
                        <a href="/crud/proveedores/{{ $p->id_proveedor }}/eliminar" class="btn btn-sm btn-danger"
                            onclick="return confirm('¿Eliminar este proveedor?')">Eliminar</a>
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