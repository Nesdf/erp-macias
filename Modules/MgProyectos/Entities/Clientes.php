<?php

namespace Modules\MgProyectos\Entities;

use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['razon_social', 'rfc', 'paisId', 'estadoId', 'created_at', 'updated_at'];
	
}
