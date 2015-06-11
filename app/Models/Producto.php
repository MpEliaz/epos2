<?php namespace Epos\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model {

    protected $table = 'productos';
    protected $fillable = ['nombre',
                            'descripcion_corta',
                            'descripcion',
                            'id_marca',
                            'modelo',
                            'numero',
                            'precio_neto',
                            'margen',
                            'precio_venta',
                            'stock',
                            'codigo',
                            'estado',
                            'fecha_ingreso'];

    public function formatear_fecha()
    {
        $this->fecha_ingreso = Carbon::parse($this->fecha_ingreso)->format('Y/m/d H:i:s');
    }

    public function scopeQ($query, $q)
    {
        if($q != "" || $q != null)
        {
            $query->where('productos.nombre','like', '%'.$q.'%')->  orWhere('productos.descripcion_corta','like', '%'.$q.'%');

        }

    }

}