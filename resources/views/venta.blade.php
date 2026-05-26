<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nueva Venta – AYAFlora</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --rosa:    #7b2d5b;
        --rosa-d:  #5e2246;
        --rosa-l:  #f5e6ef;
        --rosa-b:  #f0dce9;
        --gold:    #c9973a;
        --bg:      #faf5f8;
    }
    * { box-sizing: border-box; }
    body { background: var(--bg); font-family: 'DM Sans', sans-serif; min-height: 100vh; }
    .ayaf-nav {
        background: var(--rosa);
        padding: .7rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 2px 12px rgba(123,45,91,.3);
    }
    .ayaf-nav .brand { color:#fff; font-family:'DM Serif Display',serif; font-size:1.3rem; text-decoration:none; display:flex; align-items:center; gap:8px; }
    .ayaf-nav .nav-links { display:flex; gap:6px; }
    .ayaf-nav .nav-links a {
        color:rgba(255,255,255,.8); text-decoration:none; font-size:.85rem;
        padding:6px 14px; border-radius:20px; transition:.2s;
    }
    .ayaf-nav .nav-links a:hover { background:rgba(255,255,255,.15); color:#fff; }
    .ayaf-nav .nav-links a.active { background:rgba(255,255,255,.2); color:#fff; }
    .page { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
    .card-ayaf { background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(123,45,91,.08); border: none; }
    .card-head {
        background: var(--rosa-l); border-bottom: 1.5px solid var(--rosa-b);
        border-radius: 16px 16px 0 0; padding: .9rem 1.3rem;
        display: flex; align-items: center; gap: 9px;
    }
    .card-head h5 { margin:0; font-weight:700; color:var(--rosa); font-size:1rem; }
    .form-label { font-size:.83rem; font-weight:600; color:#4a1b35; margin-bottom:4px; }
    .form-control:focus, .form-select:focus {
        border-color: var(--rosa);
        box-shadow: 0 0 0 .2rem rgba(123,45,91,.12);
    }
    .producto-row {
        background: #fdf5f9; border: 1.5px solid var(--rosa-b);
        border-radius: 12px; padding: .75rem 1rem; margin-bottom: .6rem; transition: border-color .2s;
    }
    .producto-row:hover { border-color: var(--rosa); }
    .totales-box {
        background: var(--rosa-l); border: 1.5px solid var(--rosa-b);
        border-radius: 14px; padding: 1.2rem 1.4rem;
    }
    .totales-box .row-t { display:flex; justify-content:space-between; margin-bottom:6px; font-size:.9rem; }
    .totales-box .row-t.total-final { font-size:1.2rem; font-weight:700; color:var(--rosa); border-top:1.5px solid var(--rosa-b); padding-top:8px; margin-top:4px; }
    .btn-rosa { background:var(--rosa); color:#fff; border:none; border-radius:10px; font-weight:600; }
    .btn-rosa:hover { background:var(--rosa-d); color:#fff; }
    .btn-add { background:#fff; color:var(--rosa); border:1.5px dashed var(--rosa); border-radius:10px; font-weight:600; font-size:.85rem; transition:.2s; }
    .btn-add:hover { background:var(--rosa-l); color:var(--rosa-d); }
    .btn-quitar { background:#f8d7da; color:#842029; border:none; border-radius:8px; width:32px; height:32px; display:flex; align-items:center; justify-content:center; font-size:.85rem; transition:.2s; }
    .btn-quitar:hover { background:#dc3545; color:#fff; }
    .alert-ayaf { border-radius:12px; border:none; }
    .info-transferencia { display:none; margin-top:12px; }
</style>
</head>
<body>

<nav class="ayaf-nav">
    <a href="/principal" class="brand">🌸 AYAFlora</a>
    <div class="nav-links">
        <a href="/venta" class="active"><i class="bi bi-cart-plus me-1"></i>Nueva venta</a>
        <a href="/venta/historial"><i class="bi bi-clock-history me-1"></i>Historial</a>
        <a href="/logout" style="color:rgba(255,220,100,.9)!important"><i class="bi bi-box-arrow-right me-1"></i>Salir</a>
    </div>
</nav>

<div class="page">

    @if(session('error'))
    <div class="alert alert-danger alert-ayaf alert-dismissible fade show mb-3">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form method="POST" action="/venta/procesar" id="formVenta">
        @csrf
        <div class="row g-4">

            <div class="col-lg-8">

                <div class="card-ayaf mb-4">
                    <div class="card-head">
                        <i class="bi bi-person-lines-fill" style="color:var(--rosa);font-size:1.1rem;"></i>
                        <h5>Datos de la venta</h5>
                    </div>
                    <div class="p-4">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label">Cliente</label>
                                <select name="id_usuario_cliente" class="form-select">
                                    <option value="">Sin cliente registrado</option>
                                    @foreach($clientes as $c)
                                        <option value="{{ $c->id_usuario }}">{{ $c->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Método de pago <span class="text-danger">*</span></label>
                                <select name="id_metodo" class="form-select" required id="select-metodo" onchange="verificarTransferencia(this)">
                                    @foreach($metodos as $m)
                                        <option value="{{ $m->id_metodo }}">{{ $m->nombre }}</option>
                                    @endforeach
                                </select>
                                {{-- Info transferencia --}}
                                <div class="info-transferencia" id="info-transferencia">
                                    <div class="p-3 rounded-3 mt-2" style="background:#f5e6ef; border-left: 4px solid #7b2d5b;">
                                        <h6 class="fw-bold mb-2" style="color:#7b2d5b;">🏦 Datos para transferencia</h6>
                                        <p class="mb-1"><strong>Banco:</strong> BBVA</p>
                                        <p class="mb-1"><strong>Titular:</strong> AYAFlora S.A. de C.V.</p>
                                        <p class="mb-1"><strong>CLABE:</strong> 012345678901234567</p>
                                        <p class="mb-1"><strong>Número de cuenta:</strong> 1234567890</p>
                                        <p class="mb-0 text-muted small">⚠️ Solicita al cliente su comprobante de transferencia</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Descuento ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="descuento" class="form-control" value="0" min="0" step="0.01" id="descuento">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-ayaf">
                    <div class="card-head">
                        <i class="bi bi-flower1" style="color:var(--rosa);font-size:1.1rem;"></i>
                        <h5>Productos</h5>
                        <button type="button" class="btn btn-add ms-auto px-3 py-1" id="agregar-producto">
                            <i class="bi bi-plus-lg me-1"></i>Agregar producto
                        </button>
                    </div>
                    <div class="p-4">
                        <div class="row g-1 mb-2 px-1" style="font-size:.75rem;font-weight:700;color:#8a6070;text-transform:uppercase;letter-spacing:.04em;">
                            <div class="col-6">Producto</div>
                            <div class="col-2">Cantidad</div>
                            <div class="col-3">Subtotal</div>
                            <div class="col-1"></div>
                        </div>
                        <div id="productos-container">
                            <div class="producto-row row g-2 align-items-center">
                                <div class="col-6">
                                    <select name="id_producto[]" class="form-select form-select-sm producto-select" required>
                                        <option value="">Selecciona un producto</option>
                                        @foreach($productos as $p)
                                            <option value="{{ $p->id_producto }}" data-precio="{{ $p->precio }}" data-stock="{{ $p->stock }}">
                                                {{ $p->nombre }} — ${{ number_format($p->precio,2) }} (Stock: {{ $p->stock }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <input type="number" name="cantidad[]" class="form-control form-control-sm cantidad-input" value="1" min="1" required>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control form-control-sm subtotal-input" placeholder="$0.00" readonly style="background:#f0dce9;font-weight:700;color:var(--rosa);">
                                </div>
                                <div class="col-1 d-flex justify-content-center">
                                    <button type="button" class="btn-quitar"><i class="bi bi-x"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                <div class="card-ayaf" style="position:sticky;top:1rem;">
                    <div class="card-head">
                        <i class="bi bi-receipt" style="color:var(--rosa);font-size:1.1rem;"></i>
                        <h5>Resumen</h5>
                    </div>
                    <div class="p-4">
                        <div class="totales-box mb-4">
                            <div class="row-t"><span>Subtotal</span><strong id="mostrar-subtotal">$0.00</strong></div>
                            <div class="row-t text-success"><span>Descuento</span><strong id="mostrar-descuento" style="color:#2e7d32;">-$0.00</strong></div>
                            <div class="row-t"><span>IVA (16%)</span><strong id="mostrar-iva">$0.00</strong></div>
                            <div class="row-t total-final"><span>Total</span><strong id="mostrar-total">$0.00</strong></div>
                        </div>
                        <button type="submit" class="btn btn-rosa w-100 py-3" style="font-size:1rem;">
                            <i class="bi bi-check2-circle me-2"></i>Registrar venta
                        </button>
                        <a href="/venta/historial" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="bi bi-clock-history me-1"></i>Ver historial
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function fmt(n) { return '$' + parseFloat(n).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ','); }

function verificarTransferencia(select) {
    const texto = select.options[select.selectedIndex].text.toLowerCase();
    const info = document.getElementById('info-transferencia');
    info.style.display = texto.includes('transferencia') ? 'block' : 'none';
}

function calcularTotales() {
    let subtotal = 0;
    document.querySelectorAll('.producto-row').forEach(row => {
        const select   = row.querySelector('.producto-select');
        const cantidad = parseFloat(row.querySelector('.cantidad-input').value) || 0;
        const precio   = parseFloat(select.selectedOptions[0]?.dataset.precio) || 0;
        const sub      = precio * cantidad;
        row.querySelector('.subtotal-input').value = sub > 0 ? fmt(sub) : '';
        subtotal += sub;
    });
    const descuento = parseFloat(document.getElementById('descuento').value) || 0;
    const base  = subtotal - descuento;
    const iva   = base * 0.16;
    const total = base + iva;
    document.getElementById('mostrar-subtotal').textContent  = fmt(subtotal);
    document.getElementById('mostrar-descuento').textContent = '-' + fmt(descuento);
    document.getElementById('mostrar-iva').textContent       = fmt(iva);
    document.getElementById('mostrar-total').textContent     = fmt(total);
}

document.addEventListener('change', calcularTotales);
document.addEventListener('input',  calcularTotales);

document.getElementById('agregar-producto').addEventListener('click', function () {
    const container = document.getElementById('productos-container');
    const primera   = container.querySelector('.producto-row');
    const nueva     = primera.cloneNode(true);
    nueva.querySelector('.cantidad-input').value  = 1;
    nueva.querySelector('.subtotal-input').value  = '';
    nueva.querySelector('.producto-select').value = '';
    container.appendChild(nueva);
});

document.addEventListener('click', function (e) {
    if (e.target.closest('.btn-quitar')) {
        const rows = document.querySelectorAll('.producto-row');
        if (rows.length > 1) {
            e.target.closest('.producto-row').remove();
            calcularTotales();
        }
    }
});
</script>
</body>
</html>