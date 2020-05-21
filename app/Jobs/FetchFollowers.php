<?php

namespace App\Jobs;

use App\Facades\Twitter;

class FetchFollowers extends BaseJob
{
    public function handle() : void
    {
        Twitter::setOauthToken(
            $this->user->token,
            $this->user->token_secret
        );

        $this->makeDiffFor('followers');
    }
}
