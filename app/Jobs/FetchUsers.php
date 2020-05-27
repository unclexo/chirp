<?php

namespace App\Jobs;

use App\Facades\Twitter;

class FetchUsers extends BaseJob
{
    public function handle() : void
    {
        Twitter::setOauthToken(
            $this->user->token,
            $this->user->token_secret
        );

        $data           = Twitter::get('account/verify_credentials');
        $data->settings = Twitter::get('account/settings');

        $this->user->update([
            'id'       => $data->id,
            'name'     => $data->name,
            'nickname' => $data->screen_name,
        ] + compact('data'));
    }
}
