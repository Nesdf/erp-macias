<?php

namespace Modules\MgCalendar\Entities;

use Illuminate\Database\Eloquent\Model;

class Tabulador extends Model
{
  protected $table = 'tabulador';
  protected $fillable = ['id','tabulador', 'created_at', 'updated_at'];


  public static function getTabulador($loops)
  {
    return Tabulador::select('tabulador')
      ->where('id', $loops)
      ->get();
  }
}
