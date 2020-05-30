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
        $query = $request->q
            ? $request->user()->favorites()->matching($request->q)
            : $request->user()->favorites()->latest();

        return view('likes')
            ->withLikes($query->simplePaginate(30))
            ->withQuery($request->q);
    }
}
