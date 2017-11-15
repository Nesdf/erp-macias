<?php

namespace Modules\MgCalendar\Entities;

use Illuminate\Database\Eloquent\Model;

class FolioActores extends Model
{
    protected $table = 'folio_actores';
    protected $fillable = ['folio', 'factor_id', 'created_at', 'updated_at'];
}
