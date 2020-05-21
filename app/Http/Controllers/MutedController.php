<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class MutedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request) : View
    {
        $perPage     = 50;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        return view('muted')
            ->withUser($user = $request->user())
            ->withMutedUsers(
                new LengthAwarePaginator(
                    $user->muted->chunk($perPage)[$currentPage - 1] ?? [],
                    $user->muted->count(),
                    $perPage,
                    $currentPage,
                    ['path' => LengthAwarePaginator::resolveCurrentPath()]
                )
            );
    }
}
