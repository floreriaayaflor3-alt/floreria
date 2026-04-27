<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = DB::table('usuario')
            ->where('user', $request->usuario)
            ->where('pass', $request->password)
            ->first();

        if ($user) {
            session([
                'usuario' => $user->user,
                'rol' => $user->rol
            ]);

            return redirect('/principal');
        }

        return back()->with('error', 'Usuario o contraseña incorrectos');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}