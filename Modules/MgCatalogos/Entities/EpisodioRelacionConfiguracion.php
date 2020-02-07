<?php

namespace Modules\MgCatalogos\Entities;

use Illuminate\Database\Eloquent\Model;

class EpisodioRelacionConfiguracion extends Model
{
    protected $table = 'episodio_relacion_configuracion';
    protected $fillable = ['id_episodio', 'id_catalogo_configuracion', 'created_at', 'updated_at'];
}
