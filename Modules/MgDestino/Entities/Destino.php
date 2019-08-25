<?php

namespace Modules\MgDestino\Entities;

use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    protected $table = 'destino';
    protected $fillable = ['destino', 'created_at', 'updated_at'];
}
