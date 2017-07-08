<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = ['from_user_id', 'to_user_id', 'body', 'dialog_id'];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->forceFill(['read_at' => $this->freshTimestamp()])->save();
        }
    }

    public function newCollection(array $models = [])
    {
        return new MessageCollection($models);
    }

    public function read()
    {
        return ! is_null($this->read_at);
    }

    public function unread()
    {
        return is_null($this->read_at);
    }

    public function shouldAddUnreadClass()
    {
        if (user()->id === $this->from_user_id) {
            return false;
        }
        return $this->unread();
    }
}
