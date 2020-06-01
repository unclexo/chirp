<?php

namespace App\Jobs;

use App\Jobs\Traits\CallsTwitter;

class FetchMutedUsers extends BaseJob
{
    use CallsTwitter;

    public function handle() : void
    {
        do {
            $response = $this->checkForTwitterErrors(
                $this->twitter()->get('mutes/users/ids', [
                    'cursor' => $response->next_cursor ?? -1,
                ])
            );

            $ids = array_merge($ids ?? [], $response->ids);
        } while ($response->next_cursor);

        $this->user->update(['muted' => $this->getUsersDetailsForIds($ids)]);
    }
}
