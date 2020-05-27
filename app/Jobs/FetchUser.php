<?php

namespace App\Jobs;

use App\Facades\Twitter;

class FetchUser extends BaseJob
{
    public function handle() : void
    {
        Twitter::setOauthToken(
            $this->user->token,
            $this->user->token_secret
        );

        $this->checkForTwitterError(
            $data = Twitter::get('account/verify_credentials')
        );

        $this->checkForTwitterError(
            $data->settings = Twitter::get('account/settings')
        );

        $this->user->update([
            'id'       => $data->id,
            'name'     => $data->name,
            'nickname' => $data->screen_name,
        ] + compact('data'));
    }
}
