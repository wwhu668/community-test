<?php
/**
 * Created by PhpStorm.
 * User: 81574
 * Date: 2017/7/5
 * Time: 17:25
 */

namespace App\Repositories;


use App\Topic;
use Request;

class TopicRepository
{
    public function getTopicsForTagging(Request $request)
    {
        return Topic::select(['id', 'name'])
            ->where('name', 'like', '%' . $request->query('q') . '%')
            ->get();
    }
}