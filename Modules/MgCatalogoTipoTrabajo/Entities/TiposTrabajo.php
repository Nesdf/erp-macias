<?php

namespace Modules\MgCatalogoTipoTrabajo\Entities;

use Illuminate\Database\Eloquent\Model;

class TiposTrabajo extends Model
{
    protected $table = 'tipos_trabajo';
    protected $fillable = ['nombre', 'descripcion', 'created_at', 'updated_at'];
}
