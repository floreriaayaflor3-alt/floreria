<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    private function verificarCliente()
    {
        if (!session('usuario')) return redirect('/');
        if (session('rol') !== 'cliente') return redirect('/principal');
        return null;
    }

    private function calcularTotales($items)
    {
        $subtotal = $items->sum(fn($i) => $i->cantidad * $i->precio);
        $descuento = 0;
        if (session('promo_aplicada')) {
            $porcentaje = floatval(session('promo_aplicada')['descuento']);
            $descuento  = $subtotal * ($porcentaje / 100);
        }
        $subtotalConDescuento = $subtotal - $descuento;
        $iva   = $subtotalConDescuento * 0.16;
        $total = $subtotalConDescuento + $iva;
        return compact('subtotal', 'descuento', 'iva', 'total');
    }

    public function index()
    {
        if ($r = $this->verificarCliente()) return $r;
        $items = DB::table('carrito')
            ->join('producto', 'carrito.id_producto', '=', 'producto.id_producto')
            ->select('carrito.*', 'producto.nombre', 'producto.precio', 'producto.imagen')
            ->where('carrito.id_usuario', session('id_usuario'))
            ->get();
        $t = $this->calcularTotales($items);
        return view('carrito', array_merge(compact('items'), $t));
    }

    public function agregar(Request $request)
    {
        if (!session('usuario')) return redirect('/');
        $existente = DB::table('carrito')
            ->where('id_usuario', session('id_usuario'))
            ->where('id_producto', $request->id_producto)
            ->first();
        if ($existente) {
            DB::table('carrito')
                ->where('id_carrito', $existente->id_carrito)
                ->update(['cantidad' => $existente->cantidad + 1]);
        } else {
            DB::table('carrito')->insert([
                'id_usuario'  => session('id_usuario'),
                'id_producto' => $request->id_producto,
                'cantidad'    => 1,
            ]);
        }
        return redirect('/principal')->with('success', '¡Producto agregado al carrito!');
    }

    public function eliminar($id)
    {
        if ($r = $this->verificarCliente()) return $r;
        DB::table('carrito')->where('id_carrito', $id)->delete();
        return redirect('/carrito')->with('success', 'Producto eliminado del carrito');
    }

    public function vaciar()
    {
        if ($r = $this->verificarCliente()) return $r;
        DB::table('carrito')->where('id_usuario', session('id_usuario'))->delete();
        session()->forget('promo_aplicada');
        return redirect('/carrito')->with('success', 'Carrito vaciado');
    }

    public function pagoVista()
    {
        if ($r = $this->verificarCliente()) return $r;
        $items = DB::table('carrito')
            ->join('producto', 'carrito.id_producto', '=', 'producto.id_producto')
            ->select('carrito.*', 'producto.nombre', 'producto.precio', 'producto.imagen')
            ->where('carrito.id_usuario', session('id_usuario'))
            ->get();
        if ($items->isEmpty()) return redirect('/carrito');
        $t         = $this->calcularTotales($items);
        $metodos   = DB::table('metodo_pago')->where('estado', 'Activo')->get();
        $stripeKey = env('STRIPE_KEY', '');
        return view('pago', array_merge(compact('items', 'metodos', 'stripeKey'), $t));
    }

    public function procesarPago(Request $request)
    {
        if ($r = $this->verificarCliente()) return $r;
        $items = DB::table('carrito')
            ->join('producto', 'carrito.id_producto', '=', 'producto.id_producto')
            ->select('carrito.*', 'producto.nombre', 'producto.precio')
            ->where('carrito.id_usuario', session('id_usuario'))
            ->get();
        if ($items->isEmpty()) return redirect('/carrito');
        $t     = $this->calcularTotales($items);
        $folio = 'AYA-' . date('Y') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $idVenta = DB::table('venta')->insertGetId([
            'id_usuario_cliente' => session('id_usuario'),
            'id_metodo'          => $request->id_metodo,
            'folio'              => $folio,
            'subtotal'           => $t['subtotal'],
            'iva'                => $t['iva'],
            'total'              => $t['total'],
            'estado'             => 'Pagado',
            'fecha'              => now(),
        ]);
        foreach ($items as $item) {
            DB::table('detalle_venta')->insert([
                'id_venta'        => $idVenta,
                'id_producto'     => $item->id_producto,
                'cantidad'        => $item->cantidad,
                'precio_unitario' => $item->precio,
                'subtotal'        => $item->cantidad * $item->precio,
            ]);
            DB::table('producto')
                ->where('id_producto', $item->id_producto)
                ->decrement('stock', $item->cantidad);
        }
        DB::table('carrito')->where('id_usuario', session('id_usuario'))->delete();
        session()->forget('promo_aplicada');
        return redirect('/comprobante/' . $idVenta);
    }

    public function pagoStripe(Request $request)
    {
        if ($r = $this->verificarCliente()) return $r;

        $items = DB::table('carrito')
            ->join('producto', 'carrito.id_producto', '=', 'producto.id_producto')
            ->select('carrito.*', 'producto.nombre', 'producto.precio')
            ->where('carrito.id_usuario', session('id_usuario'))
            ->get();

        if ($items->isEmpty()) return redirect('/carrito');

        $t = $this->calcularTotales($items);

        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET', ''));

            \Stripe\Charge::create([
                'amount'      => intval($t['total'] * 100),
                'currency'    => 'mxn',
                'source'      => $request->stripeToken,
                'description' => 'Compra AYAFlora - ' . session('usuario'),
            ]);

        } catch (\Stripe\Exception\CardException $e) {
            return redirect('/pago')->with('error', '❌ Tarjeta rechazada: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect('/pago')->with('error', '❌ Error al procesar el pago: ' . $e->getMessage());
        }

        $folio   = 'AYA-' . date('Y') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $idVenta = DB::table('venta')->insertGetId([
            'id_usuario_cliente' => session('id_usuario'),
            'id_metodo'          => $request->id_metodo,
            'folio'              => $folio,
            'subtotal'           => $t['subtotal'],
            'iva'                => $t['iva'],
            'total'              => $t['total'],
            'estado'             => 'Pagado',
            'fecha'              => now(),
        ]);

        foreach ($items as $item) {
            DB::table('detalle_venta')->insert([
                'id_venta'        => $idVenta,
                'id_producto'     => $item->id_producto,
                'cantidad'        => $item->cantidad,
                'precio_unitario' => $item->precio,
                'subtotal'        => $item->cantidad * $item->precio,
            ]);
            DB::table('producto')
                ->where('id_producto', $item->id_producto)
                ->decrement('stock', $item->cantidad);
        }

        DB::table('carrito')->where('id_usuario', session('id_usuario'))->delete();
        session()->forget('promo_aplicada');

        return redirect('/comprobante/' . $idVenta);
    }

    public function comprobante($id)
    {
        if ($r = $this->verificarCliente()) return $r;
        $venta = DB::table('venta')
            ->join('metodo_pago', 'venta.id_metodo', '=', 'metodo_pago.id_metodo')
            ->select('venta.*', 'metodo_pago.nombre as metodo_nombre')
            ->where('venta.id_venta', $id)
            ->first();
        $detalle = DB::table('detalle_venta')
            ->join('producto', 'detalle_venta.id_producto', '=', 'producto.id_producto')
            ->select('detalle_venta.*', 'producto.nombre')
            ->where('detalle_venta.id_venta', $id)
            ->get();
        return view('comprobante', compact('venta', 'detalle'));
    }

    public function misPedidos()
    {
        if ($r = $this->verificarCliente()) return $r;
        $pedidos = DB::table('venta')
            ->join('metodo_pago', 'venta.id_metodo', '=', 'metodo_pago.id_metodo')
            ->select('venta.*', 'metodo_pago.nombre as metodo_nombre')
            ->where('venta.id_usuario_cliente', session('id_usuario'))
            ->orderBy('venta.fecha', 'desc')
            ->get();
        return view('mis-pedidos', compact('pedidos'));
    }
}