<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable = [
        'binder_id',
        'name',
        'description'
    ];

    protected $visible = [
        'binder_id',
        'name',
        'description'
    ];
}
