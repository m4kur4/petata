<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * アクセス可能なバインダーの取得
     */
    public function accessibleBinders()
    {
        return $this->belongsToMany('App\Binder', 'binder_authorities', 'user_id', 'binder_id');
    }
}
