<?php

namespace Modules\MgPersonal\Entities;

use Illuminate\Database\Eloquent\Model;

class RoutesAccess extends Model
{
	protected $table = "routes_access";
    protected $fillable = ['alias_name', 'user_id'];

    public static function DeletePermiso($user_id, $permiso)
	{
		return \DB::select( \DB::raw("DELETE FROM routes_access WHERE user_id  = ". $user_id ." AND alias_name = '". $permiso."'") );
	}
}
