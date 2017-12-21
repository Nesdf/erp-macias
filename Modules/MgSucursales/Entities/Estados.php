<?php

namespace Modules\MgSucursales\Entities;

use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
	protected $table = "estados";
    protected $fillable = ['estado', 'paisesId'];

    public static function destroyAll($id){

    	return \DB::select(\DB::raw('DELETE FROM estados WHERE "paisesId" ='. $id));
    }
}
