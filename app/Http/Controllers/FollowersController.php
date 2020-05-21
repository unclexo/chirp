<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request) : View
    {
        return view('followers')
            ->withUser($user = $request->user())
            ->withDiffs(
                $user
                    ->diffs()
                    ->whereFor('followers')
                    ->where(function ($query) {
                        return $query
                            ->where('additions', '!=', '[]')
                            ->orWhere('deletions', '!=', '[]');
                    })
                    ->latest()
                    ->simplePaginate(10)
            );
    }
}
