<?php namespace Epos\Http\Controllers;

use Epos\Http\Requests;
use Epos\Http\Controllers\Controller;
use Epos\Http\Requests\CreateDescuentoRequest;
use Epos\Models\Descuento;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class DescuentosController extends Controller {

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
	public function index()
	{
		$descuentos = Descuento::all();
        $total = count($descuentos);
        return view('descuentos.index', compact('descuentos','total'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('descuentos.nuevo');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateDescuentoRequest $request)
	{
        if ($request->estado == 'on')
        {
            $request->estado = true;
        }
        else
        {
            $request->estado = false;
        }

        $descuento = Descuento::create($request->all());
        return redirect()->route('descuentos.index');
        //return dd($descuento);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $descuentos = Descuentos::findOrFail($id);
        return dd($descuentos);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $descuento = Descuento::findOrFail($id);
        return view('descuentos.modificar', compact('descuento'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $desc = Descuento::findOrFail($id);
        $desc->fill(Request::all());
        //return dd(Request::all());
                if ($desc->estado == 'on')
                {
                    $desc->estado = true;
                }
                else
                {
                    $desc->estado = false;
                }
                $desc->save();

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

    public function get_desc()
    {
        if(Request::ajax())
        {
            $descuento = Request::get('cod_desc');
            $desc = Descuento::where('codigo_descuento','=',$descuento)->get();
            return response()->json($desc);
        }

    }

    public function activar()
    {
        if(Request::ajax())
        {
            $id = Request::get('id');

            $descuento = Descuento::findOrFail($id);
            $descuento->estado = true;
            $descuento->save();
            return Response::json($descuento);
        }
        return false;
    }

    public function desactivar()
    {
        if(Request::ajax())
        {
            $id = Request::get('id');

            $descuento = Descuento::findOrFail($id);
            $descuento->estado = false;
            $descuento->save();
            return Response::json($descuento);
        }
        return false;
    }

}
