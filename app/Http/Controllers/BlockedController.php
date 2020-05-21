<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BlockedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request) : View
    {
        $perPage     = 50;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        return view('blocked')
            ->withUser($user = $request->user())
            ->withBlockedUsers(
                new LengthAwarePaginator(
                    $user->blocked->chunk($perPage)[$currentPage - 1] ?? [],
                    $user->blocked->count(),
                    $perPage,
                    $currentPage,
                    ['path' => LengthAwarePaginator::resolveCurrentPath()]
                )
            );
    }
}
