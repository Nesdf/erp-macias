<?php

namespace Modules\MgEpisodios\Entities;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
	protected $table = "jobs";
    protected $fillable = ['job', 'created_at', 'updated_at'];
}
