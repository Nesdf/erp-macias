<?php

namespace Modules\MgClientes\Entities;

use Illuminate\Database\Eloquent\Model;

class Puestos extends Model
{
    protected $table = 'jobs';
    protected $fillable = ['job', 'created_at', 'updated_at'];
}
