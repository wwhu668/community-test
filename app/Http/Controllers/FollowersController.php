<?php

namespace App\Http\Controllers;

use App\Repositories\UserPepository;
use Illuminate\Http\Request;
use Auth;

class FollowersController extends Controller
{
    protected $user;

    /**
     * FollowersController constructor.
     * @param $user
     */
    public function __construct(UserPepository $user)
    {
        $this->user = $user;
    }

    public function index($id)
    {
        $user = $this->user->byId($id);

        $followers = $user->followersUser()->pluck('follower_id')->toArray();

        if(in_array(Auth::guard('api')->user()->id, $followers)) {
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    public function follow()
    {
        $userToFollow = $this->user->byId(request('user'));

        $followed = Auth::guard('api')->user()->followThisUser($userToFollow->id);

        if (empty($followed['attached'])) {
            $userToFollow->decrement('followers_count');

            return response()->json(['followed' => false]);
        }

        // TODO
        $userToFollow->increment('followers_count');

        return response()->json(['followed' => true]);
    }
}
