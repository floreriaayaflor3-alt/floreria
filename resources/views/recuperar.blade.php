<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Recuperar contraseña - AYAFlora</title>
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
    <p class="text-center text-muted">Recuperar contraseña</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="/recuperar">
        @csrf
        <input type="email" name="correo" class="form-control mb-3" placeholder="Tu correo electrónico" required>
        <button class="btn w-100 text-white" style="background:#7b2d5b;">Enviar link de recuperación</button>
        <a href="/login" class="btn btn-link w-100 mt-2 text-center">← Volver al login</a>
    </form>
</div>
</body>
</html>