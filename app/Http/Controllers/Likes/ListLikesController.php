<?php

namespace App\Http\Controllers\Likes;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListLikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request) : View
    {
        return view('likes')->withLikes(
            $request->user()->favorites()->orderBy('id', 'desc')->paginate(30)
        );
    }
}
