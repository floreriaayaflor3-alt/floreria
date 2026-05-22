<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Pago - AYAFlora</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://js.stripe.com/v3/"></script>
<style>
body{
    min-height:100vh;
    background-image:url("https://images.unsplash.com/photo-1604400247036-e0b38afce25c");
    background-size:cover;
    background-position:center;
}
.fondo{ min-height:100vh; background:rgba(255,255,255,0.75); }
.navbar{ background:#7b2d5b !important; }
.card-flor{ background:white; border-radius:18px; box-shadow:0 4px 15px rgba(0,0,0,0.15); border:none; }
.btn-flor{ background:#7b2d5b; color:white; border:none; }
.btn-flor:hover{ background:#5f2146; color:white; }
#card-element {
    background: #f8f9fa;
    border: 1.5px solid #dee2e6;
    border-radius: 10px;
    padding: 14px;
    font-size: 1rem;
    transition: border-color 0.2s;
}
#card-element.StripeElement--focus {
    border-color: #7b2d5b;
    box-shadow: 0 0 0 3px rgba(123,45,91,0.15);
}
#card-errors {
    color: #dc3545;
    font-size: 0.85rem;
    margin-top: 6px;
    min-height: 20px;
}
.stripe-logo {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.78rem;
    color: #888;
    margin-top: 10px;
}
.metodo-card {
    border: 2px solid #f0dce9;
    border-radius: 12px;
    padding: 12px 16px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: all 0.2s;
}
.metodo-card:hover { border-color: #7b2d5b; background: #fdf5f9; }
.metodo-card.selected { border-color: #7b2d5b; background: #fdf5f9; }
.metodo-card input { display: none; }
#stripe-section { display: none; margin-top: 16px; }
</style>
</head>
<body>
<div class="fondo">

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/principal">🌸 AYAFlora</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="/carrito">🛒 Carrito</a>
            <a class="nav-link text-warning" href="/logout">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row g-4">

        <div class="col-md-7">
            <div class="card card-flor p-4 mb-4">
                <h4>📋 Resumen del pedido</h4>
                <table class="table mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->cantidad }}</td>
                            <td>${{ number_format($item->precio, 2) }}</td>
                            <td>${{ number_format($item->cantidad * $item->precio, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card card-flor p-4" style="border-left: 4px solid #7b2d5b;">
                <h6 class="fw-bold mb-3">🧪 Tarjetas de prueba Stripe</h6>
                <table class="table table-sm mb-0">
                    <thead><tr><th>Número</th><th>Resultado</th></tr></thead>
                    <tbody>
                        <tr><td><code>4242 4242 4242 4242</code></td><td>✅ Pago aprobado</td></tr>
                        <tr><td><code>4000 0000 0000 9995</code></td><td>❌ Pago rechazado</td></tr>
                        <tr><td><code>4000 0025 0000 3155</code></td><td>🔐 Requiere autenticación</td></tr>
                    </tbody>
                </table>
                <p class="text-muted mb-0 mt-2" style="font-size:0.78rem">
                    Fecha: cualquier fecha futura · CVV: cualquier 3 dígitos
                </p>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card card-flor p-4">
                <h4 class="mb-3">💳 Método de pago</h4>

                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @foreach($metodos as $m)
                <div class="metodo-card {{ $loop->first ? 'selected' : '' }}"
                     onclick="seleccionarMetodo(this, {{ $m->id_metodo }}, '{{ strtolower($m->nombre) }}')">
                    <input type="radio" name="id_metodo" value="{{ $m->id_metodo }}"
                           {{ $loop->first ? 'checked' : '' }}>
                    <span>
                        @if(str_contains(strtolower($m->nombre), 'tarjeta') || str_contains(strtolower($m->nombre), 'crédito') || str_contains(strtolower($m->nombre), 'débito'))
                            💳
                        @elseif(str_contains(strtolower($m->nombre), 'efectivo') || str_contains(strtolower($m->nombre), 'oxxo'))
                            💵
                        @elseif(str_contains(strtolower($m->nombre), 'transferencia'))
                            🏦
                        @else
                            💰
                        @endif
                        <strong>{{ $m->nombre }}</strong>
                    </span>
                </div>
                @endforeach

                <div id="stripe-section">
                    <label class="form-label fw-bold mt-2">Datos de tu tarjeta</label>
                    <div id="card-element"></div>
                    <div id="card-errors"></div>
                    <div class="stripe-logo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="16" viewBox="0 0 60 25">
                            <path d="M59.64 14.28h-8.06c.19 1.93 1.6 2.55 3.2 2.55 1.64 0 2.96-.37 4.05-.95v3.32a10.4 10.4 0 0 1-4.56.95c-4.01 0-6.83-2.5-6.83-7.48 0-4.19 2.39-7.52 6.3-7.52 3.92 0 5.96 3.28 5.96 7.5 0 .4-.04 1.13-.06 1.63zm-5.9-5.2c-1.08 0-2.27.76-2.27 2.58h4.54c0-1.82-1.19-2.58-2.27-2.58zM40.18 10.6c0-1.44 1.18-2 3.16-2 2.7 0 4.56.8 4.56.8V5.57S46.1 5 43.06 5c-4.36 0-6.34 2.27-6.34 5.15 0 5.06 6.57 4.26 6.57 6.44 0 1.7-1.48 2.24-3.54 2.24-2.35 0-4.73-.97-4.73-.97v3.68s2.12.84 5.07.84c4.2 0 6.68-2.08 6.68-5.29 0-5.35-6.59-4.49-6.59-6.49zM28.54 5l-2.82 10.65L22.9 5h-4.45l4.72 14.93h5.36L33.25 5h-4.71zM14.25 5h-4.1v14.93h4.1V5zM12.2.5a2.38 2.38 0 1 0 0 4.76A2.38 2.38 0 0 0 12.2.5z" fill="#6772E5"/>
                        </svg>
                        Pago seguro con Stripe
                    </div>
                </div>

                <hr>
                <p class="mb-1">Subtotal: <strong>${{ number_format($subtotal, 2) }}</strong></p>
                @if(isset($descuento) && $descuento > 0)
                <p class="mb-1 text-success">Descuento: <strong>-${{ number_format($descuento, 2) }}</strong></p>
                @endif
                <p class="mb-1">IVA (16%): <strong>${{ number_format($iva, 2) }}</strong></p>
                <h5 class="mt-2">Total: <strong>${{ number_format($total, 2) }}</strong></h5>

                <form id="form-normal" method="POST" action="/pago/procesar">
                    @csrf
                    <input type="hidden" name="id_metodo" id="id_metodo_normal" value="{{ $metodos->first()->id_metodo ?? '' }}">
                    <button type="submit" class="btn btn-flor w-100 mt-3" id="btn-normal">✅ Confirmar pago</button>
                </form>

                <form id="form-stripe" method="POST" action="/pago/stripe">
                    @csrf
                    <input type="hidden" name="id_metodo" id="id_metodo_stripe" value="">
                    <input type="hidden" name="stripeToken" id="stripeToken">
                    <button type="button" onclick="pagarStripe()" class="btn btn-flor w-100 mt-3" id="btn-stripe" style="display:none">
                        💳 Pagar ${{ number_format($total, 2) }} con Stripe
                    </button>
                </form>

                <a href="/carrito" class="btn btn-secondary w-100 mt-2">← Volver al carrito</a>
            </div>
        </div>

    </div>
</div>
</div>

<script>
const stripePublicKey = '{{ $stripeKey }}';
let stripe      = null;
let elements    = null;
let cardElement = null;

window.addEventListener('DOMContentLoaded', () => {

    // ── Inicializar Stripe ──────────────────────────────────────────
    if (!stripePublicKey) {
        console.error('Clave pública de Stripe no encontrada.');
    } else {
        stripe   = Stripe(stripePublicKey);
        elements = stripe.elements();

        cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    '::placeholder': { color: '#aab7c4' }
                },
                invalid: { color: '#dc3545' }
            }
        });

        cardElement.mount('#card-element');

        cardElement.on('change', e => {
            document.getElementById('card-errors').textContent =
                e.error ? e.error.message : '';
        });
    }

    // ── Revisar método seleccionado por defecto ─────────────────────
    const primera = document.querySelector('.metodo-card');
    if (primera) {
        const id     = primera.querySelector('input').value;
        const nombre = primera.querySelector('strong').textContent.toLowerCase();
        verificarStripe(id, nombre);
    }
});

function seleccionarMetodo(el, id, nombre) {
    document.querySelectorAll('.metodo-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    verificarStripe(id, nombre);
}

function verificarStripe(id, nombre) {
    const esStripe = nombre.includes('tarjeta') || nombre.includes('crédito') ||
                     nombre.includes('debito')   || nombre.includes('débito')  ||
                     nombre.includes('credit')   || nombre.includes('debit');

    document.getElementById('stripe-section').style.display = esStripe ? 'block' : 'none';
    document.getElementById('btn-stripe').style.display     = esStripe ? 'block' : 'none';
    document.getElementById('btn-normal').style.display     = esStripe ? 'none'  : 'block';

    document.getElementById('id_metodo_normal').value = id;
    document.getElementById('id_metodo_stripe').value = id;
}

async function pagarStripe() {
    if (!stripe || !cardElement) {
        alert('Stripe no está inicializado correctamente. Verifica la clave pública.');
        return;
    }

    const btn = document.getElementById('btn-stripe');
    btn.disabled    = true;
    btn.textContent = 'Procesando...';

    const { token, error } = await stripe.createToken(cardElement);

    if (error) {
        document.getElementById('card-errors').textContent = error.message;
        btn.disabled    = false;
        btn.innerHTML   = '💳 Pagar ${{ number_format($total, 2) }} con Stripe';
    } else {
        document.getElementById('stripeToken').value = token.id;
        document.getElementById('form-stripe').submit();
    }
}
</script>

</body>
</html>