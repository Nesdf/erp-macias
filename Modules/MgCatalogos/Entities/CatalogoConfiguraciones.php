<?php

namespace Modules\MgCatalogos\Entities;

use Illuminate\Database\Eloquent\Model;

class CatalogoConfiguraciones extends Model
{
    protected $table = 'catalogo_configuraciones';
    protected $fillable = ['nombre', 'created_at', 'updated_at'];
}
