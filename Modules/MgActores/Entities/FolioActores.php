<?php

namespace Modules\MgActores\Entities;

use Illuminate\Database\Eloquent\Model;

class FolioActores extends Model
{
	protected $table = 'folio_actores';
    protected $fillable = ['folio', 'actor_id', 'created_at', 'updated_at'];
}
