<?php

namespace Modules\MgSucursales\Entities;

use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
	protected $table = "estados";
    protected $fillable = ['estado', 'paisesId'];
}
