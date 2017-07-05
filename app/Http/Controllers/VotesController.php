<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepositories;
use Auth;
use Illuminate\Http\Request;

class VotesController extends Controller
{
    protected $answer;

    /**
     * VotesController constructor.
     * @param $answer
     */
    public function __construct(AnswerRepositories $answer)
    {
        $this->answer = $answer;
    }

    public function users($id)
    {
        $user = Auth::guard('api')->user();

        return response()->json(['voted' => $user->hasVotedFor($id)]);
    }

    public function vote($id)
    {
        $answer = $this->answer->byId($id);

        $voted = Auth::guard('api')->user()->voteFor($id);

        if (count($voted['attached']) > 0) {

            $answer->increment('votes_count');

            return response()->json(['voted' => true]);
        }

        $answer->decrement('votes_count');

        return response()->json(['voted' => false]);
    }
}
