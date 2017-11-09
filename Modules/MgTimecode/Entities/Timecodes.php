<?php

namespace Modules\MgTimecode\Entities;

use Illuminate\Database\Eloquent\Model;

class Timecodes extends Model
{
	protected $table = 'timecodes';
    protected $fillable = ['timecode', 'created_at', 'updated_at'];
}
