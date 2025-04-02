<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionRole extends Model
{
    protected $table = 'action_role';

    protected $fillable = ['action_id', 'role_id'];

    public $timestamps = false;
}
