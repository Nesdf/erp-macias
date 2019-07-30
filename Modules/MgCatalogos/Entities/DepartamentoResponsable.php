<?php

namespace Modules\MgCatalogos\Entities;

use Illuminate\Database\Eloquent\Model;

class DepartamentoResponsable extends Model
{
    protected $table = 'rechazo_departamento_responsable';
    protected $fillable = ['nombre', 'descripcion', 'created_at', 'updated_at'];
}
