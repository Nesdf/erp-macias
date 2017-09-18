<?php

namespace Modules\MgEpisodios\Entities;

use Illuminate\Database\Eloquent\Model;

class TimeCodes extends Model
{
	protected $table = 'timecode';
    protected $fillable = ['fecha', 'timecode', 'observaciones', 'id_calificar_material', 'created_at', 'updated_at'];
}
