<?php

namespace App\Jobs;

use App\Jobs\Traits\CallsTwitter;

class FetchBlockedUsers extends BaseJob
{
    use CallsTwitter;

    public function handle() : void
    {
        do {
            $response = $this->checkForTwitterErrors(
                $this->twitter()->get('blocks/ids', [
                    'cursor' => $response->next_cursor ?? -1,
                ])
            );

            $ids = array_merge($ids ?? [], $response->ids);
        } while ($response->next_cursor);

        $this->user->update(['blocked' => $this->getUsersDetailsForIds($ids)]);
    }
}
