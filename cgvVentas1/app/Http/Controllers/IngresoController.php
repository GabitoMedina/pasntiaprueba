<?php

namespace cgvVentas\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade;

use cgvVentas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use cgvVentas\Http\Requests\IngresoFormRequest;
use cgvVentas\Ingreso;
use cgvVentas\DetalleIngreso;
use DB;
use PDF;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class IngresoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if ($request)
        {
            $query=trim($request->get('searchText'));
            $ingresos=DB::table('ingreso as i')
            ->join('persona as p','i.idproveedor','=','p.idpersona')
            ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
            ->select('i.idingreso','i.fecha','p.nombre','i.tipo_comprobante','i.num_comprobante','i.iva','i.estado',DB::raw('sum(di.cantidad*precio_compra) as total')) 
            ->where('i.num_comprobante','LIKE','%'.$query.'%')
            ->orderBy('i.idingreso','desc')
            ->groupBy('i.idingreso','i.fecha','p.nombre','i.tipo_comprobante','i.num_comprobante','i.iva','i.estado')
            ->paginate(7);
            return view('compras.ingreso.index',["ingresos"=>$ingresos,"searchText"=>$query]);
         }
    }
    public function create()
    {
        $personas=DB::table('persona')->where('tipo_persona','=','Proveedor')->get();
        $articulos = DB::table('articulo as art')
        ->select(DB::raw('CONCAT(art.codigo, " ",art.nombre) AS articulo'),'art.idarticulo')
        ->where('art.estado','=','Activo')
        ->get();
        return view("compras.ingreso.create",["personas"=>$personas,"articulos"=>$articulos]);
    }

     public function store (IngresoFormRequest $request)
    {
        try{
            DB::beginTransaction();
            $ingreso=new Ingreso;
            $ingreso->idproveedor=$request->get('idproveedor');
            $ingreso->tipo_comprobante=$request->get('tipo_comprobante');
            $ingreso->num_comprobante=$request->get('num_comprobante');
            $mytime= Carbon::now('America/Guayaquil');
            $ingreso->fecha=$mytime->toDateTimeString();
            $ingreso->iva='12';
            $ingreso->estado='Activo';
            $ingreso->save();
 
            $idarticulo= $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $num_serie = $request->get('num_serie');
            $precio_compra = $request->get('precio_compra');
            $precio_venta = $request->get('precio_venta');
             
            $cont = 0;
            while($cont < count($idarticulo)){
                $detalle = new DetalleIngreso();
                $detalle->idingreso=$ingreso->idingreso;
                $detalle->idarticulo= $idarticulo[$cont]; 
                $detalle->cantidad= $cantidad[$cont];
                $detalle->num_serie= $num_serie[$cont];
                $detalle->precio_compra= $precio_compra[$cont];
                $detalle->precio_venta= $precio_venta[$cont];
                $detalle->save();
                $cont=$cont+1;
            }
            DB::commit();
        }catch(\Exception $e)
        {
            DB::rollback();
        }
        return Redirect::to('compras/ingreso');
    }

    // para imprimir pdf

    public function pdf($id)
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        $id='id';
    
       $ingreso=DB::table('ingreso as i')
            ->join('persona as p','i.idproveedor','=','p.idpersona')
            ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
            ->select('i.idingreso','i.fecha','p.nombre','i.tipo_comprobante','i.num_comprobante','i.iva','i.estado',DB::raw('sum(di.cantidad*precio_compra) as total')) 
            ->where('i.idingreso','=','id')
            ->first();

        $detalles=DB::table('detalle_ingreso as d')
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            ->select('a.nombre as articulo','d.cantidad','d.precio_compra','d.precio_venta')
            ->where('d.idingreso','=',$id)
            ->get();
        // return view("compras.ingreso.pdf",["ingreso"=>$ingreso,"detalles"=>$detalles]); 

        $pdf = PDF::loadView('compras.ingreso.pdf', ["ingreso"=>$ingreso,"detalles"=>$detalles]); 
        // return view("compras.ingreso.pdf",["ingreso"=>$ingreso,"detalles"=>$detalles]); 

        return $pdf->download('listado.pdf');
    }

    public function show($id)
    {
        $ingreso=DB::table('ingreso as i')
            ->join('persona as p','i.idproveedor','=','p.idpersona')
            ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
            ->select('i.idingreso','i.fecha','p.nombre','i.tipo_comprobante','i.num_comprobante','i.iva','i.estado',DB::raw('sum(di.cantidad*precio_compra) as total')) 
            ->where('i.idingreso','=',$id)
            ->first();

        $detalles=DB::table('detalle_ingreso as d')
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            ->select('a.nombre as articulo','d.cantidad','d.precio_compra','d.precio_venta')
            ->where('d.idingreso','=',$id)
            ->get();
            $pdf = PDF::loadView("compras.ingreso.show",["ingreso"=>$ingreso,"detalles"=>$detalles]);
            return $pdf->download('reporte.pdf');
        // return view("compras.ingreso.show",["ingreso"=>$ingreso,"detalles"=>$detalles]);
    }
 
    public function destroy($id)
    {
        $ingreso=Ingreso::findOrFail($id);
        $ingreso->estado='Cancelada';
        $ingreso->update();
        return Redirect::to('compras/ingreso');
    }
 
}
