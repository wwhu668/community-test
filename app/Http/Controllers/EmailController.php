<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function verify($token)
    {
        $user = User::where('confirmation_token', $token)->first();

        if (is_null($user)) {
            flash('游戏验证失败', 'danger');
            return redirect('/');
        }

        $user->update([
            'is_active' => 1,
            'confirmation_token' => str_random(48)
        ]);

        \Auth::login($user);
        flash('邮箱验证成功', 'success');

        return redirect('/home');
    }
}
