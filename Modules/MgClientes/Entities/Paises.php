<?php

namespace Modules\MgClientes\Entities;

use Illuminate\Database\Eloquent\Model;

class Paises extends Model
{
	protected $table = 'paises';
    protected $fillable = ['pais','created_at', 'updated_at'];
}
