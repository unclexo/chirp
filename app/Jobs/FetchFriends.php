<?php

namespace App\Jobs;

use App\Facades\Twitter;

class FetchFriends extends BaseJob
{
    public function handle() : void
    {
        Twitter::setOauthToken(
            $this->user->token,
            $this->user->token_secret
        );

        $this->makeDiffFor('friends');
    }
}
