<?php namespace Epos\Models;


use Illuminate\Database\Eloquent\Model;

class Marca extends Model{

    protected $table = 'marcas';
    protected $fillable = array('nombre');


    public function scopeQ($query, $q)
    {
        if($q != "" || $q != null)
        {
            $query->where('nombre','like', '%'.$q.'%');

        }

    }
} 