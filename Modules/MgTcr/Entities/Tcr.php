<?php

namespace Modules\MgTcr\Entities;

use Illuminate\Database\Eloquent\Model;

class Tcr extends Model
{
    protected $table = 'tcrs';
    protected $fillable = ['tcr', 'created_at', 'updated_at'];
}
