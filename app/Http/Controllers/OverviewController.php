<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Presenters\UserPresenter;

class OverviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request) : View
    {
        return view('overview')->withUser(
            new UserPresenter($request->user())
        );
    }
}
