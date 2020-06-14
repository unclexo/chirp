<?php

namespace App\Jobs;

use App\User;
use App\Blocked;
use App\Facades\Twitter;
use App\Jobs\Traits\CallsTwitter;
use Illuminate\Support\Collection;

class FetchBlockedUsers extends BaseJob
{
    use CallsTwitter;

    protected Collection $blocked;

    public function __construct(User $user)
    {
        parent::__construct($user);

        $this->blocked = new Collection;
    }

    public function fire() : void
    {
        $this
            ->fetchBlockedUsers()
            ->deleteUnecessaryBlockedUsers()
            ->insertNewlyBlockedUsers()
        ;
    }

    protected function fetchBlockedUsers() : self
    {
        do {
            $response = $this->guardAgainstTwitterErrors(
                Twitter::get('blocks/ids', [
                    'cursor' => $response->next_cursor ?? -1,
                ])
            );

            $this->blocked = $this->blocked->concat($response->ids);
        } while ($response->next_cursor);

        return $this;
    }

    protected function deleteUnecessaryBlockedUsers() : self
    {
        Blocked::whereUserId($this->user->id)
            ->whereNotIn('id', $this->blocked->pluck('id'))
            ->delete();

        return $this;
    }

    protected function insertNewlyBlockedUsers() : self
    {
        $existing = Blocked::select('id')
            ->whereUserId($this->user->id)
            ->get()
            ->pluck('id');

        $newlyBlockedUsers = $this->getUsersDetailsForIds(
            $this->blocked->whereNotIn('id', $existing)
        );

        Blocked::insert($newlyBlockedUsers->map(function (object $newlyBlockedUser) {
            return [
                'id'       => $newlyBlockedUser->id,
                'user_id'  => $this->user->id,
                'name'     => $newlyBlockedUser->name,
                'nickname' => $newlyBlockedUser->screen_name,
                'data'     => json_encode($newlyBlockedUser),
            ];
        })->toArray());

        return $this;
    }
}
