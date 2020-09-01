<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Labeling extends Model
{
    protected $fillable = [
        'label_id',
        'image_id'
    ];
}
