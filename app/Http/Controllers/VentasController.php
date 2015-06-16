<?php namespace Epos\Http\Controllers;

use Carbon\Carbon;
use Epos\Models\Producto;
use Epos\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class VentasController extends Controller {

    protected $request;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showVentas(\Illuminate\Http\Request $request)
    {
        $q = $request->get('por');
        $ventas = Venta::with('productos')->por($q)->get();
        $cant = 0;
        foreach ($ventas as $v)
        {
            $cant +=$v->total_venta;
        }
        return view('ventas.all', compact('ventas','cant'));
        //return Response::json($ventas);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('ventas.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $data = Request::all();
        $tipo_pago = $data['tipo_pago'];
        $total_venta = $data['total'];
        $paga_con = $data['paga_con'];
        $vuelto = 0;
        $productos = $data['detalle_venta'];
        $datos_venta = array(
            'nro_venta' 	=> 0,
            'fecha_venta' => Carbon::now(),
            'tipo_pago' => $tipo_pago,
            //'estado_venta' => 'finalizado',
            'total_venta' => $total_venta,
            'id_vendedor' => Auth::user()->id,
            'id_cliente' => null
        );

        $venta = null;
        if($paga_con >= $total_venta)
        {
            $venta = Venta::create($datos_venta);
        }


        if($venta != null)
        {
            $prod_check = true;
            foreach($productos as $p){

                $prod = Producto::findOrFail($p['id']);
                $venta->productos()->attach($p['id'], ['cantidad'=>$p['cant_venta']]);

                if($prod->stock >= $p['cant_venta'])
                {

                    $prod->stock = $prod->stock - $p['cant_venta'];
                    $prod->save();
                }
                else{
                    $prod_check = false;
                }

            }

            if($paga_con>$total_venta){$vuelto = $paga_con-$total_venta;}

            if($prod_check){
                $venta['estado_venta'] = 'finalizado';
                $venta->save();
                return Response::json(['id_venta'=>$venta->id,'vuelto'=>$vuelto, 'estado'=>'OK']);
            }
            else{
                return Response::json(['estado'=>'No']);
            }
        }
        else{
            return Response::json(['estado'=>'No']);
        }


	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
