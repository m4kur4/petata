<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Binder extends Model
{
    /**
     * リレーション -バインダー操作権限
     *
     * @return Collection
     */
    public function BinderAuthorities()
    {
        return $this->hasMany('App\Models\BinderAuthority', 'binder_id', 'id');
    }
}
