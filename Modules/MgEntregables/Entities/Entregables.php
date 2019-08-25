<?php

namespace Modules\MgEntregables\Entities;

use Illuminate\Database\Eloquent\Model;

class Entregables extends Model
{
    protected $table = 'entregables';
    protected $fillable = ['entregable', 'created_at', 'updated_at'];
}
