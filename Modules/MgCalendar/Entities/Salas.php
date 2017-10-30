<?php

namespace Modules\MgCalendar\Entities;

use Illuminate\Database\Eloquent\Model;

class Salas extends Model
{
	protected $table = 'salas';
    protected $fillable = ['id','sala', 'estudio_id', 'created_at', 'updated_at'];

    public static function listSalas($id)
    {
    	return \DB::table('salas')
			->where('id', '=', $id)
			->get();
    }
}
