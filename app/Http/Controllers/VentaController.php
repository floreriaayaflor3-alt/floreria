<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    private function verificarVendedor()
{
    if (!session('usuario')) return redirect('/');

    if (
        session('rol') !== 'vendedor' &&
        session('rol') !== 'admin'
    ) {
        return redirect('/principal');
    }

    return null;
}

    public function index()
    {
        if ($r = $this->verificarVendedor()) return $r;
        $productos = DB::table('producto')
            ->join('categoria', 'producto.id_categoria', '=', 'categoria.id_categoria')
            ->select('producto.*', 'categoria.nombre as nombre_categoria')
            ->where('producto.estado', 'Activo')
            ->where('producto.stock', '>', 0)
            ->get();
        $clientes = DB::table('cliente')
            ->join('usuario', 'cliente.id_usuario', '=', 'usuario.id_usuario')
            ->select('cliente.*', 'usuario.correo')
            ->get();
        $metodos = DB::table('metodo_pago')->where('estado', 'Activo')->get();
        return view('venta', compact('productos', 'clientes', 'metodos'));
    }

    public function procesar(Request $request)
    {
        if ($r = $this->verificarVendedor()) return $r;

        $ids = $request->id_producto;
        $cantidades = $request->cantidad;

        if (!$ids) return redirect('/venta')->with('error', 'Agrega al menos un producto');

        $subtotal = 0;
        foreach ($ids as $i => $id_producto) {
            $producto = DB::table('producto')->where('id_producto', $id_producto)->first();
            $subtotal += $producto->precio * $cantidades[$i];
        }

        $descuento = $request->descuento ?? 0;
        $subtotalConDescuento = $subtotal - $descuento;
        $iva = $subtotalConDescuento * 0.16;
        $total = $subtotalConDescuento + $iva;
        $folio = 'VTA-' . date('Y') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);

        $idVenta = DB::table('venta')->insertGetId([
            'id_usuario_vendedor' => session('id_usuario'),
            'id_usuario_cliente'  => $request->id_usuario_cliente,
            'id_metodo'           => $request->id_metodo,
            'folio'               => $folio,
            'subtotal'            => $subtotal,
            'descuento'           => $descuento,
            'iva'                 => $iva,
            'total'               => $total,
            'estado'              => 'Pagado',
            'fecha'               => now(),
        ]);

        foreach ($ids as $i => $id_producto) {
            $producto = DB::table('producto')->where('id_producto', $id_producto)->first();
            DB::table('detalle_venta')->insert([
                'id_venta'        => $idVenta,
                'id_producto'     => $id_producto,
                'cantidad'        => $cantidades[$i],
                'precio_unitario' => $producto->precio,
                'subtotal'        => $producto->precio * $cantidades[$i],
            ]);
            DB::table('producto')
                ->where('id_producto', $id_producto)
                ->decrement('stock', $cantidades[$i]);
        }

        return redirect('/venta/comprobante/' . $idVenta);
    }

    public function comprobante($id)
    {
        if ($r = $this->verificarVendedor()) return $r;
        $venta = DB::table('venta')
            ->join('metodo_pago', 'venta.id_metodo', '=', 'metodo_pago.id_metodo')
            ->leftJoin('cliente', 'venta.id_usuario_cliente', '=', 'cliente.id_usuario')
            ->select('venta.*', 'metodo_pago.nombre as metodo_nombre', 'cliente.nombre as nombre_cliente')
            ->where('venta.id_venta', $id)
            ->first();
        $detalle = DB::table('detalle_venta')
            ->join('producto', 'detalle_venta.id_producto', '=', 'producto.id_producto')
            ->select('detalle_venta.*', 'producto.nombre')
            ->where('detalle_venta.id_venta', $id)
            ->get();
        return view('venta-comprobante', compact('venta', 'detalle'));
    }

    public function historial()
{
    if ($r = $this->verificarVendedor()) return $r;
    $ventas = DB::table('venta')
        ->join('metodo_pago', 'venta.id_metodo', '=', 'metodo_pago.id_metodo')
        ->leftJoin('cliente', 'venta.id_usuario_cliente', '=', 'cliente.id_usuario')
        ->select('venta.*', 'metodo_pago.nombre as metodo_nombre',
                 'cliente.nombre as nombre_cliente')
        ->orderBy('venta.fecha', 'desc')
        ->get();
    return view('venta-historial', compact('ventas'));
}
}