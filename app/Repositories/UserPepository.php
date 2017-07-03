<?php

namespace App\Repositories;


use App\User;

class UserPepository
{
    public function byId($id)
    {
        return User::find($id);
    }
}