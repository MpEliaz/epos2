<?php namespace Epos\Http\Requests;

use Epos\Http\Requests\Request;

class EditProductoRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
        return [
            'nombre' => 'required',
            'id_marca' => 'required',
            'modelo' => 'required',
            'numero' => 'required | numeric',
            'descripcion_corta' => 'required',
            'descripcion' => 'required',
            'precio_neto' => 'required | numeric',
            'margen' => 'required | numeric',
            'precio_venta' => 'required | numeric',
            'stock' => 'required | numeric',
            'codigo' => 'required',
            'fecha_ingreso' => 'required'
        ];
	}

}
