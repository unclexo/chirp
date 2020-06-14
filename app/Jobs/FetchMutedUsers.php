<?php

namespace App\Jobs;

use App\User;
use App\Muted;
use App\Facades\Twitter;
use App\Jobs\Traits\CallsTwitter;
use Illuminate\Support\Collection;

class FetchMutedUsers extends BaseJob
{
    use CallsTwitter;

    protected Collection $muted;

    public function __construct(User $user)
    {
        parent::__construct($user);

        $this->muted = new Collection;
    }

    public function fire() : void
    {
        $this
            ->fetchMutedUsers()
            ->deleteUnecessaryMutedUsers()
            ->insertNewlyMutedUsers()
        ;
    }

    protected function fetchMutedUsers() : self
    {
        do {
            $response = $this->guardAgainstTwitterErrors(
                Twitter::get('mutes/users/ids', [
                    'cursor' => $response->next_cursor ?? -1,
                ])
            );

            $this->muted = $this->muted->concat($response->ids);
        } while ($response->next_cursor);

        return $this;
    }

    protected function deleteUnecessaryMutedUsers() : self
    {
        Muted::whereUserId($this->user->id)
            ->whereNotIn('id', $this->muted->pluck('id'))
            ->delete();

        return $this;
    }

    protected function insertNewlyMutedUsers() : self
    {
        $existing = Muted::select('id')
            ->whereUserId($this->user->id)
            ->get()
            ->pluck('id');

        $newlyMutedUsers = $this->getUsersDetailsForIds(
            $this->muted->whereNotIn('id', $existing)
        );

        Muted::insert($newlyMutedUsers->map(function (object $newlyMutedUser) {
            return [
                'id'       => $newlyMutedUser->id,
                'user_id'  => $this->user->id,
                'name'     => $newlyMutedUser->name,
                'nickname' => $newlyMutedUser->screen_name,
                'data'     => json_encode($newlyMutedUser),
            ];
        })->toArray());

        return $this;
    }
}
