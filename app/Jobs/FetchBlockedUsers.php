<?php

namespace App\Jobs;

use App\Facades\Twitter;

class FetchBlockedUsers extends BaseJob
{
    public function handle() : void
    {
        Twitter::setOauthToken(
            $this->user->token,
            $this->user->token_secret
        );

        do {
            $this->checkForTwitterError(
                $response = Twitter::get('blocks/ids', [
                    'cursor' => $response->next_cursor ?? -1,
                ])
            );

            $ids = array_merge($ids ?? [], $response->ids);
        } while ($response->next_cursor);

        $this->user->update(['blocked' => $this->getUsersDetailsForIds($ids)]);
    }
}
