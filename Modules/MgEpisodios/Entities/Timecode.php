<?php

namespace Modules\MgEpisodios\Entities;

use Illuminate\Database\Eloquent\Model;

class Timecode extends Model
{
    protected $table = 'timecodes';
    protected $fillable = ['timecode', 'created_at', 'updated_at'];
}
