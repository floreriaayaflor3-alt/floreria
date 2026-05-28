<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Principal - AYAFlora</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { min-height:100vh; background-image:url("https://images.unsplash.com/photo-1604400247036-e0b38afce25c"); background-size:cover; background-position:center; }
.fondo { min-height:100vh; background:rgba(255,255,255,0.75); }
.navbar { background:#7b2d5b !important; }
.card-flor { background:white; border-radius:18px; box-shadow:0 4px 15px rgba(0,0,0,0.15); border:none; }
.btn-flor { background:#7b2d5b; color:white; border:none; }
.btn-flor:hover { background:#5f2146; color:white; }
.producto-img { height:180px; object-fit:cover; border-radius:15px 15px 0 0; }

/* CARRUSEL PROMOCIONES */
.promo-box { background:white; border-radius:18px; box-shadow:0 4px 15px rgba(0,0,0,0.15); padding:1rem 1rem 0.5rem; position:sticky; top:20px; }
.promo-box h2 { font-size:1.1rem; font-weight:700; color:#7b2d5b; margin-bottom:12px; padding-bottom:10px; border-bottom:2px solid #f0dce9; }
.promo-ventana { position:relative; height:520px; overflow:hidden; }
.promo-ventana::before, .promo-ventana::after { content:''; position:absolute; left:0; right:0; height:45px; z-index:2; pointer-events:none; }
.promo-ventana::before { top:0; background:linear-gradient(to bottom, white 0%, transparent 100%); }
.promo-ventana::after  { bottom:0; background:linear-gradient(to top, white 0%, transparent 100%); }
.promo-pista { display:flex; flex-direction:column; gap:10px; animation:subirPromos 18s linear infinite; will-change:transform; }
.promo-pista:hover { animation-play-state:paused; }
@keyframes subirPromos { 0% { transform:translateY(0px); } 100% { transform:translateY(-50%); } }
a.promo-tarjeta { background:#fdf5f9; border:1.5px solid #f0dce9; border-radius:13px; padding:0.8rem 0.9rem; display:flex; align-items:flex-start; gap:10px; text-decoration:none; color:inherit; flex-shrink:0; transition:border-color .25s, transform .25s, background .25s; }
a.promo-tarjeta:hover { border-color:#7b2d5b; transform:translateX(4px); background:#fff0f7; }
.promo-icono { width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.3rem; flex-shrink:0; }
.pi-0{background:#f5e6ef;} .pi-1{background:#e8f4fd;} .pi-2{background:#eaf3de;} .pi-3{background:#faeeda;}
.promo-body { flex:1; min-width:0; }
.promo-nombre { font-weight:700; font-size:.85rem; color:#4a1b35; margin:0 0 3px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.promo-desc { font-size:.75rem; color:#8a6070; margin:0 0 7px; line-height:1.35; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.promo-badge-desc { display:inline-block; font-size:.72rem; font-weight:700; padding:3px 12px; border-radius:999px; color:white; }
.pb-0{background:#7b2d5b;} .pb-1{background:#1a6aad;} .pb-2{background:#3B6D11;} .pb-3{background:#a0600e;}
.promo-fecha { font-size:.68rem; color:#b09aa8; margin:5px 0 0; }
.promo-pausa-hint { text-align:center; font-size:.65rem; color:#c0a0b0; padding:6px 0 2px; }

/* PANEL VENDEDOR */
.acceso-card { transition:transform .2s, box-shadow .2s; text-decoration:none; color:inherit; display:block; }
.acceso-card:hover .card-flor { transform:translateY(-3px); box-shadow:0 8px 25px rgba(123,45,91,0.2) !important; }
.folio-tag { font-family:monospace; font-size:.8rem; background:#f0dce9; color:#7b2d5b; padding:2px 8px; border-radius:6px; font-weight:700; }
.btn-ver-sm { background:#f5e6ef; color:#7b2d5b; border:1.5px solid #f0dce9; font-size:.75rem; padding:3px 10px; border-radius:7px; text-decoration:none; transition:.2s; }
.btn-ver-sm:hover { background:#7b2d5b; color:white; }
</style>
</head>
<body>
<div class="fondo">

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/principal">🌸 AYAFlora</a>
        <div class="navbar-nav ms-auto">
            @if(session('rol') == 'admin')
                <a class="nav-link" href="/crud/productos">Productos</a>
                <a class="nav-link" href="/crud/insumos">Insumos</a>
                <a class="nav-link" href="/crud/proveedores">Proveedores</a>
                <a class="nav-link" href="/crud/clientes">Clientes</a>
                <a class="nav-link" href="/crud/trabajadores">Trabajadores</a>
                <a class="nav-link" href="/crud/promociones">Promociones</a>
            @endif
            @if(session('rol') == 'cliente')
                <a class="nav-link" href="/ubicacion">📍 Ubicación</a>
                <a class="nav-link" href="/mis-pedidos">📦 Mis pedidos</a>
                <a class="nav-link" href="/carrito">🛒 Carrito</a>
            @endif
            @if(session('rol') == 'vendedor')
                <a class="nav-link" href="/venta">Vender</a>
                <a class="nav-link" href="/venta/historial">Historial</a>
            @endif
            @if(session('rol') == 'cajero')
                <a class="nav-link" href="/cobro">Cobrar</a>
                <a class="nav-link" href="/cobro/historial">Historial</a>
            @endif
            <a class="nav-link text-warning" href="/logout">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container py-5">

    <div class="card card-flor p-4 mb-4">
        <h1>Bienvenido a AYAFlora 🌸</h1>
        <p class="mb-0">Has iniciado sesión como: <strong>{{ session('rol') }}</strong></p>
    </div>

    {{-- ══════════ ADMIN ══════════ --}}
    @if(session('rol') == 'admin')
        <div class="row g-4">
            <div class="col-md-4 col-lg-2">
                <div class="card card-flor p-4 text-center"><h4>📦 Productos</h4><p>Administra el catálogo.</p><a href="/crud/productos" class="btn btn-flor">Entrar</a></div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card card-flor p-4 text-center"><h4>🌿 Insumos</h4><p>Flores, listones y materiales.</p><a href="/crud/insumos" class="btn btn-flor">Entrar</a></div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card card-flor p-4 text-center"><h4>🚚 Proveedores</h4><p>Gestiona proveedores.</p><a href="/crud/proveedores" class="btn btn-flor">Entrar</a></div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card card-flor p-4 text-center"><h4>👥 Clientes</h4><p>Consulta y administra clientes.</p><a href="/crud/clientes" class="btn btn-flor">Entrar</a></div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card card-flor p-4 text-center"><h4>👷 Trabajadores</h4><p>Vendedores y cajeros.</p><a href="/crud/trabajadores" class="btn btn-flor">Entrar</a></div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card card-flor p-4 text-center"><h4>🎉 Promociones</h4><p>Gestiona promociones activas.</p><a href="/crud/promociones" class="btn btn-flor">Entrar</a></div>
            </div>
        </div>

        {{-- Resumen del día --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card card-flor p-3 text-center" style="border-top:3px solid #7b2d5b;">
                    <p class="text-muted small mb-1">Ventas hoy</p>
                    <h3 class="fw-bold mb-0" style="color:#7b2d5b;">{{ $countHoy }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-flor p-3 text-center" style="border-top:3px solid #198754;">
                    <p class="text-muted small mb-1">Total recaudado hoy</p>
                    <h3 class="fw-bold mb-0 text-success">${{ number_format($totalHoy, 2) }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-flor p-3 text-center" style="border-top:3px solid #1a6aad;">
                    <p class="text-muted small mb-1">Total del mes</p>
                    <h3 class="fw-bold mb-0" style="color:#1a6aad;">${{ number_format($totalMes, 2) }}</h3>
                </div>
            </div>
        </div>

        {{-- Últimas ventas --}}
        <div class="card card-flor p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0" style="color:#7b2d5b;">🕐 Mis últimas ventas</h5>
                <a href="/venta/historial" class="btn btn-sm btn-flor">Ver todas</a>
            </div>
            @if($ultimas->isEmpty())
                <p class="text-muted text-center py-3 mb-0">Aún no tienes ventas registradas.</p>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f5e6ef;">
                        <tr>
                            <th style="color:#7b2d5b;font-size:.78rem;">Folio</th>
                            <th style="color:#7b2d5b;font-size:.78rem;">Fecha</th>
                            <th style="color:#7b2d5b;font-size:.78rem;">Cliente</th>
                            <th style="color:#7b2d5b;font-size:.78rem;">Método</th>
                            <th style="color:#7b2d5b;font-size:.78rem;" class="text-end">Total</th>
                            <th style="color:#7b2d5b;font-size:.78rem;" class="text-center">Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ultimas as $v)
                        <tr>
                            <td><span class="folio-tag">{{ $v->folio }}</span></td>
                            <td style="font-size:.83rem;">{{ \Carbon\Carbon::parse($v->fecha)->format('d/m/Y H:i') }}</td>
                            <td style="font-size:.83rem;">{{ $v->nombre_cliente ?? 'Sin registro' }}</td>
                            <td style="font-size:.83rem;">{{ $v->metodo_nombre }}</td>
                            <td class="text-end fw-bold" style="font-size:.85rem;">${{ number_format($v->total, 2) }}</td>
                            <td class="text-center">
                                <span style="background:{{ $v->estado=='Pagado'?'#d4edda':'#fff3cd' }};color:{{ $v->estado=='Pagado'?'#1a5c2a':'#856404' }};border-radius:999px;padding:3px 10px;font-size:.72rem;font-weight:600;">
                                    {{ $v->estado }}
                                </span>
                            </td>
                            <td><a href="/venta/comprobante/{{ $v->id_venta }}" class="btn-ver-sm">Ver</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>


    {{-- ══════════ CLIENTE ══════════ --}}
    @elseif(session('rol') == 'cliente')

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('promo_aplicada'))
        <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <span style="font-size:1.3rem">🎉</span>
            <span>Promoción <strong>{{ session('promo_aplicada')['titulo'] }}</strong> guardada. Ve al <a href="/carrito" class="fw-bold text-dark">carrito</a> para verla.</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row">
            <div class="col-md-9">
                <h2 class="mb-4">Catálogo de productos</h2>
                @php $categorias = $productos->pluck('nombre_categoria')->unique(); @endphp
                @foreach($categorias as $categoria)
                    <h4 class="mt-4 mb-3">{{ $categoria }}</h4>
                    <div class="row g-4 mb-3">
                        @foreach($productos->where('nombre_categoria', $categoria) as $p)
                        <div class="col-md-4">
                            <div class="card card-flor">
                                @if($p->imagen)
                                    <img src="{{ $p->imagen }}" class="producto-img">
                                @else
                                    <div class="producto-img d-flex align-items-center justify-content-center bg-light"><span style="font-size:3rem">🌸</span></div>
                                @endif
                                <div class="card-body">
                                    <h5>{{ $p->nombre }}</h5>
                                    <p class="text-muted small">{{ $p->descripcion }}</p>
                                    <p class="fw-bold">${{ number_format($p->precio, 2) }}</p>
                                    <form method="POST" action="/carrito/agregar">
                                        @csrf
                                        <input type="hidden" name="id_producto" value="{{ $p->id_producto }}">
                                        <button class="btn btn-flor w-100">🛒 Agregar al carrito</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <div class="col-md-3">
                <div class="promo-box">
                    <h2>🎉 Promociones</h2>
                    @if($promociones->isEmpty())
                        <p class="text-muted text-center py-3">Sin promociones activas</p>
                    @else
                        @php $iconos = ['🌸','🎓','🎁','💐','🌻','🎀']; @endphp
                        <div class="promo-ventana">
                            <div class="promo-pista">
                                @foreach($promociones as $promo)
                                @php $i = $loop->index % 4; @endphp
                                <a href="/promocion/{{ $promo->id_promocion }}/aplicar" class="promo-tarjeta">
                                    <div class="promo-icono pi-{{ $i }}">{{ $iconos[$loop->index % count($iconos)] }}</div>
                                    <div class="promo-body">
                                        <p class="promo-nombre">{{ $promo->titulo }}</p>
                                        <p class="promo-desc">{{ $promo->descripcion }}</p>
                                        <span class="promo-badge-desc pb-{{ $i }}">{{ $promo->descuento }}</span>
                                        @if($promo->fecha_fin)<p class="promo-fecha">📅 Válido hasta: {{ $promo->fecha_fin }}</p>@endif
                                    </div>
                                </a>
                                @endforeach
                                @foreach($promociones as $promo)
                                @php $i = $loop->index % 4; @endphp
                                <a href="/promocion/{{ $promo->id_promocion }}/aplicar" class="promo-tarjeta">
                                    <div class="promo-icono pi-{{ $i }}">{{ $iconos[$loop->index % count($iconos)] }}</div>
                                    <div class="promo-body">
                                        <p class="promo-nombre">{{ $promo->titulo }}</p>
                                        <p class="promo-desc">{{ $promo->descripcion }}</p>
                                        <span class="promo-badge-desc pb-{{ $i }}">{{ $promo->descuento }}</span>
                                        @if($promo->fecha_fin)<p class="promo-fecha">📅 Válido hasta: {{ $promo->fecha_fin }}</p>@endif
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        <p class="promo-pausa-hint">✋ Pasa el cursor para pausar</p>
                    @endif
                </div>
            </div>
        </div>

    {{-- ══════════ VENDEDOR ══════════ --}}
    @elseif(session('rol') == 'vendedor')

        {{-- Accesos rápidos --}}
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <a href="/venta" class="acceso-card">
                    <div class="card card-flor p-4 d-flex flex-row align-items-center gap-3" style="border-left:4px solid #7b2d5b;">
                        <div style="background:#f5e6ef;border-radius:14px;width:56px;height:56px;display:flex;align-items:center;justify-content:center;font-size:1.7rem;flex-shrink:0;">🛒</div>
                        <div>
                            <h5 class="mb-0 fw-bold" style="color:#7b2d5b;">Realizar venta</h5>
                            <p class="text-muted mb-0 small">Registrar nueva venta a cliente</p>
                        </div>
                        <span class="ms-auto text-muted fs-5">›</span>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="/venta/historial" class="acceso-card">
                    <div class="card card-flor p-4 d-flex flex-row align-items-center gap-3" style="border-left:4px solid #1a6aad;">
                        <div style="background:#e8f4fd;border-radius:14px;width:56px;height:56px;display:flex;align-items:center;justify-content:center;font-size:1.7rem;flex-shrink:0;">📋</div>
                        <div>
                            <h5 class="mb-0 fw-bold" style="color:#1a6aad;">Historial de ventas</h5>
                            <p class="text-muted mb-0 small">Ver todas tus ventas registradas</p>
                        </div>
                        <span class="ms-auto text-muted fs-5">›</span>
                    </div>
                </a>
            </div>
        </div>

        {{-- Resumen del día --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card card-flor p-3 text-center" style="border-top:3px solid #7b2d5b;">
                    <p class="text-muted small mb-1">Ventas hoy</p>
                    <h3 class="fw-bold mb-0" style="color:#7b2d5b;">{{ $countHoy }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-flor p-3 text-center" style="border-top:3px solid #198754;">
                    <p class="text-muted small mb-1">Total recaudado hoy</p>
                    <h3 class="fw-bold mb-0 text-success">${{ number_format($totalHoy, 2) }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-flor p-3 text-center" style="border-top:3px solid #1a6aad;">
                    <p class="text-muted small mb-1">Total del mes</p>
                    <h3 class="fw-bold mb-0" style="color:#1a6aad;">${{ number_format($totalMes, 2) }}</h3>
                </div>
            </div>
        </div>

        {{-- Últimas ventas --}}
        <div class="card card-flor p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0" style="color:#7b2d5b;">🕐 Mis últimas ventas</h5>
                <a href="/venta/historial" class="btn btn-sm btn-flor">Ver todas</a>
            </div>
            @if($ultimas->isEmpty())
                <p class="text-muted text-center py-3 mb-0">Aún no tienes ventas registradas.</p>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f5e6ef;">
                        <tr>
                            <th style="color:#7b2d5b;font-size:.78rem;">Folio</th>
                            <th style="color:#7b2d5b;font-size:.78rem;">Fecha</th>
                            <th style="color:#7b2d5b;font-size:.78rem;">Cliente</th>
                            <th style="color:#7b2d5b;font-size:.78rem;">Método</th>
                            <th style="color:#7b2d5b;font-size:.78rem;" class="text-end">Total</th>
                            <th style="color:#7b2d5b;font-size:.78rem;" class="text-center">Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ultimas as $v)
                        <tr>
                            <td><span class="folio-tag">{{ $v->folio }}</span></td>
                            <td style="font-size:.83rem;">{{ \Carbon\Carbon::parse($v->fecha)->format('d/m/Y H:i') }}</td>
                            <td style="font-size:.83rem;">{{ $v->nombre_cliente ?? 'Sin registro' }}</td>
                            <td style="font-size:.83rem;">{{ $v->metodo_nombre }}</td>
                            <td class="text-end fw-bold" style="font-size:.85rem;">${{ number_format($v->total, 2) }}</td>
                            <td class="text-center">
                                <span style="background:{{ $v->estado=='Pagado'?'#d4edda':'#fff3cd' }};color:{{ $v->estado=='Pagado'?'#1a5c2a':'#856404' }};border-radius:999px;padding:3px 10px;font-size:.72rem;font-weight:600;">
                                    {{ $v->estado }}
                                </span>
                            </td>
                            <td><a href="/venta/comprobante/{{ $v->id_venta }}" class="btn-ver-sm">Ver</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

    {{-- ══════════ CAJERO ══════════ --}}
    @elseif(session('rol') == 'cajero')
        <div class="card card-flor p-4">
            <h2>Panel de cajero</h2>
            <p>Aquí puedes cobrar pedidos y confirmar pagos.</p>
            <div class="mt-3">
                <a href="/cobro" class="btn btn-flor me-2">💰 Cobros pendientes</a>
                <a href="/cobro/historial" class="btn btn-secondary">📋 Ver historial</a>
            </div>
        </div>

    @else
        <div class="card card-flor p-4">
            <h2>Rol no reconocido</h2>
            <p>Tu usuario no tiene un rol válido asignado.</p>
        </div>
    @endif

</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>