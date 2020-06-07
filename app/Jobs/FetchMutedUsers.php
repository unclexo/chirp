<?php

namespace App\Jobs;

use App\Facades\Twitter;
use App\Jobs\Traits\CallsTwitter;

class FetchMutedUsers extends BaseJob
{
    use CallsTwitter;

    public function fire() : void
    {
        do {
            $response = $this->guardAgainstTwitterErrors(
                Twitter::get('mutes/users/ids', [
                    'cursor' => $response->next_cursor ?? -1,
                ])
            );

            $ids = array_merge($ids ?? [], $response->ids);
        } while ($response->next_cursor);

        $this->user->update(['muted' => $this->getUsersDetailsForIds($ids)]);
    }
}
