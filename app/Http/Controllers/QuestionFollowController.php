<?php

namespace App\Http\Controllers;

use App\Repositories\QuestionRepository;
use Auth;
use Illuminate\Http\Request;

/**
 * Class QuestionFollowController
 * @package App\Http\Controllers
 */
class QuestionFollowController extends Controller
{
    /**
     * @var QuestionRepository
     */
    protected $question;
    /**
     * QuestionFollowController constructor.
     */
    public function __construct(QuestionRepository $question)
    {
        $this->middleware('auth');
        $this->question = $question;
    }

    /**
     * @param $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function follow($question)
    {
        Auth::user()->followThis($question);

        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function follower(Request $request)
    {
        return response()->json([
            'followed' => user('api')->followed($request->get('question'))
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function followThis(Request $request)
    {
        $question = $this->question->byId($request->get('question'));
        $followed = user('api')->followThis($question->id);

        if(empty($followed['detached'])) {
            $question->increment('followers_count');
            return response()->json(['followed' => true]);
        }

        $question->decrement('followers_count');
        return response()->json(['followed' => false]);
    }
}
