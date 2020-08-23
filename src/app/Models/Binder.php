<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Binder extends Model
{
    protected $fillable = [
        'create_user_id',
        'name',
    ];

    protected $appends = [
        'isOwn',
        'isFavorite'
    ];

    /**
     * リレーション -ラベル
     *
     * @return Collection
     */
    public function labels()
    {
        return $this->hasMany('App\Models\Label', 'binder_id', 'id');
    }

    /**
     * リレーション -バインダー操作権限
     *
     * @return Collection
     */
    public function binderAuthorities()
    {
        return $this->hasMany('App\Models\BinderAuthority', 'binder_id', 'id');
    }

    /**
     * リレーション -お気に入りバインダー
     *
     * @return Collection
     */
    public function BinderFavorites()
    {
        return $this->hasMany('App\Models\BinderFavorite', 'binder_id', 'id');
    }

    /**
     * アクセサ -バインダーがログインユーザーのものかどうか
     */
    public function isOwn()
    {
        $user_id = Auth::id();
        return $this->create_user_id == $user_id;
    }

    /**
     * アクセサ - バインダーがログインユーザーのお気に入りかどうか
     */
    public function isFavorite()
    {
        $user_id = Auth::id();
        return $this->BinderFavorites()
            ->where('binder_id', $this->id)
            ->where('user_id', $user_id)
            ->exists();
    }
}
