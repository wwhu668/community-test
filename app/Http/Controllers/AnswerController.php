<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Repositories\AnswerRepositories;
use Illuminate\Http\Request;
use Auth;

class AnswerController extends Controller
{
    protected $answer;

    /**
     * AnswerController constructor.
     * @param $answer
     */
    public function __construct(AnswerRepositories $answer)
    {
        $this->answer = $answer;
    }

    public function store(StoreAnswerRequest $request, $question)
    {
        $answer = $this->answer->create([
            'question_id' => $question,
            'user_id' => Auth::id(),
            'body' => $request->get('body')
        ]);

        $answer->question()->increment('answers_count');

        return back();
    }
}
