<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Log;

class PasswordRemindNotification extends Notification
{
    use Queueable;

    /**
     * @var string $tolen パスワードリセットトークン
     */
    public $token;

    /**
     * Create a new notification instance.
     *
     * @parmm string $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from('petata.info@gmail.com', config('app.name'))
                    ->subject('パスワードの再設定')
                    ->line('下のリンクをクリックしてパスワードを再設定してください。')
                    ->action('パスワード再設定', url(config('app.url').'/user/auth/password/reset?token='.$this->token))
                    ->line('※リンクの有効期限は1時間です。');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
