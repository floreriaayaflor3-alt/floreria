<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Nueva contraseña - AYAFlora</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background-image:url("https://images.unsplash.com/photo-1604400247036-e0b38afce25c");
    background-size:cover;
}
.card-flor{
    background:white;
    padding:30px;
    border-radius:15px;
    width:380px;
}
</style>
</head>
<body>
<div class="card-flor">
    <h3 class="text-center">🌸 AYAFlora</h3>
    <p class="text-center text-muted">Crear nueva contraseña</p>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="/recuperar/reset/{{ $token }}">
        @csrf
        <input type="password" name="password" class="form-control mb-3" placeholder="Nueva contraseña" required minlength="4">
        <input type="password" name="password_confirmation" class="form-control mb-3" placeholder="Confirmar contraseña" required>
        <button class="btn w-100 text-white" style="background:#7b2d5b;">Guardar nueva contraseña</button>
    </form>
</div>
</body>
</html>