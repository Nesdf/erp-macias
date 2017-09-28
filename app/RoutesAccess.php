<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoutesAccess extends Model
{
    //
    protected $table = "routes_access";
    protected $fillable = ['route', 'alias_name', 'user_id'];

    public static function seeRoute($id_user, $aliasRoute)
    {
    	$exist = \DB::table('routes_access')
    		->where('user_id', $id_user)
    		->where('alias_name', $aliasRoute)
    		->first();
    	if ($exist) {
    		return true;
    	}else{
    		return false;
    	}
    }
}
