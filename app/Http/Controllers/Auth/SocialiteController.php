<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Abraham\TwitterOAuth\TwitterOAuth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    protected TwitterOAuth $twitter;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider() : \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function handleProviderCallback() : \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $abstractUser = Socialite::driver('twitter')->user();

        $user = User::firstOrCreate(
            ['id' => $abstractUser->id],
            [
                'id'           => $abstractUser->id,
                'name'         => $abstractUser->name,
                'nickname'     => $abstractUser->nickname,
                'token'        => $abstractUser->token,
                'token_secret' => $abstractUser->tokenSecret,
                'data'         => $abstractUser->user,
                'followers'    => [],
                'friends'      => [],
                'muted'        => [],
                'blocked'      => [],
            ]
        );

        Auth::login($user);

        return redirect()->route('overview');
    }

    public function logout() : \Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
