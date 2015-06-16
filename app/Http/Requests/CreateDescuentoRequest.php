<?php namespace Epos\Http\Requests;

use Epos\Http\Requests\Request;

class CreateDescuentoRequest extends Request {

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
            'codigo_descuento' => 'required',
            'titulo' => 'required',
            'descripcion' => 'required',
            'descuento' => 'required | numeric'
		];
	}

}
