<?php

namespace Modules\MgContabilidad\Entities;

use Illuminate\Database\Eloquent\Model;

class Estudios extends Model
{
		protected $table = 'estudios';
    protected $fillable = ['estudio', 'created_at', 'updated_at'];
}
