<?php

namespace App\Jobs;

use App\Facades\Twitter;
use App\Jobs\Traits\CallsTwitter;

class FetchUser extends BaseJob
{
    use CallsTwitter;

    public function handle() : void
    {
        Twitter::setOauthToken(
            $this->user->token,
            $this->user->token_secret
        );

        $data = $this->checkForTwitterErrors(
            Twitter::get('account/verify_credentials')
        );

        $data->settings = $this->checkForTwitterErrors(
            Twitter::get('account/settings')
        );

        $this->user->update([
            'id'       => $data->id,
            'name'     => $data->name,
            'nickname' => $data->screen_name,
        ] + compact('data'));
    }
}
