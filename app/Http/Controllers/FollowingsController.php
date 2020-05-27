<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request) : View
    {
        return view('followings')
            ->withUser($user = $request->user())
            ->withDiffs(
                DB::table('diffs')
                    ->selectRaw('
                        DATE(created_at) AS date,
                        user_id,
                        JSON_ARRAYAGG(additions) AS additions,
                        JSON_ARRAYAGG(deletions) AS deletions
                    ')
                    ->where('user_id', $user->id)
                    ->where('for', 'friends')
                    ->groupBy('date')
                    ->groupBy('user_id')
                    ->orderBy('date', 'DESC')
                    ->get()
            );
    }
}
