<?php

namespace App\Http\Controllers\Tweet\Update;

use App\Models\Tweet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $tweetId = (int) $request->route("tweetId");
        $tweet = Tweet::where('id',$tweetId)->firstOrFail();
        return View('tweet.update')->with('tweet',$tweet);
    }
}
