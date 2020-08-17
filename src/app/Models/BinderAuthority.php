<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BinderAuthority extends Model
{
    protected $fillable = [
        'id', 
        'user_id',
        'binder_id',
        'level',
    ];
}
