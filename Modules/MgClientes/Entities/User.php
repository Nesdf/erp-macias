<?php

namespace Modules\MgClientes\Entities;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'job', 'ap_paterno', 'ap_materno', 'password', 'password','created_at', 'updated_at'];
	protected $hidden = ['password'];
}
