<?php

namespace Modules\MgSucursales\Entities;

use Illuminate\Database\Eloquent\Model;

class Paises extends Model
{
	protected $table = "paises";
    protected $fillable = ['pais', 'surname'];

    public static function Sucursales()
    {
    	return \DB::table('paises')
    		->join('estados', 'paises.id', '=', 'estados.paisesId')
    		->select('paises.pais', 'estados.estado', 'estados.id as id_estado' , 'paises.id as id_pais')
    		->groupBy('paises.pais', 'estados.estado', 'estados.id', 'paises.id')
    		->get();
    }

    public static function sucursal($id)
    {
        return \DB::table('paises')
            ->join('estados', 'paises.id', '=', 'estados.paisesId')
            ->select('paises.pais', 'estados.estado', 'estados.id as id_estado' , 'paises.id as id_pais','estados.id as id')
            ->where('estados.paisesId', '=', $id)
            ->get();
    }
}
