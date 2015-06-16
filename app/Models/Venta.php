<?php namespace Epos\Models;


use Carbon\Carbon;
use Epos\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        return Carbon::parse($this->fecha_venta)->format('d/m/Y - H:i');
    }

    public function scopePor($query, $q)
    {
        if($q != "" || $q != null)
        {
            switch($q){
                case 'dia':
                    $query->where(DB::raw('day(fecha_venta)'),'=',Carbon::today()->format('d'));
                    break;
                case 'semana':
                    $query->whereBetween(DB::raw('date(fecha_venta)'),[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);
                    break;
                case 'mes':
                    $query->where(DB::raw('month(fecha_venta)'),'=',Carbon::today()->format('m'));
                    break;
            }
        }
    }

}