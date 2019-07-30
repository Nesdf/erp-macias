<?php

namespace Modules\MgCatalogos\Entities;

use Illuminate\Database\Eloquent\Model;

class TipoError extends Model
{
    protected $table = 'rechazo_tipo_error';
    protected $fillable = ['nombre', 'descripcion', 'created_at', 'updated_at'];
}
