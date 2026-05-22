<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Comprobante – AYAFlora</title>
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

    .page { max-width: 800px; margin: 2.5rem auto; padding: 0 1rem; }

    /* Success banner */
    .success-banner {
        background: linear-gradient(135deg, var(--rosa) 0%, #a04070 100%);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        color: #fff;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    .success-banner::before {
        content: '🌸';
        position: absolute; top: -10px; right: 20px;
        font-size: 5rem; opacity: .15;
    }
    .success-banner .check-icon {
        width: 60px; height: 60px;
        background: rgba(255,255,255,.2);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; margin: 0 auto 1rem;
    }
    .success-banner h2 { font-family:'DM Serif Display',serif; font-size:1.6rem; margin:0 0 4px; }
    .success-banner p  { opacity:.85; margin:0; font-size:.9rem; }

    /* Comprobante card */
    .comprobante-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(123,45,91,.1);
        overflow: hidden;
    }
    .comp-header {
        background: var(--rosa-l);
        border-bottom: 1.5px solid var(--rosa-b);
        padding: 1.2rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
    }
    .comp-header .folio { font-family:'DM Serif Display',serif; font-size:1.1rem; color:var(--rosa); }
    .comp-header .fecha { font-size:.82rem; color:#8a6070; }

    .comp-body { padding: 1.5rem; }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .info-item label { font-size:.75rem; font-weight:700; color:#8a6070; text-transform:uppercase; letter-spacing:.04em; display:block; margin-bottom:2px; }
    .info-item span  { font-size:.92rem; font-weight:600; color:#2d1020; }

    /* Tabla */
    .tabla-prod thead th { background:var(--rosa-l); color:var(--rosa); font-size:.78rem; text-transform:uppercase; letter-spacing:.04em; border:none; font-weight:700; }
    .tabla-prod td { font-size:.88rem; vertical-align:middle; }

    /* Totales */
    .totales-comp { background:var(--rosa-l); border-radius:12px; padding:1rem 1.2rem; }
    .totales-comp .t-row { display:flex; justify-content:space-between; margin-bottom:5px; font-size:.88rem; }
    .totales-comp .t-row.final { font-size:1.1rem; font-weight:700; color:var(--rosa); border-top:1.5px solid var(--rosa-b); padding-top:8px; margin-top:4px; }

    /* Botones */
    .btn-rosa  { background:var(--rosa); color:#fff; border:none; border-radius:10px; font-weight:600; }
    .btn-rosa:hover  { background:var(--rosa-d); color:#fff; }

    @media print {
        .ayaf-nav, .no-print { display:none!important; }
        body { background:#fff; }
        .comprobante-card { box-shadow:none; }
        .page { margin:0; max-width:100%; }
    }
</style>
</head>
<body>

<nav class="ayaf-nav">
    <a href="/principal" class="brand">🌸 AYAFlora</a>
    <div style="display:flex;gap:6px;">
        <a href="/venta"><i class="bi bi-cart-plus me-1"></i>Nueva venta</a>
        <a href="/venta/historial"><i class="bi bi-clock-history me-1"></i>Historial</a>
        <a href="/logout" style="color:rgba(255,220,100,.9)!important"><i class="bi bi-box-arrow-right me-1"></i>Salir</a>
    </div>
</nav>

<div class="page">

    {{-- Banner éxito --}}
    <div class="success-banner">
        <div class="check-icon">✅</div>
        <h2>Venta registrada</h2>
        <p>La venta ha sido procesada correctamente</p>
    </div>

    {{-- Comprobante --}}
    <div class="comprobante-card">
        <div class="comp-header">
            <div>
                <div class="folio">🧾 {{ $venta->folio }}</div>
                <div class="fecha"><i class="bi bi-calendar3 me-1"></i>{{ $venta->fecha }}</div>
            </div>
            <span class="badge" style="background:var(--rosa);color:#fff;padding:6px 14px;border-radius:999px;font-size:.78rem;font-weight:700;">
                {{ $venta->estado ?? 'Pagado' }}
            </span>
        </div>

        <div class="comp-body">

            {{-- Info general --}}
            <div class="info-grid">
                <div class="info-item">
                    <label>Cliente</label>
                    <span>{{ $venta->nombre_cliente ?? 'Sin registro' }}</span>
                </div>
                <div class="info-item">
                    <label>Método de pago</label>
                    <span>{{ $venta->metodo_nombre }}</span>
                </div>
            </div>

            {{-- Tabla productos --}}
            <div class="table-responsive mb-4">
                <table class="table tabla-prod mb-0">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cant.</th>
                            <th class="text-end">Precio unit.</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detalle as $d)
                        <tr>
                            <td>{{ $d->nombre }}</td>
                            <td class="text-center">{{ $d->cantidad }}</td>
                            <td class="text-end">${{ number_format($d->precio_unitario, 2) }}</td>
                            <td class="text-end fw-600">${{ number_format($d->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Totales --}}
            <div class="totales-comp mb-4">
                <div class="t-row"><span>Subtotal</span><span>${{ number_format($venta->subtotal, 2) }}</span></div>
                @if(isset($venta->descuento) && $venta->descuento > 0)
                <div class="t-row" style="color:#2e7d32;"><span>Descuento</span><span>-${{ number_format($venta->descuento, 2) }}</span></div>
                @endif
                <div class="t-row"><span>IVA (16%)</span><span>${{ number_format($venta->iva, 2) }}</span></div>
                <div class="t-row final"><span>Total pagado</span><span>${{ number_format($venta->total, 2) }}</span></div>
            </div>

            {{-- Acciones --}}
            <div class="d-flex gap-2 no-print">
                <a href="/venta" class="btn btn-rosa px-4">
                    <i class="bi bi-cart-plus me-2"></i>Nueva venta
                </a>
                <button onclick="window.print()" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-printer me-2"></i>Imprimir
                </button>
                <a href="/venta/historial" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-clock-history me-2"></i>Historial
                </a>
            </div>

        </div>
    </div>

</div>
</body>
</html>