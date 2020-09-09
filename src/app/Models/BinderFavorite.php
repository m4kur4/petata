<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BinderFavorite extends Model
{
    protected $fillable = [
        'binder_id', 'user_id'
    ];
}
