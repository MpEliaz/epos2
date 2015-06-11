<?php namespace Epos\Models;


use Carbon\Carbon;
use Epos\User;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model{

    protected $table = 'ventas';
    protected $fillable = ['nro_venta','fecha_venta', 'hora_venta', 'tipo_pago', 'estado_venta', 'total_venta', 'id_vendedor', 'id_cliente'];
    public $timestamps = false;

    public function productos()
    {
        return  $this->belongsToMany('Epos\Models\Producto','venta_detalle')->withTimestamps()->withPivot('cantidad');
    }

    public function nombre_vendedor()
    {
        return User::where('id', $this->id_vendedor)->first()->nombres;
    }

    public function fecha_para_humanos()
    {
        return Carbon::parse($this->fecha_venta)->format('d/m/Y - H:m');
    }
}