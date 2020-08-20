<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Binder extends Model
{
    protected $fillable = [
        'create_user_id',
        'name',
    ];

    /**
     * リレーション -ラベル
     *
     * @return Collection
     */
    public function Labels()
    {
        return $this->hasMany('App\Models\Label', 'binder_id', 'id');
    }

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
