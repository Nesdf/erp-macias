<?php

namespace Modules\MgEpisodios\Entities;

use Illuminate\Database\Eloquent\Model;

class Vias extends Model
{
    protected $table = 'vias';
    protected $fillable = ['via', 'created_at', 'updated_at'];
}
