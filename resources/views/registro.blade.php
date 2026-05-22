<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro - AYAFlora</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background-image:
        linear-gradient(rgba(0,0,0,.35), rgba(0,0,0,.35)),
        url("https://plus.unsplash.com/premium_photo-1728877784208-d1c83967c5b5?q=80&w=1469&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D");
    background-size:cover;
    background-position:center;
    font-family:'Segoe UI', sans-serif;
}

.register-wrapper{
    background: rgba(255,255,255,0.25);
    backdrop-filter: blur(12px);
    padding: 35px;
    border-radius: 25px;
    box-shadow: 0 15px 40px rgba(0,0,0,.25);
    border: 1px solid rgba(255,255,255,.35);
}

.register-card{
    background: rgba(255,255,255,.92);
    padding: 30px;
    border-radius: 20px;
    width: 430px;
    box-shadow: 0 8px 25px rgba(0,0,0,.15);
}

.logo{
    width:150px;
    display:block;
    margin:0 auto 10px auto;
}

.title{
    color:#E78F81;
    font-weight:700;
}

.form-control{
    border-radius:12px;
    padding:12px;
}

.input-group-text{
    border-radius:12px 0 0 12px;
    background:#C4D7FF;
    border:none;
}

.btn-ayaflora{
    background:#87A2FF;
    color:white;
    border:none;
    border-radius:12px;
    padding:12px;
    font-weight:600;
}

.btn-ayaflora:hover{
    background:#6f8df5;
    color:white;
}

.links a{
    color:#E78F81;
    text-decoration:none;
    font-weight:600;
}

.eye-btn{
    border-radius:0 12px 12px 0;
    border:1px solid #dee2e6;
    background:white;
}
</style>
</head>

<body>

<div class="register-wrapper">
    <div class="register-card">

        <img src="{{ asset('img/ayaflora-logo.png') }}" class="logo" alt="Logo AYAFlora">

        <h3 class="text-center title">Crear cuenta</h3>
        <p class="text-center text-muted mb-4">
            Regístrate para ingresar a AYAFlora.
        </p>

         <form method="POST" action="/registro">
        @csrf

         <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="bi bi-person-fill"></i>
            </span>
            <input type="text" name="nombre" class="form-control" placeholder="Nombre completo" required>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="bi bi-envelope-fill"></i>
            </span>
            <input type="email" name="correo" class="form-control" placeholder="Correo electrónico" required>
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">
                 <i class="bi bi-phone-fill"></i>
            </span>
            <input type="text" name="telefono" class="form-control" placeholder="Teléfono">
            </div>

        <div class="input-group mb-3">
            <span class="input-group-text">
                 <i class="bi bi-geo-alt-fill"></i>
            </span>
            <input type="text" name="direccion" class="form-control" placeholder="Dirección">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">
                 <i class="bi bi-buildings-fill"></i>
            </span>
            <input type="text" name="colonia" class="form-control" placeholder="Colonia">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text">
                <i class="bi bi-person-badge-fill"></i>
            </span>
            <input type="text" name="usuario" class="form-control" placeholder="Usuario" required>
        </div>

        <div class="input-group mb-3">
                <span class="input-group-text">
                    <i class="bi bi-lock-fill"></i>
                </span>

                <input type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="Contraseña"
                        required>

                <button type="button"
                        class="btn eye-btn"
                        onclick="verPassword()">

                    <i class="bi bi-eye-fill" id="iconoOjo"></i>

                </button>
        </div>

        <button class="btn btn-ayaflora w-100"> 
            Registrarme
        </button>

        </form>

    </div>
</div>

<script>
function verPassword(){
    const password = document.getElementById("password");
    const icono = document.getElementById("iconoOjo");

    if(password.type === "password"){
        password.type = "text";
        icono.classList.remove("bi-eye-fill");
        icono.classList.add("bi-eye-slash-fill");
    }else{
        password.type = "password";
        icono.classList.remove("bi-eye-slash-fill");
        icono.classList.add("bi-eye-fill");
    }
}
</script>

</body>
</html>