<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Ubicación - AYAFlora</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
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
#mapa{ height:500px; border-radius:15px; z-index:1; }
.sucursal-card{ cursor:pointer; transition: transform 0.2s; }
.sucursal-card:hover{ transform: scale(1.02); }
.mas-cercana{ border: 3px solid #7b2d5b !important; }
</style>
</head>
<body>
<div class="fondo">

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/principal">🌸 AYAFlora</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="/principal">Catálogo</a>
            <a class="nav-link" href="/mis-pedidos">📦 Mis pedidos</a>
            <a class="nav-link" href="/carrito">🛒 Carrito</a>
            <a class="nav-link text-warning" href="/logout">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container py-5">

    <div class="card card-flor p-4 mb-4">
        <h2>📍 Nuestras Sucursales</h2>
        <p class="text-muted mb-0">Encuentra la sucursal AYAFlora más cercana a ti</p>
    </div>

    <div id="alerta-cercana" class="alert d-none mb-4" style="background:#7b2d5b; color:white; border-radius:15px;">
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card card-flor p-3">
                <div id="mapa"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div id="lista-sucursales">
                <!-- Se llena con JS -->
            </div>
            <button class="btn btn-flor w-100 mt-3" id="btn-ubicacion">
                📍 Encontrar sucursal más cercana
            </button>
        </div>
    </div>

</div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const sucursales = [
    {
        nombre: "AYAFlora Centro",
        direccion: "Centro Histórico, Oaxaca de Juárez",
        telefono: "951 123 4567",
        horario: "Lun-Sáb 9:00 - 7:00 PM",
        lat: 17.0669,
        lng: -96.7203
    },
    {
        nombre: "AYAFlora Santa Rosa Panzacola",
        direccion: "Santa Rosa Panzacola, Oaxaca",
        telefono: "951 234 5678",
        horario: "Lun-Sáb 9:00 - 7:00 PM",
        lat: 17.0750,
        lng: -96.7350
    },
    {
        nombre: "AYAFlora Xoxocotlán",
        direccion: "Santa Cruz Xoxocotlán, Oaxaca",
        telefono: "951 345 6789",
        horario: "Lun-Sáb 9:00 - 7:00 PM",
        lat: 17.0282,
        lng: -96.7263
    },
    {
        nombre: "AYAFlora Colonia Reforma",
        direccion: "Colonia Reforma, Oaxaca de Juárez",
        telefono: "951 456 7890",
        horario: "Lun-Sáb 9:00 - 7:00 PM",
        lat: 17.0600,
        lng: -96.7100
    }
];

// Inicializar mapa centrado en Oaxaca
var mapa = L.map('mapa').setView([17.0600, -96.7200], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(mapa);

// Marcadores de sucursales
var marcadores = [];
sucursales.forEach(function(s, i) {
    var marker = L.marker([s.lat, s.lng])
        .addTo(mapa)
        .bindPopup(`<b>🌸 ${s.nombre}</b><br>${s.direccion}<br>📞 ${s.telefono}<br>🕐 ${s.horario}`);
    marcadores.push(marker);
});

// Llenar lista de sucursales
function llenarLista(cercanaIndex) {
    const lista = document.getElementById('lista-sucursales');
    lista.innerHTML = '';
    sucursales.forEach(function(s, i) {
        const esCercana = i === cercanaIndex;
        lista.innerHTML += `
            <div class="card card-flor p-3 mb-3 sucursal-card ${esCercana ? 'mas-cercana' : ''}" onclick="irASucursal(${i})">
                ${esCercana ? '<span class="badge mb-2" style="background:#7b2d5b">⭐ Más cercana</span><br>' : ''}
                <h6 class="mb-1">🌸 ${s.nombre}</h6>
                <small class="text-muted">${s.direccion}</small><br>
                <small>📞 ${s.telefono}</small><br>
                <small>🕐 ${s.horario}</small>
            </div>
        `;
    });
}

llenarLista(-1);

function irASucursal(i) {
    mapa.setView([sucursales[i].lat, sucursales[i].lng], 16);
    marcadores[i].openPopup();
}

// Calcular distancia en km
function calcularDistancia(lat1, lng1, lat2, lng2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLng = (lng2 - lng1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLng/2) * Math.sin(dLng/2);
    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
}

document.getElementById('btn-ubicacion').addEventListener('click', function() {
    if (!navigator.geolocation) {
        alert('Tu navegador no soporta geolocalización');
        return;
    }
    this.textContent = '⏳ Obteniendo ubicación...';
    navigator.geolocation.getCurrentPosition(function(pos) {
        const userLat = pos.coords.latitude;
        const userLng = pos.coords.longitude;

        // Marcador del usuario
        L.marker([userLat, userLng], {
            icon: L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
            })
        }).addTo(mapa).bindPopup('📍 Tu ubicación').openPopup();

        // Encontrar más cercana
        let minDist = Infinity;
        let cercanaIndex = 0;
        sucursales.forEach(function(s, i) {
            const dist = calcularDistancia(userLat, userLng, s.lat, s.lng);
            if (dist < minDist) {
                minDist = dist;
                cercanaIndex = i;
            }
        });

        const cercana = sucursales[cercanaIndex];
        const distancia = calcularDistancia(userLat, userLng, cercana.lat, cercana.lng);

        // Mostrar alerta
        const alerta = document.getElementById('alerta-cercana');
        alerta.classList.remove('d-none');
        alerta.innerHTML = `⭐ La sucursal más cercana es <strong>${cercana.nombre}</strong> a <strong>${distancia.toFixed(2)} km</strong> de ti.`;

        // Ir a la sucursal más cercana
        mapa.setView([cercana.lat, cercana.lng], 15);
        marcadores[cercanaIndex].openPopup();
        llenarLista(cercanaIndex);

        document.getElementById('btn-ubicacion').textContent = '📍 Encontrar sucursal más cercana';
    }, function() {
        alert('No se pudo obtener tu ubicación. Verifica los permisos del navegador.');
        document.getElementById('btn-ubicacion').textContent = '📍 Encontrar sucursal más cercana';
    });
});
</script>
</body>
</html>