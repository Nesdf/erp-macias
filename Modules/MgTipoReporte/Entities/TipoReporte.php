<?php

namespace Modules\MgTipoReporte\Entities;

use Illuminate\Database\Eloquent\Model;

class TipoReporte extends Model
{
	protected $table = 'tipo_reportes';
    protected $fillable = ['tipo', 'created_at', 'updated_at'];
}
