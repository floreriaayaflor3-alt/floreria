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
            'usuario' => 'required',
            'nueva_password' => 'required|min:4'
        ]);

        $usuario = DB::table('usuario')
            ->where('usuario', $request->usuario)
            ->first();

        if (!$usuario) {
            return back()->with('error', 'El usuario no existe');
        }

        DB::table('usuario')
            ->where('id_usuario', $usuario->id_usuario)
            ->update([
                'password' => bcrypt($request->nueva_password)
            ]);

        return redirect('/login')
            ->with('success', 'Contraseña actualizada correctamente');
    }
}