<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Historial de Ventas – AYAFlora</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root { --rosa:#7b2d5b; --rosa-d:#5e2246; --rosa-l:#f5e6ef; --rosa-b:#f0dce9; }
    body { background:#faf5f8; font-family:'DM Sans',sans-serif; }

    .ayaf-nav { background:var(--rosa); padding:.7rem 1.5rem; display:flex; align-items:center; justify-content:space-between; box-shadow:0 2px 12px rgba(123,45,91,.3); }
    .ayaf-nav .brand { color:#fff; font-family:'DM Serif Display',serif; font-size:1.3rem; text-decoration:none; }
    .ayaf-nav a { color:rgba(255,255,255,.85); text-decoration:none; font-size:.85rem; padding:6px 14px; border-radius:20px; transition:.2s; }
    .ayaf-nav a:hover { background:rgba(255,255,255,.15); color:#fff; }
    .ayaf-nav a.active { background:rgba(255,255,255,.2); color:#fff; }

    .page { max-width:1100px; margin:2rem auto; padding:0 1rem; }

    /* Stats */
    .stats-row { display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:1.5rem; }
    .stat-card {
        background:#fff; border-radius:14px;
        padding:1.1rem 1.3rem;
        box-shadow:0 4px 16px rgba(123,45,91,.08);
        display:flex; align-items:center; gap:12px;
    }
    .stat-icon { width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.3rem; flex-shrink:0; }
    .stat-icon.rosa { background:var(--rosa-l); }
    .stat-icon.green { background:#e8f5e9; }
    .stat-icon.blue  { background:#e3f2fd; }
    .stat-info label { font-size:.72rem; font-weight:700; color:#8a6070; text-transform:uppercase; letter-spacing:.04em; display:block; }
    .stat-info span  { font-size:1.25rem; font-weight:700; color:#2d1020; }

    /* Card tabla */
    .card-ayaf { background:#fff; border-radius:16px; box-shadow:0 4px 24px rgba(123,45,91,.08); border:none; }
    .card-head { background:var(--rosa-l); border-bottom:1.5px solid var(--rosa-b); border-radius:16px 16px 0 0; padding:.9rem 1.3rem; display:flex; align-items:center; gap:9px; }
    .card-head h5 { margin:0; font-weight:700; color:var(--rosa); font-size:1rem; }

    /* Filtro */
    .filtro-bar { display:flex; gap:.6rem; align-items:center; flex-wrap:wrap; padding:1rem 1.3rem; border-bottom:1px solid #f0dce9; }
    .filtro-bar input, .filtro-bar select { font-size:.83rem; border-radius:8px; border:1.5px solid #e0c8d8; padding:5px 10px; }
    .filtro-bar input:focus, .filtro-bar select:focus { border-color:var(--rosa); outline:none; box-shadow:0 0 0 .15rem rgba(123,45,91,.1); }

    /* Tabla */
    .tabla-hist thead th { background:var(--rosa-l); color:var(--rosa); font-size:.78rem; text-transform:uppercase; letter-spacing:.04em; border:none; font-weight:700; padding:.7rem 1rem; }
    .tabla-hist td { font-size:.86rem; vertical-align:middle; padding:.65rem 1rem; }
    .tabla-hist tbody tr:hover { background:#fdf5f9; }

    /* Badges */
    .badge-pagado    { background:#d4edda; color:#1a5c2a; font-size:.73rem; padding:3px 10px; border-radius:999px; font-weight:600; }
    .badge-pendiente { background:#fff3cd; color:#856404; font-size:.73rem; padding:3px 10px; border-radius:999px; font-weight:600; }
    .badge-cancelado { background:#f8d7da; color:#721c24; font-size:.73rem; padding:3px 10px; border-radius:999px; font-weight:600; }

    .folio-tag { font-family:monospace; font-size:.82rem; background:#f0dce9; color:var(--rosa); padding:2px 8px; border-radius:6px; font-weight:700; }

    .btn-ver { background:var(--rosa-l); color:var(--rosa); border:1.5px solid var(--rosa-b); font-size:.78rem; padding:3px 10px; border-radius:7px; font-weight:600; text-decoration:none; transition:.2s; }
    .btn-ver:hover { background:var(--rosa); color:#fff; }

    .empty-state { text-align:center; padding:3rem; color:#b09aa8; }
    .empty-state i { font-size:3rem; opacity:.3; display:block; margin-bottom:.5rem; }
</style>
</head>
<body>

<nav class="ayaf-nav">
    <a href="/principal" class="brand">🌸 AYAFlora</a>
    <div style="display:flex;gap:6px;">
        <a href="/venta"><i class="bi bi-cart-plus me-1"></i>Nueva venta</a>
        <a href="/venta/historial" class="active"><i class="bi bi-clock-history me-1"></i>Historial</a>
        <a href="/logout" style="color:rgba(255,220,100,.9)!important"><i class="bi bi-box-arrow-right me-1"></i>Salir</a>
    </div>
</nav>

<div class="page">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Stats --}}
    @php
        $totalVentas  = $ventas->count();
        $totalIngresos = $ventas->sum('total');
        $ventasHoy    = $ventas->filter(fn($v) => \Carbon\Carbon::parse($v->fecha)->isToday())->count();
    @endphp
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon rosa">🧾</div>
            <div class="stat-info">
                <label>Total ventas</label>
                <span>{{ $totalVentas }}</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">💰</div>
            <div class="stat-info">
                <label>Ingresos totales</label>
                <span>${{ number_format($totalIngresos, 2) }}</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">📅</div>
            <div class="stat-info">
                <label>Ventas hoy</label>
                <span>{{ $ventasHoy }}</span>
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card-ayaf">
        <div class="card-head">
            <i class="bi bi-table" style="color:var(--rosa);font-size:1.1rem;"></i>
            <h5>Historial de ventas</h5>
            <span class="ms-auto badge" style="background:var(--rosa);color:#fff;border-radius:999px;padding:3px 12px;font-size:.78rem;">
                {{ $totalVentas }} registros
            </span>
        </div>

        {{-- Filtro --}}
        <div class="filtro-bar">
            <input type="text" id="buscar" placeholder="🔍 Buscar folio, cliente…" style="min-width:220px;">
            <select id="filtroEstado">
                <option value="">Todos los estados</option>
                <option value="Pagado">Pagado</option>
                <option value="Pendiente">Pendiente</option>
                <option value="Cancelado">Cancelado</option>
            </select>
        </div>

        @if($ventas->isEmpty())
            <div class="empty-state">
                <i class="bi bi-receipt"></i>
                No hay ventas registradas aún.
            </div>
        @else
        <div class="table-responsive">
            <table class="table tabla-hist mb-0" id="tablaVentas">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Método</th>
                        <th class="text-end">Total</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $v)
                    <tr>
                        <td class="text-muted" style="font-size:.8rem;">{{ $v->id_venta }}</td>
                        <td><span class="folio-tag">{{ $v->folio }}</span></td>
                        <td style="white-space:nowrap;">{{ \Carbon\Carbon::parse($v->fecha)->format('d/m/Y H:i') }}</td>
                        <td>{{ $v->nombre_cliente ?? 'Sin registro' }}</td>
                        <td>{{ $v->metodo_nombre }}</td>
                        <td class="text-end fw-bold">${{ number_format($v->total, 2) }}</td>
                        <td class="text-center">
                            @if($v->estado == 'Pagado')
                                <span class="badge-pagado">Pagado</span>
                            @elseif($v->estado == 'Pendiente')
                                <span class="badge-pendiente">Pendiente</span>
                            @else
                                <span class="badge-cancelado">{{ $v->estado }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="/venta/comprobante/{{ $v->id_venta }}" class="btn-ver">
                                <i class="bi bi-eye me-1"></i>Ver
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Filtro en tiempo real
    const buscar       = document.getElementById('buscar');
    const filtroEstado = document.getElementById('filtroEstado');

    function filtrar() {
        const texto  = buscar.value.toLowerCase();
        const estado = filtroEstado.value.toLowerCase();
        document.querySelectorAll('#tablaVentas tbody tr').forEach(tr => {
            const txt = tr.textContent.toLowerCase();
            const coincideTexto  = txt.includes(texto);
            const coincideEstado = !estado || txt.includes(estado);
            tr.style.display = (coincideTexto && coincideEstado) ? '' : 'none';
        });
    }
    buscar.addEventListener('input', filtrar);
    filtroEstado.addEventListener('change', filtrar);
</script>
</body>
</html>