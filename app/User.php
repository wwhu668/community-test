<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Naux\Mail\SendCloudTemplate;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'confirmation_token', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function owns(Model $model)
    {
        return $this->id === $model->user_id;
    }

    public function sendPasswordResetNotification($token)
    {
        $data = [ 'url' => url('password/reset', $token) ];
        $template = new SendCloudTemplate('zhihu_app_password_reset', $data);

        \Mail::raw($template, function ($message) {
            $message->from('wwhu668@163.com', 'Laravel');

            $message->to($this->email);
        });
    }
}