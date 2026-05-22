<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CajeroController;

Route::get('/', function () { return view('login'); });
Route::get('/login', function () { return view('login'); });
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/registro', [AuthController::class, 'vistaRegistro']);
Route::post('/registro', [AuthController::class, 'registrar']);
Route::get('/recuperar', [AuthController::class, 'recuperar']);
Route::post('/recuperar', [AuthController::class, 'recuperarPassword']);
Route::get('/recuperar/reset/{token}', [AuthController::class, 'recuperarForm']);
Route::post('/recuperar/reset/{token}', [AuthController::class, 'recuperarNueva']);

Route::get('/principal', function () {
    if (!session('usuario')) return redirect('/');

    $productos   = collect();
    $promociones = collect();
    $countHoy    = 0;
    $totalHoy    = 0;
    $totalMes    = 0;
    $ultimas     = collect();

    if (session('rol') == 'cliente') {
        $productos = \Illuminate\Support\Facades\DB::table('producto')
            ->join('categoria', 'producto.id_categoria', '=', 'categoria.id_categoria')
            ->select('producto.*', 'categoria.nombre as nombre_categoria')
            ->where('producto.estado', 'Activo')
            ->get();
        $promociones = \Illuminate\Support\Facades\DB::table('promocion')
            ->where('estado', 'Activo')
            ->whereDate('fecha_fin', '>=', now())
            ->get();
    }

    if (session('rol') == 'vendedor') {
        $idVendedor = session('id_usuario');
        $countHoy = \Illuminate\Support\Facades\DB::table('venta')
            ->where('id_usuario_vendedor', $idVendedor)
            ->whereDate('fecha', now())
            ->count();
        $totalHoy = \Illuminate\Support\Facades\DB::table('venta')
            ->where('id_usuario_vendedor', $idVendedor)
            ->whereDate('fecha', now())
            ->sum('total');
        $totalMes = \Illuminate\Support\Facades\DB::table('venta')
            ->where('id_usuario_vendedor', $idVendedor)
            ->whereYear('fecha', now()->year)
            ->whereMonth('fecha', now()->month)
            ->sum('total');
        $ultimas = \Illuminate\Support\Facades\DB::table('venta')
            ->leftJoin('cliente', 'venta.id_usuario_cliente', '=', 'cliente.id_usuario')
            ->join('metodo_pago', 'venta.id_metodo', '=', 'metodo_pago.id_metodo')
            ->select('venta.*', 'cliente.nombre as nombre_cliente', 'metodo_pago.nombre as metodo_nombre')
            ->where('id_usuario_vendedor', $idVendedor)
            ->orderBy('fecha', 'desc')
            ->limit(5)
            ->get();
    }

    return view('principal', compact('productos', 'promociones', 'countHoy', 'totalHoy', 'totalMes', 'ultimas'));
});

// Ubicación
Route::get('/ubicacion', function() {
    if (!session('usuario')) return redirect('/');
    return view('ubicacion');
});

// CRUD Productos
Route::get('/crud/productos', [CrudController::class, 'productos']);
Route::post('/crud/productos', [CrudController::class, 'productosGuardar']);
Route::get('/crud/productos/{id}/editar', [CrudController::class, 'productosEditar']);
Route::post('/crud/productos/{id}/actualizar', [CrudController::class, 'productosActualizar']);
Route::get('/crud/productos/{id}/eliminar', [CrudController::class, 'productosEliminar']);

// CRUD Insumos
Route::get('/crud/insumos', [CrudController::class, 'insumos']);
Route::post('/crud/insumos', [CrudController::class, 'insumosGuardar']);
Route::get('/crud/insumos/{id}/editar', [CrudController::class, 'insumosEditar']);
Route::post('/crud/insumos/{id}/actualizar', [CrudController::class, 'insumosActualizar']);
Route::get('/crud/insumos/{id}/eliminar', [CrudController::class, 'insumosEliminar']);

// CRUD Proveedores
Route::get('/crud/proveedores', [CrudController::class, 'proveedores']);
Route::post('/crud/proveedores', [CrudController::class, 'proveedoresGuardar']);
Route::get('/crud/proveedores/{id}/editar', [CrudController::class, 'proveedoresEditar']);
Route::post('/crud/proveedores/{id}/actualizar', [CrudController::class, 'proveedoresActualizar']);
Route::get('/crud/proveedores/{id}/eliminar', [CrudController::class, 'proveedoresEliminar']);

// CRUD Clientes
Route::get('/crud/clientes', [CrudController::class, 'clientes']);
Route::get('/crud/clientes/{id}/eliminar', [CrudController::class, 'clientesEliminar']);

// CRUD Trabajadores
Route::get('/crud/trabajadores', [CrudController::class, 'trabajadores']);
Route::post('/crud/trabajadores', [CrudController::class, 'trabajadoresGuardar']);
Route::get('/crud/trabajadores/{id}/editar', [CrudController::class, 'trabajadoresEditar']);
Route::post('/crud/trabajadores/{id}/actualizar', [CrudController::class, 'trabajadoresActualizar']);
Route::get('/crud/trabajadores/{id}/eliminar', [CrudController::class, 'trabajadoresEliminar']);

// Carrito
Route::post('/carrito/agregar', [CarritoController::class, 'agregar']);
Route::get('/carrito', [CarritoController::class, 'index']);
Route::get('/carrito/{id}/eliminar', [CarritoController::class, 'eliminar']);
Route::post('/carrito/vaciar', [CarritoController::class, 'vaciar']);

// Pago
Route::get('/pago', [CarritoController::class, 'pagoVista']);
Route::post('/pago/procesar', [CarritoController::class, 'procesarPago']);
Route::post('/pago/stripe', [CarritoController::class, 'pagoStripe']);
Route::get('/comprobante/{id}', [CarritoController::class, 'comprobante']);

// Mis pedidos
Route::get('/mis-pedidos', [CarritoController::class, 'misPedidos']);

// Vendedor
Route::get('/venta', [VentaController::class, 'index']);
Route::post('/venta/procesar', [VentaController::class, 'procesar']);
Route::get('/venta/comprobante/{id}', [VentaController::class, 'comprobante']);
Route::get('/venta/historial', [VentaController::class, 'historial']);

// Cajero
Route::get('/cobro', [CajeroController::class, 'index']);
Route::post('/cobro/{id}/confirmar', [CajeroController::class, 'confirmar']);
Route::get('/cobro/historial', [CajeroController::class, 'historial']);

// CRUD Promociones
Route::get('/crud/promociones', [CrudController::class, 'promociones']);
Route::post('/crud/promociones', [CrudController::class, 'promocionesGuardar']);
Route::get('/crud/promociones/{id}/editar', [CrudController::class, 'promocionesEditar']);
Route::post('/crud/promociones/{id}/actualizar', [CrudController::class, 'promocionesActualizar']);
Route::get('/crud/promociones/{id}/eliminar', [CrudController::class, 'promocionesEliminar']);
Route::get('/promocion/{id}/aplicar', [CrudController::class, 'aplicarPromocion']);