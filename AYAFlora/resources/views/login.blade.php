<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login - AYAFlora</title>

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
.login-card{
background:white;
padding:30px;
border-radius:15px;
width:350px;
}
</style>
</head>

<body>

<div class="login-card">

<h3 class="text-center">🌸 AYAFlora</h3>

<form method="POST" action="/login">
@csrf

<input type="text" name="usuario" class="form-control mb-3" placeholder="Usuario">

<input type="password" name="password" class="form-control mb-3" placeholder="Contraseña">

<button class="btn btn-primary w-100">Entrar</button>

@if(session('error'))
<p class="text-danger text-center mt-3">
{{ session('error') }}
</p>
@endif

</form>

</div>

</body>
</html>