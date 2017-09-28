<?php

namespace Modules\MgPersonal\Entities;

use Illuminate\Database\Eloquent\Model;

class RoutesAccess extends Model
{
	protected $table = "routes_access";
    protected $fillable = ['alias_name', 'user_id'];
}
