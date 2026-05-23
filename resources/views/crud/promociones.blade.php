@php
    if (session('rol') !== 'admin') {
        header('Location: /principal');
        exit;
    }
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>AYAFlora – Promociones</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
    :root {
        --rosa:   #7b2d5b;
        --rosa-l: #f5e6ef;
        --rosa-b: #f0dce9;
    }
    body { background: #faf5f8; font-family: 'Segoe UI', sans-serif; }
    .ayaf-nav {
        background: var(--rosa);
        padding: .75rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .ayaf-nav .brand { color: #fff; font-weight: 800; font-size: 1.2rem; text-decoration: none; }
    .ayaf-nav .back-btn {
        color: #fff; text-decoration: none; font-size: .88rem;
        display: flex; align-items: center; gap: 5px; opacity: .85; transition: opacity .2s;
    }
    .ayaf-nav .back-btn:hover { opacity: 1; color: #fff; }
    .page-wrap { max-width: 1100px; margin: 2rem auto; padding: 0 1rem; }
    .card-ayaf { background: #fff; border-radius: 14px; box-shadow: 0 4px 20px rgba(123,45,91,.10); border: none; }
    .card-header-ayaf {
        background: var(--rosa-l); border-bottom: 1.5px solid var(--rosa-b);
        border-radius: 14px 14px 0 0; padding: .9rem 1.2rem;
        display: flex; align-items: center; gap: 8px;
    }
    .card-header-ayaf h5 { margin: 0; font-weight: 700; color: var(--rosa); font-size: 1rem; }
    .table thead th {
        background: var(--rosa-l); color: var(--rosa); font-weight: 700;
        font-size: .82rem; text-transform: uppercase; letter-spacing: .04em; border: none;
    }
    .table tbody tr:hover { background: #fdf5f9; }
    .table td { vertical-align: middle; font-size: .88rem; }
    .badge-activo   { background: #d4edda; color: #1a5c2a; font-size: .75rem; padding: 3px 10px; border-radius: 999px; font-weight: 600; }
    .badge-inactivo { background: #f8d7da; color: #721c24; font-size: .75rem; padding: 3px 10px; border-radius: 999px; font-weight: 600; }
    .pill-desc { background: var(--rosa); color: #fff; font-size: .75rem; font-weight: 700; padding: 3px 12px; border-radius: 999px; }
    .btn-rosa       { background: var(--rosa); color: #fff; border: none; }
    .btn-rosa:hover { background: #5e2246; color: #fff; }
    .btn-edit       { background: #fff3cd; color: #856404; border: 1px solid #ffc107; font-size: .8rem; padding: 3px 10px; border-radius: 6px; }
    .btn-edit:hover { background: #ffc107; color: #fff; }
    .btn-del        { background: #f8d7da; color: #842029; border: 1px solid #f5c6cb; font-size: .8rem; padding: 3px 10px; border-radius: 6px; }
    .btn-del:hover  { background: #dc3545; color: #fff; }
    .form-label { font-size: .85rem; font-weight: 600; color: #4a1b35; }
    .form-control:focus, .form-select:focus {
        border-color: var(--rosa);
        box-shadow: 0 0 0 .2rem rgba(123,45,91,.15);
    }
    .section-divider { border: none; border-top: 1.5px solid var(--rosa-b); margin: 1.5rem 0; }
</style>
</head>
<body>

<nav class="ayaf-nav">
    <a href="/principal" class="brand">🌸 AYAFlora</a>
    <a href="/principal" class="back-btn"><i class="bi bi-arrow-left"></i> Volver</a>
</nav>

<div class="page-wrap">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- FORMULARIO --}}
    <div class="card-ayaf mb-4">
        <div class="card-header-ayaf">
            <i class="bi bi-{{ isset($promocion) ? 'pencil-square' : 'plus-circle-fill' }}" style="color:var(--rosa);font-size:1.1rem;"></i>
            <h5>{{ isset($promocion) ? 'Editar Promoción' : 'Nueva Promoción' }}</h5>
        </div>
        <div class="p-4">
            <form action="{{ isset($promocion) ? '/crud/promociones/'.$promocion->id_promocion.'/actualizar' : '/crud/promociones' }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Título <span class="text-danger">*</span></label>
                        <input type="text" name="titulo" class="form-control" required maxlength="100"
                               placeholder="Ej. Descuento de Graduación"
                               value="{{ isset($promocion) ? $promocion->titulo : old('titulo') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Descuento <span class="text-danger">*</span></label>
                        <input type="text" name="descuento" class="form-control" required maxlength="20"
                               placeholder="Ej. 15% o Gratis"
                               value="{{ isset($promocion) ? $promocion->descuento : old('descuento') }}">
                        <div class="form-text">Puede ser porcentaje o texto (Gratis, 2x1…)</div>
                    </div>
                    @if(isset($promocion))
                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="Activo"   {{ $promocion->estado == 'Activo'   ? 'selected' : '' }}>Activo</option>
                            <option value="Inactivo" {{ $promocion->estado == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                    @endif
                    <div class="col-12">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="2"
                                  placeholder="Describe brevemente la promoción…">{{ isset($promocion) ? $promocion->descripcion : old('descripcion') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">URL de imagen <span class="text-muted fw-normal">(opcional)</span></label>
                        <input type="url" name="imagen" class="form-control"
                               placeholder="https://…"
                               value="{{ isset($promocion) ? $promocion->imagen : old('imagen') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fecha inicio <span class="text-danger">*</span></label>
                        <input type="date" name="fecha_inicio" class="form-control" required
                               value="{{ isset($promocion) ? $promocion->fecha_inicio : old('fecha_inicio') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fecha fin <span class="text-danger">*</span></label>
                        <input type="date" name="fecha_fin" class="form-control" required
                               value="{{ isset($promocion) ? $promocion->fecha_fin : old('fecha_fin') }}">
                    </div>
                </div>
                <hr class="section-divider">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-rosa px-4">
                        <i class="bi bi-{{ isset($promocion) ? 'save' : 'plus-lg' }} me-2"></i>
                        {{ isset($promocion) ? 'Guardar cambios' : 'Agregar promoción' }}
                    </button>
                    @if(isset($promocion))
                        <a href="/crud/promociones" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-x-lg me-1"></i> Cancelar
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- TABLA --}}
    <div class="card-ayaf">
        <div class="card-header-ayaf">
            <i class="bi bi-tag-fill" style="color:var(--rosa);font-size:1.1rem;"></i>
            <h5>Promociones registradas</h5>
            <span class="ms-auto badge" style="background:var(--rosa);color:#fff;border-radius:999px;padding:3px 12px;font-size:.78rem;">
                {{ $promociones->count() }} total
            </span>
        </div>
        <div class="p-0">
            @if($promociones->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-tag" style="font-size:2.5rem;opacity:.3;"></i>
                    <p class="mt-2">No hay promociones registradas aún.</p>
                </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Descuento</th>
                            <th>Descripción</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promociones as $p)
                        <tr>
                            <td class="text-muted" style="font-size:.8rem;">{{ $p->id_promocion }}</td>
                            <td class="fw-600">{{ $p->titulo }}</td>
                            <td><span class="pill-desc">{{ $p->descuento }}</span></td>
                            <td style="max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $p->descripcion ?? '—' }}
                            </td>
                            <td>{{ $p->fecha_inicio ?? '—' }}</td>
                            <td>{{ $p->fecha_fin ?? '—' }}</td>
                            <td>
                                @if($p->estado == 'Activo')
                                    <span class="badge-activo">Activo</span>
                                @else
                                    <span class="badge-inactivo">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center flex-wrap">
                                    <a href="/crud/promociones/{{ $p->id_promocion }}/toggle"
                                       class="btn btn-sm {{ $p->estado == 'Activo' ? 'btn-warning' : 'btn-success' }}">
                                        {{ $p->estado == 'Activo' ? '🔴 Desactivar' : '🟢 Activar' }}
                                    </a>
                                    @if($p->estado == 'Inactivo')
                                    <button class="btn btn-sm btn-info text-white" data-bs-toggle="collapse"
                                            data-bs-target="#reciclar{{ $p->id_promocion }}">
                                        ♻️ Reciclar
                                    </button>
                                    @endif
                                    <a href="/crud/promociones/{{ $p->id_promocion }}/editar" class="btn btn-edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="/crud/promociones/{{ $p->id_promocion }}/eliminar"
                                       class="btn btn-del"
                                       onclick="return confirm('¿Eliminar la promoción «{{ $p->titulo }}»?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                                @if($p->estado == 'Inactivo')
                                <div class="collapse mt-2" id="reciclar{{ $p->id_promocion }}">
                                    <form method="POST" action="/crud/promociones/{{ $p->id_promocion }}/reciclar">
                                        @csrf
                                        <input type="date" name="fecha_inicio" class="form-control form-control-sm mb-1" required>
                                        <input type="date" name="fecha_fin" class="form-control form-control-sm mb-1" required>
                                        <button class="btn btn-sm btn-success w-100">Activar con nuevas fechas</button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const inicio = document.querySelector('[name="fecha_inicio"]').value;
        const fin    = document.querySelector('[name="fecha_fin"]').value;
        if (inicio && fin && fin < inicio) {
            e.preventDefault();
            alert('⚠️ La fecha de fin no puede ser anterior a la fecha de inicio.');
        }
    });
</script>
</body>
</html>