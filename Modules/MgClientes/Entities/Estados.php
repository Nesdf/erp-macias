<?php

namespace Modules\MgClientes\Entities;

use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
    protected $table = 'estados';
    protected $fillable = ['estado', 'created_at', 'updated_at'];
	
	public static function lista_countries($id) {
		
		return \DB::table('estados')
			->where('paisesId', '=', $id)
			->get();
	}
}
