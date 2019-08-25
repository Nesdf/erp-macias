<?php

namespace Modules\MgMetodoEnvio\Entities;

use Illuminate\Database\Eloquent\Model;

class MetodoEnvio extends Model
{
    protected $table = 'metodo_envio';
    protected $fillable = ['metodo_envio', 'created_at', 'updated_at'];
}
