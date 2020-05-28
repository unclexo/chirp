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
        $query = $request->user()->favorites();
        $query = $request->q
            ? $query->matching($request->q)
            : $query->latest();

        return view('likes')
            ->withLikes($query->paginate(30))
            ->withQuery($request->q);
    }
}
