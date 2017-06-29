<?php

namespace App\Repositories;


use App\Answer;

class AnswerRepositories
{
    public function create(array $attributes)
    {
        return Answer::create($attributes);
    }
}