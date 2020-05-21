<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OverviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request) : View
    {
        return view('overview')
            ->withUser($user = $request->user())
            ->withAvatar(
                str_replace('_normal', '', $user->data->profile_image_url_https)
            )
            ->withDescription(
                $this->expand($user->data->description, optional($user->data->entities)->description)
            )
            ->withWebsite([
                'display_url'  => optional(optional(optional(optional($user->data->entities)->url)->urls)[0])->display_url,
                'expanded_url' => optional(optional(optional(optional($user->data->entities)->url)->urls)[0])->expanded_url,
            ])
            ->withCreatedAt(
                $user
                    ? Carbon::parse($user->data->created_at)
                    : null
            );
    }

    protected function expand(string $text, object $entities) : string
    {
        foreach ($entities->urls as $url) {
            $text = str_replace($url->url, '<a href="' . $url->expanded_url . '" target="_blank" class="font-semibold hover:text-white">' . $url->display_url . '</a>', $text);
        }

        return $text;
    }
}
