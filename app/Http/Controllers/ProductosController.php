<?php namespace Epos\Http\Controllers;

use Epos\Http\Requests;
use Epos\Http\Requests\CreateProductoRequest;
use Epos\Http\Requests\EditProductoRequest;
use Epos\Models\Marca;
use Epos\Models\Producto;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;


class ProductosController extends Controller {

    protected $request;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->request = $request;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(\Illuminate\Http\Request $request)
	{
        $q = $request->get('q');

		$productos = Producto::join('marcas', 'productos.id_marca', '=', 'marcas.id')
            ->select('productos.id','productos.nombre','productos.descripcion_corta','productos.descripcion','marcas.nombre as marca','productos.modelo','productos.precio_neto','productos.precio_venta','productos.stock','productos.estado')
            ->q($q)
            ->paginate();

        return view('productos.index', compact('productos'));
        //return dd($productos);
	}

        /**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $data = Marca::all();
        $marcas = $data->lists('nombre','id');

		return view('productos.nuevo',compact('marcas'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateProductoRequest $request)
	{

        if ($request->estado == 'on')
        {
            $request->estado = true;
        }
        else
        {
            $request->estado = false;
        }

        $producto = Producto::create($request->all());
        return redirect()->route('productos.index');
        //return dd($producto);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$producto = Producto::findOrFail($id);
        return dd($producto);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$producto = Producto::findOrFail($id);
        $data = Marca::all();
        $marcas = $data->lists('nombre','id');

        return view('productos.modificar', compact('producto', 'marcas'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(EditProductoRequest $request, $id)
	{
		$producto = Producto::findOrFail($id);
        $producto->fill($request->all());
        if ($producto->estado == 'on')
        {
            $producto->estado = true;
        }
        else
        {
            $producto->estado = false;
        }
        $producto->formatear_fecha();
        $producto->save();
        return redirect()->back()->with('message','Modificado correctamente');
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

    public function activar()
    {
        if(Request::ajax())
        {
            $id = Request::get('id');

            $producto = Producto::findOrFail($id);
            $producto->estado = true;
            $producto->save();
            return Response::json($producto);
        }
        return false;
    }

    public function desactivar()
    {
        if(Request::ajax())
        {
            $id = Request::get('id');

            $producto = Producto::findOrFail($id);
            $producto->estado = false;
            $producto->save();
            return Response::json($producto);
        }
        return false;
    }

}
