<?php namespace Epos\Models;


use Illuminate\Database\Eloquent\Model;

class Descuento extends Model{

    protected $table = 'descuentos';
    protected $fillable = ['codigo_descuento',
                            'titulo',
                            'descripcion',
                            'descuento'];
} 