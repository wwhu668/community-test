<?php

namespace App\Repositories;


use App\Question;
use App\Topic;

/**
 * Class QuestionRepository
 * @package App\Repositories
 */
class QuestionRepository
{
    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function byIdWithTopics($id)
    {
        return Question::with('topics')->find($id);
    }

    public function create(array $attributes)
    {
        return Question::create($attributes);
    }

    /** @test */
    public function byId($id)
    {
        return Question::find($id);
    }

    public function getQuestionsFeed()
    {
        return Question::with('user')->published()->latest('updated_at')->get();
    }
    
    public function normalizeTopic(array $topics)
    {
        $ids = Topic::pluck('id');

        $ids = collect($topics)->map(function ($topic) use ($ids) {
            if (is_numeric($topic) && $ids->contains($topic)) {
                return (int) $topic;
            }

            return Topic::firstOrCreate(['name' => $topic])->id;
        })->toArray();

        Topic::whereIn('id', $ids)->increment('questions_count');
        return $ids;
    }
}