<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login - AYAFlora</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    min-height:100vh;
    font-family:'Segoe UI', sans-serif;
    background:#fff;
}

.login-page{
    min-height:100vh;
    display:flex;
}

.login-left{
    width:60%;
    min-height:100vh;
    color:black;
    padding:80px 90px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    position:relative;
    overflow:hidden;
    background:
        linear-gradient(135deg, rgba(255, 255, 255, .35), rgba(255, 255, 255, .35)), 
        url("https://images.unsplash.com/photo-1491994336086-44f5d76dd8f2?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D");
    background-size:cover;
    background-position:center;
}

.logo-ayaflora{
    position:absolute;
    top:50px;
    left:50px;
    width:600px;
}

.login-left h1{
    font-size:64px;
    font-weight:800;
    line-height:1.05;
    margin-bottom:30px;
}

.login-left p{
    margin-top:220px;
    width:70%;
    font-size:20px;
    line-height:1.4;
    font-weight:500;
}

.copy{
    position:absolute;
    bottom:40px;
    left:90px;
    font-size:15px;
    opacity:.75;
}

.login-right{
    width:40%;
    min-height:100vh;
    background:white;
    display:flex;
    flex-direction:column;
    justify-content:center;
    padding:70px;
}

.brand{
    font-size:28px;
    font-weight:800;
    margin-bottom:85px;
    color:#111;
}

.login-right h2{
    font-size:34px;
    font-weight:800;
    color:#111;
}

.subtitle{
    color:#777;
    margin-bottom:40px;
}

.subtitle a{
    color:#111;
    font-weight:700;
}

.form-control{
    border:none;
    border-bottom:2px solid #ffdbc5;
    border-radius:0;
    padding:14px 0;
    box-shadow:none;
    font-weight:600;
}

.form-control:focus{
    box-shadow:none;
    border-color:#E78F81;
}

.input-group-text{
    background:transparent;
    border:none;
    border-bottom:2px solid #ddd;
    border-radius:0;
    color:#B55C00;
}

.eye-btn{
    border:none;
    border-bottom:2px solid #ddd;
    border-radius:0;
    background:white;
    color:#87A2FF;
}

.btn-login{
    width:100%;
    background:#111;
    color:white;
    border:none;
    border-radius:8px;
    padding:14px;
    font-weight:700;
    margin-top:25px;
}

.btn-login:hover{
    background:#E78F81;
    color:white;
}

.forgot{
    text-align:center;
    margin-top:25px;
    color:#999;
}

.forgot a{
    color:#111;
    font-weight:700;
}

@media(max-width:900px){
    .login-page{
        flex-direction:column;
    }

    .login-left,
    .login-right{
        width:100%;
        min-height:auto;
    }

    .login-left{
        padding:120px 50px 60px;
    }

    .login-left p{
        width:100%;
    }

    .login-right{
        padding:45px 35px;
    }

    .logo-ayaflora{
        left:100px;
        top:100px;
    }
}
</style>
</head>

<body>

<div class="login-page">

    <div class="login-left">
        <img src="{{ asset('img/ayaflora.-logo.png') }}" class="logo-ayaflora" alt="Logo AYAFlora">

        

        <p>
            Encuentra flores, detalles y regalos especiales para cada momento.
            Vive una experiencia creada para compartir emociones, colores y sonrisas.
        </p>

        <div class="copy">© 2026 AYAFlora. Todos los derechos reservados.</div>
    </div>

    <div class="login-right">

        <div class="brand">AYAFlora</div>

        <h2>¡Bienvenido!</h2>

        <p class="subtitle">
            ¿No tienes cuenta?
            <a href="/registro">Crea una cuenta nueva</a>
        </p>

        @if(session('success'))
            <div class="alert alert-success text-center py-2">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger text-center py-2">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <input 
                type="text"
                name="usuario"
                class="form-control mb-4"
                placeholder="Usuario"
                value="{{ old('usuario') }}"
                required>

            <div class="input-group mb-4">
                <input 
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    placeholder="Contraseña"
                    required>

                <button type="button" class="btn eye-btn" onclick="verPassword()">
                    <i class="bi bi-eye-fill" id="iconoOjo"></i>
                </button>
            </div>

            <button class="btn btn-login">
                Iniciar sesión
            </button>

            <div class="forgot">
                ¿Olvidaste tu contraseña?
                <a href="/recuperar">Click aquí</a>
            </div>
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