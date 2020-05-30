<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request) : View
    {
        return view('likes')
            ->withLikes($query = $request->q
                ? $request->user()->favorites()->matching($request->q)->simplePaginate(30)
                : $request->user()->favorites()->latest()->paginate(30)
            )
            ->withQuery($request->q);
    }
}
