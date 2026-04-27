<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CrudController extends Controller
{
    public function index($tipo)
    {
        if (!session('usuario')) {
            return redirect('/');
        }

        if (session('rol') !== 'admin') {
            return redirect('/principal');
        }

        return view('crud', compact('tipo'));
    }
}