<?php

namespace App\Jobs;

use App\Facades\Twitter;

class FetchMutedUsers extends BaseJob
{
    public function handle() : void
    {
        Twitter::setOauthToken(
            $this->user->token,
            $this->user->token_secret
        );

        do {
            $this->checkForTwitterError(
                $response = Twitter::get('mutes/users/ids', [
                    'cursor' => $response->next_cursor ?? -1,
                ])
            );

            $ids = array_merge($ids ?? [], $response->ids);
        } while ($response->next_cursor);

        $this->user->update(['muted' => $this->getUsersForIds($ids)]);
    }
}
