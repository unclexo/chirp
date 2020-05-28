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
        $query = $request->user()->favorites()->latest();

        return view('likes')->withLikes(
            $request->q
                ? $query->whereRaw('MATCH(full_text) AGAINST(? IN NATURAL LANGUAGE MODE)', [$request->q])->paginate(30)
                : $query->paginate(30)
        )
            ->withQ($request->q);
    }
}
