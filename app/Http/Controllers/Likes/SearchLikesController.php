<?php

namespace App\Http\Controllers\Likes;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class SearchLikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request)
    {
        if (! $request->terms) {
            return Redirect::route('likes.index');
        }

        return view('search')
            ->withLikes(
                $request->user()->favorites()->matching($request->terms, $request->sort_by)->paginate(30)
            )
            ->withSortBy($request->sort_by)
            ->withTerms($request->terms);
    }
}
