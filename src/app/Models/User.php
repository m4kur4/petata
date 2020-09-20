<?php

namespace App\Models;
use App\Notifications\PasswordRemindNotification;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Log;

class User  extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

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

    /**
     * パスワード再設定メールの送信
     *
     * @param  string  $token
     */
    public function sendPasswordResetNotification($token)
    {Log::debug($token);
        $this->notify(new PasswordRemindNotification($token));
    }
}
