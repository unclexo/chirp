<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function __invoke(Request $request) : View
    {
        $query = $request->user()->favorites()->latest();

        return view('favorites')->withFavorites(
            $request->q
                ? $query->whereRaw('MATCH(text) AGAINST(? IN NATURAL LANGUAGE MODE)', [$request->q])->simplePaginate(30)
                : $query->simplePaginate(30)
        )
            ->withQ($request->q);
    }
}
