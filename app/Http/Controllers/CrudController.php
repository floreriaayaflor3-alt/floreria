<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrudController extends Controller
{
    private function verificarAdmin()
    {
        if (!session('usuario')) return redirect('/');
        if (session('rol') !== 'admin') return redirect('/principal');
        return null;
    }

    public function productos()
    {
        if ($r = $this->verificarAdmin()) return $r;
        $productos = DB::table('producto')
            ->join('categoria', 'producto.id_categoria', '=', 'categoria.id_categoria')
            ->select('producto.*', 'categoria.nombre as nombre_categoria')
            ->get();
        $categorias = DB::table('categoria')->get();
        return view('crud.productos', compact('productos', 'categorias'));
    }

    public function productosGuardar(Request $request)
    {
        if ($r = $this->verificarAdmin()) return $r;
        DB::table('producto')->insert([
            'id_categoria' => $request->id_categoria,
            'nombre'       => $request->nombre,
            'descripcion'  => $request->descripcion,
            'precio'       => $request->precio,
            'stock'        => $request->stock,
            'imagen'       => $request->imagen,
            'estado'       => 'Activo'
        ]);
        return redirect('/crud/productos')->with('success', 'Producto agregado correctamente');
    }

    public function productosEditar($id)
    {
        if ($r = $this->verificarAdmin()) return $r;
        $producto = DB::table('producto')->where('id_producto', $id)->first();
        $categorias = DB::table('categoria')->get();
        $productos = DB::table('producto')
            ->join('categoria', 'producto.id_categoria', '=', 'categoria.id_categoria')
            ->select('producto.*', 'categoria.nombre as nombre_categoria')
            ->get();
        return view('crud.productos', compact('productos', 'categorias', 'producto'));
    }

    public function productosActualizar(Request $request, $id)
    {
        if ($r = $this->verificarAdmin()) return $r;
        DB::table('producto')->where('id_producto', $id)->update([
            'id_categoria' => $request->id_categoria,
            'nombre'       => $request->nombre,
            'descripcion'  => $request->descripcion,
            'precio'       => $request->precio,
            'stock'        => $request->stock,
            'imagen'       => $request->imagen,
        ]);
        return redirect('/crud/productos')->with('success', 'Producto actualizado correctamente');
    }

    public function productosEliminar($id)
    {
        if ($r = $this->verificarAdmin()) return $r;
        DB::table('producto')->where('id_producto', $id)->delete();
        return redirect('/crud/productos')->with('success', 'Producto eliminado correctamente');
    }

    public function insumos()
    {
        if ($r = $this->verificarAdmin()) return $r;
        $insumos = DB::table('insumo')
            ->leftJoin('proveedor', 'insumo.id_proveedor', '=', 'proveedor.id_proveedor')
            ->select('insumo.*', 'proveedor.nombre as nombre_proveedor')
            ->get();
        $proveedores = DB::table('proveedor')->get();
        return view('crud.insumos', compact('insumos', 'proveedores'));
    }

    public function insumosGuardar(Request $request)
    {
        if ($r = $this->verificarAdmin()) return $r;
        DB::table('insumo')->insert([
            'id_proveedor'      => $request->id_proveedor,
            'nombre'            => $request->nombre,
            'categoria'         => $request->categoria,
            'unidad_medida'     => $request->unidad_medida,
            'precio_unitario'   => $request->precio_unitario,
            'stock_actual'      => $request->stock_actual,
            'stock_minimo'      => $request->stock_minimo,
            'fecha_compra'      => $request->fecha_compra,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'descripcion'       => $request->descripcion,
        ]);
        return redirect('/crud/insumos')->with('success', 'Insumo agregado correctamente');
    }

    public function insumosEditar($id)
    {
        if ($r = $this->verificarAdmin()) return $r;
        $insumo = DB::table('insumo')->where('id_insumo', $id)->first();
        $proveedores = DB::table('proveedor')->get();
        $insumos = DB::table('insumo')
            ->leftJoin('proveedor', 'insumo.id_proveedor', '=', 'proveedor.id_proveedor')
            ->select('insumo.*', 'proveedor.nombre as nombre_proveedor')
            ->get();
        return view('crud.insumos', compact('insumos', 'proveedores', 'insumo'));
    }

    public function insumosActualizar(Request $request, $id)
    {
        if ($r = $this->verificarAdmin()) return $r;
        DB::table('insumo')->where('id_insumo', $id)->update([
            'id_proveedor'      => $request->id_proveedor,
            'nombre'            => $request->nombre,
            'categoria'         => $request->categoria,
            'unidad_medida'     => $request->unidad_medida,
            'precio_unitario'   => $request->precio_unitario,
            'stock_actual'      => $request->stock_actual,
            'stock_minimo'      => $request->stock_minimo,
            'fecha_compra'      => $request->fecha_compra,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'descripcion'       => $request->descripcion,
        ]);
        return redirect('/crud/insumos')->with('success', 'Insumo actualizado correctamente');
    }

    public function insumosEliminar($id)
    {
        if ($r = $this->verificarAdmin()) return $r;
        DB::table('insumo')->where('id_insumo', $id)->delete();
        return redirect('/crud/insumos')->with('success', 'Insumo eliminado correctamente');
    }

    public function proveedores()
    {
        if ($r = $this->verificarAdmin()) return $r;
        $proveedores = DB::table('proveedor')->get();
        return view('crud.proveedores', compact('proveedores'));
    }

    public function proveedoresGuardar(Request $request)
    {
        if ($r = $this->verificarAdmin()) return $r;
        DB::table('proveedor')->insert([
            'nombre'            => $request->nombre,
            'rfc'               => $request->rfc,
            'telefono'          => $request->telefono,
            'correo'            => $request->correo,
            'direccion'         => $request->direccion,
            'ciudad'            => $request->ciudad,
            'estado_rep'        => $request->estado_rep,
            'codigo_postal'     => $request->codigo_postal,
            'contacto'          => $request->contacto,
            'telefono_contacto' => $request->telefono_contacto,
            'descripcion'       => $request->descripcion,
            'estado'            => 'Activo'
        ]);
        return redirect('/crud/proveedores')->with('success', 'Proveedor agregado correctamente');
    }

    public function proveedoresEditar($id)
    {
        if ($r = $this->verificarAdmin()) return $r;
        $proveedor = DB::table('proveedor')->where('id_proveedor', $id)->first();
        $proveedores = DB::table('proveedor')->get();
        return view('crud.proveedores', compact('proveedores', 'proveedor'));
    }

    public function proveedoresActualizar(Request $request, $id)
    {
        if ($r = $this->verificarAdmin()) return $r;
        DB::table('proveedor')->where('id_proveedor', $id)->update([
            'nombre'            => $request->nombre,
            'rfc'               => $request->rfc,
            'telefono'          => $request->telefono,
            'correo'            => $request->correo,
            'direccion'         => $request->direccion,
            'ciudad'            => $request->ciudad,
            'estado_rep'        => $request->estado_rep,
            'codigo_postal'     => $request->codigo_postal,
            'contacto'          => $request->contacto,
            'telefono_contacto' => $request->telefono_contacto,
            'descripcion'       => $request->descripcion,
        ]);
        return redirect('/crud/proveedores')->with('success', 'Proveedor actualizado correctamente');
    }

    public function proveedoresEliminar($id)
    {
        if ($r = $this->verificarAdmin()) return $r;
        DB::table('proveedor')->where('id_proveedor', $id)->delete();
        return redirect('/crud/proveedores')->with('success', 'Proveedor eliminado correctamente');
    }

    public function clientes()
    {
        if ($r = $this->verificarAdmin()) return $r;
        $clientes = DB::table('cliente')
            ->leftJoin('usuario', 'cliente.id_usuario', '=', 'usuario.id_usuario')
            ->select('cliente.*', 'usuario.correo', 'usuario.estado_usuario')
            ->get();
        return view('crud.clientes', compact('clientes'));
    }

    public function clientesEliminar($id)
    {
        if ($r = $this->verificarAdmin()) return $r;
        DB::table('cliente')->where('id_cliente', $id)->delete();
        return redirect('/crud/clientes')->with('success', 'Cliente eliminado correctamente');
    }

    public function trabajadores()
    {
        if ($r = $this->verificarAdmin()) return $r;
        $trabajadores = DB::table('trabajador')
            ->join('usuario', 'trabajador.id_usuario', '=', 'usuario.id_usuario')
            ->join('rol', 'usuario.id_rol', '=', 'rol.id_rol')
            ->select('trabajador.*', 'usuario.usuario', 'usuario.id_rol', 'rol.nombre_rol')
            ->get();
        return view('crud.trabajadores', compact('trabajadores'));
    }

    public function trabajadoresGuardar(Request $request)
    {
        if ($r = $this->verificarAdmin()) return $r;
        $idUsuario = DB::table('usuario')->insertGetId([
            'id_rol'         => $request->id_rol,
            'usuario'        => $request->usuario,
            'password'       => bcrypt($request->password),
            'correo'         => $request->usuario . '@ayaflora.com',
            'estado_usuario' => 'Activo'
        ]);
        DB::table('trabajador')->insert([
            'id_usuario'    => $idUsuario,
            'nombre'        => $request->nombre,
            'telefono'      => $request->telefono,
            'direccion'     => $request->direccion,
            'fecha_ingreso' => $request->fecha_ingreso,
            'estado'        => 'Activo'
        ]);
        return redirect('/crud/trabajadores')->with('success', 'Trabajador agregado correctamente');
    }

    public function trabajadoresEditar($id)
    {
        if ($r = $this->verificarAdmin()) return $r;
        $trabajador = DB::table('trabajador')
            ->join('usuario', 'trabajador.id_usuario', '=', 'usuario.id_usuario')
            ->join('rol', 'usuario.id_rol', '=', 'rol.id_rol')
            ->select('trabajador.*', 'usuario.usuario', 'usuario.id_rol', 'rol.nombre_rol')
            ->where('trabajador.id_trabajador', $id)
            ->first();
        $trabajadores = DB::table('trabajador')
            ->join('usuario', 'trabajador.id_usuario', '=', 'usuario.id_usuario')
            ->join('rol', 'usuario.id_rol', '=', 'rol.id_rol')
            ->select('trabajador.*', 'usuario.usuario', 'usuario.id_rol', 'rol.nombre_rol')
            ->get();
        return view('crud.trabajadores', compact('trabajadores', 'trabajador'));
    }

    public function trabajadoresActualizar(Request $request, $id)
    {
        if ($r = $this->verificarAdmin()) return $r;
        $trabajador = DB::table('trabajador')->where('id_trabajador', $id)->first();
        DB::table('usuario')->where('id_usuario', $trabajador->id_usuario)->update([
            'id_rol'  => $request->id_rol,
            'usuario' => $request->usuario,
        ]);
        if ($request->password) {
            DB::table('usuario')->where('id_usuario', $trabajador->id_usuario)->update([
                'password' => bcrypt($request->password)
            ]);
        }
        DB::table('trabajador')->where('id_trabajador', $id)->update([
            'nombre'        => $request->nombre,
            'telefono'      => $request->telefono,
            'direccion'     => $request->direccion,
            'fecha_ingreso' => $request->fecha_ingreso,
        ]);
        return redirect('/crud/trabajadores')->with('success', 'Trabajador actualizado correctamente');
    }

    public function trabajadoresEliminar($id)
    {
        if ($r = $this->verificarAdmin()) return $r;
        $trabajador = DB::table('trabajador')->where('id_trabajador', $id)->first();
        DB::table('trabajador')->where('id_trabajador', $id)->delete();
        DB::table('usuario')->where('id_usuario', $trabajador->id_usuario)->delete();
        return redirect('/crud/trabajadores')->with('success', 'Trabajador eliminado correctamente');
    }

    public function promociones()
    {
        if ($r = $this->verificarAdmin()) return $r;
        $promociones = DB::table('promocion')->get();
        return view('crud.promociones', compact('promociones'));
    }

    public function promocionesGuardar(Request $request)
    {
        if ($r = $this->verificarAdmin()) return $r;
        DB::table('promocion')->insert([
            'titulo'       => $request->titulo,
            'descripcion'  => $request->descripcion,
            'descuento'    => $request->descuento,
            'imagen'       => $request->imagen,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'estado'       => 'Activo'
        ]);
        return redirect('/crud/promociones')->with('success', 'Promoción agregada correctamente');
    }

    public function promocionesEditar($id)
    {
        if ($r = $this->verificarAdmin()) return $r;
        $promocion = DB::table('promocion')->where('id_promocion', $id)->first();
        $promociones = DB::table('promocion')->get();
        return view('crud.promociones', compact('promociones', 'promocion'));
    }

    public function promocionesActualizar(Request $request, $id)
    {
        if ($r = $this->verificarAdmin()) return $r;
        DB::table('promocion')->where('id_promocion', $id)->update([
            'titulo'       => $request->titulo,
            'descripcion'  => $request->descripcion,
            'descuento'    => $request->descuento,
            'imagen'       => $request->imagen,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'estado'       => $request->estado,
        ]);
        return redirect('/crud/promociones')->with('success', 'Promoción actualizada correctamente');
    }

    public function promocionesEliminar($id)
    {
        if ($r = $this->verificarAdmin()) return $r;
        DB::table('promocion')->where('id_promocion', $id)->delete();
        return redirect('/crud/promociones')->with('success', 'Promoción eliminada correctamente');
    }

    // ← NUEVO: Cliente hace clic en una promoción del carrusel
    public function aplicarPromocion($id)
    {
        if (!session('usuario')) return redirect('/');
        if (session('rol') !== 'cliente') return redirect('/principal');

        $promo = DB::table('promocion')
            ->where('id_promocion', $id)
            ->where('estado', 'Activo')
            ->whereDate('fecha_fin', '>=', now())
            ->first();

        if ($promo) {
            session(['promo_aplicada' => [
                'titulo'      => $promo->titulo,
                'descuento'   => $promo->descuento,
                'descripcion' => $promo->descripcion,
            ]]);
        }

        return redirect('/carrito');
    }

    //Toggle estado producto
    public function productosToggle($id)
{
    if ($r = $this->verificarAdmin()) return $r;
    $producto = DB::table('producto')->where('id_producto', $id)->first();
    $nuevoEstado = $producto->estado == 'Activo' ? 'Inactivo' : 'Activo';
    DB::table('producto')->where('id_producto', $id)->update(['estado' => $nuevoEstado]);
    return redirect('/crud/productos')->with('success', 'Estado del producto actualizado');
}
    // Toggle estado cliente
public function clientesToggle($id)
{
    if ($r = $this->verificarAdmin()) return $r;
    $cliente = DB::table('cliente')->where('id_cliente', $id)->first();
    $nuevoEstado = $cliente->estado == 'Activo' ? 'Inactivo' : 'Activo';
    DB::table('cliente')->where('id_cliente', $id)->update(['estado' => $nuevoEstado]);
    return redirect('/crud/clientes')->with('success', 'Estado del cliente actualizado');
}

// Toggle estado trabajador
public function trabajadoresToggle($id)
{
    if ($r = $this->verificarAdmin()) return $r;
    $trabajador = DB::table('trabajador')->where('id_trabajador', $id)->first();
    $nuevoEstado = $trabajador->estado == 'Activo' ? 'Inactivo' : 'Activo';
    DB::table('trabajador')->where('id_trabajador', $id)->update(['estado' => $nuevoEstado]);
    return redirect('/crud/trabajadores')->with('success', 'Estado del trabajador actualizado');
}

// Toggle estado promocion
public function promocionesToggle($id)
{
    if ($r = $this->verificarAdmin()) return $r;
    $promo = DB::table('promocion')->where('id_promocion', $id)->first();
    $nuevoEstado = $promo->estado == 'Activo' ? 'Inactivo' : 'Activo';
    DB::table('promocion')->where('id_promocion', $id)->update(['estado' => $nuevoEstado]);
    return redirect('/crud/promociones')->with('success', 'Estado de la promoción actualizado');
}

// Reciclar promocion (actualizar fechas)
public function promocionesReciclar(Request $request, $id)
{
    if ($r = $this->verificarAdmin()) return $r;
    DB::table('promocion')->where('id_promocion', $id)->update([
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_fin'    => $request->fecha_fin,
        'estado'       => 'Activo'
    ]);
    return redirect('/crud/promociones')->with('success', 'Promoción reciclada correctamente');
}
}

