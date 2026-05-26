<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = DB::table('usuario')
            ->join('rol', 'usuario.id_rol', '=', 'rol.id_rol')
            ->where('usuario.usuario', $request->usuario)
            ->select(
                'usuario.*',
                'rol.nombre_rol'
            )
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
    session([
        'id_usuario' => $user->id_usuario,
        'usuario'    => $user->usuario,
        'id_rol'     => $user->id_rol,
        'rol'        => $user->nombre_rol
    ]);

    $request->session()->regenerate(); // ← AGREGAR ESTA LÍNEA

    return redirect('/principal');
}

        return back()->with('error', 'Usuario o contraseña incorrectos');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }

    public function vistaRegistro()
    {
        return view('registro');
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required|email|unique:usuario,correo',
            'usuario' => 'required|unique:usuario,usuario',
            'password' => 'required|min:4',
            'telefono' => 'nullable',
            'direccion' => 'nullable',
            'colonia' => 'nullable'
        ]);

        $idUsuario = DB::table('usuario')->insertGetId([
            'id_rol' => 4, // Cliente
            'usuario' => $request->usuario,
            'password' => bcrypt($request->password),
            'correo' => $request->correo,
            'estado_usuario' => 'Activo'
        ]);

        DB::table('cliente')->insert([
            'id_usuario' => $idUsuario,
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'colonia' => $request->colonia,
            'municipio' => 'Oaxaca de Juárez',
            'estado' => 'Oaxaca'
        ]);

        return redirect('/login')
            ->with('success', 'Usuario registrado correctamente');
    }

    public function recuperar()
{
    return view('recuperar');
}

public function recuperarPassword(Request $request)
{
    $request->validate([
        'correo' => 'required|email'
    ]);

    $usuario = DB::table('usuario')->where('correo', $request->correo)->first();

    if (!$usuario) {
        return back()->with('error', 'No existe una cuenta con ese correo');
    }

    // Generar token único
    $token = \Illuminate\Support\Str::random(60);

    // Guardar token
    DB::table('password_reset_tokens')->where('email', $request->correo)->delete();
    DB::table('password_reset_tokens')->insert([
        'email' => $request->correo,
        'token'  => $token,
    ]);

    // Enviar correo
    $link = url('/recuperar/reset/' . $token);

    \Illuminate\Support\Facades\Mail::send([], [], function($mail) use ($request, $link) {
        $mail->to($request->correo)
             ->subject('Recuperar contraseña - AYAFlora')
             ->html("
                <div style='font-family:sans-serif; max-width:500px; margin:auto;'>
                    <h2 style='color:#7b2d5b;'>🌸 AYAFlora</h2>
                    <p>Recibimos una solicitud para restablecer tu contraseña.</p>
                    <p>Haz clic en el botón para crear una nueva contraseña:</p>
                    <a href='{$link}' style='background:#7b2d5b; color:white; padding:12px 24px; border-radius:8px; text-decoration:none; display:inline-block; margin:16px 0;'>
                        Restablecer contraseña
                    </a>
                    <p style='color:#888; font-size:12px;'>Este enlace expira en 60 minutos. Si no solicitaste esto, ignora este correo.</p>
                </div>
             ");
    });

    return back()->with('success', 'Te enviamos un correo con el link de recuperación');
}

public function recuperarForm($token)
{
    $reset = DB::table('password_reset_tokens')->where('token', $token)->first();
    if (!$reset) return redirect('/login')->with('error', 'Token inválido o expirado');
    return view('recuperar-nueva', compact('token'));
}

public function recuperarNueva(Request $request, $token)
{
    $request->validate([
        'password' => 'required|min:4|confirmed'
    ]);

    $reset = DB::table('password_reset_tokens')->where('token', $token)->first();
    if (!$reset) return redirect('/login')->with('error', 'Token inválido o expirado');

    DB::table('usuario')->where('correo', $reset->email)->update([
        'password' => bcrypt($request->password)
    ]);

    DB::table('password_reset_tokens')->where('token', $token)->delete();

    return redirect('/login')->with('success', 'Contraseña actualizada correctamente');
}
}