<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User  extends Authenticatable
{
    protected $visible = [
        'name'
    ];

    /**
     * アクセス可能なバインダーの取得
     */
    public function accessibleBinders()
    {
        return $this->belongsToMany('App\Models\Binder', 'binder_authorities', 'user_id', 'binder_id');
    }
}
