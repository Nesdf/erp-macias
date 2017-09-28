<?php

namespace Modules\MgEpisodios\Entities;

use Illuminate\Database\Eloquent\Model;

class Salas extends Model
{
	protected $table = "salas";
    protected $fillable = ['sala', 'created_at', 'updated_at'];
}
