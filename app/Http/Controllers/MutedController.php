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
        $user        = $request->user();

        return view('muted')
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
