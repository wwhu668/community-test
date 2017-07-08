<?php
/**
 * Created by PhpStorm.
 * User: 81574
 * Date: 2017/7/8
 * Time: 11:12
 */

namespace App;


use Illuminate\Database\Eloquent\Collection;

class MessageCollection extends Collection
{
    public function markAsRead()
    {
        $this->each(function($message) {
            if ($message->to_user_id == user()->id) {
                $message->markAsRead();
            }
        });
    }
}