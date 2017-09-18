<?php

namespace Modules\MgProyectos\Entities;

use Illuminate\Database\Eloquent\Model;

class Idiomas extends Model
{
    protected $table = 'idiomas';
    protected $fillable = ['idioma', 'created_at', 'updated_at'];
}
