<?php

namespace App\Jobs;

use App\Facades\Twitter;
use App\Jobs\Traits\MakesDiffs;

class FetchFollowers extends BaseJob
{
    use MakesDiffs;

    public function handle() : void
    {
        Twitter::setOauthToken(
            $this->user->token,
            $this->user->token_secret
        );

        $this->makeDiffFor('followers');
    }
}
