<?php

namespace App\Repositories;


use App\Message;

/**
 * Class MessageRepository
 * @package App\Repositories
 */
class MessageRepository
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return Message::create($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getMessageList()
    {
        $msgIds = Message::selectRaw('max(id) as id')
            ->where('from_user_id', user()->id)
            ->orWhere('to_user_id', user()->id)
            ->groupBy('dialog_id')
            ->pluck('id')
            ->toArray();

        return Message::with(['fromUser' => function ($query) {
            return $query->select(['id', 'name', 'avatar']);
        }, 'toUser' => function ($query) {
            return $query->select(['id', 'name', 'avatar']);
        }])->whereIn('id', $msgIds)->get();
    }

    /**
     * @param $dialogId
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public function getDialogMessagesBy($dialogId)
    {
        return Message::with(['fromUser' => function ($query) {
            return $query->select(['id', 'name', 'avatar']);
        }, 'toUser' => function ($query) {
            return $query->select(['id', 'name', 'avatar']);
        }])->where('dialog_id', $dialogId)->latest()->get();
    }

    /**
     * @param $dialogId
     * @return mixed
     */
    public function getSingleMessageBy($dialogId)
    {
        return Message::where('dialog_id', $dialogId)->first();
    }
}