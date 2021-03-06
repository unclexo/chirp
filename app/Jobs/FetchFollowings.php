<?php

namespace App\Jobs;

use App\Diff;
use App\User;
use App\Following;
use App\Facades\Twitter;
use App\Jobs\Traits\CallsTwitter;
use Illuminate\Support\Collection;

class FetchFollowings extends BaseJob
{
    use CallsTwitter;

    protected Collection $followings;

    protected Collection $deletions;

    protected Collection $additions;

    public function __construct(User $user)
    {
        parent::__construct($user);

        $this->followings  = new Collection;
        $this->deletions   = new Collection;
        $this->additions   = new Collection;
    }

    public function fire() : void
    {
        $this
            ->fetchFollowings()
            ->deleteUnecessaryFollowings()
            ->insertNewFollowings()
            ->createDiff()
        ;
    }

    protected function fetchFollowings() : self
    {
        do {
            $response = $this->guardAgainstTwitterErrors(
                Twitter::get('friends/ids', [
                    'cursor' => $response->next_cursor ?? -1,
                ])
            );

            $this->followings = $this->followings->concat($response->ids);
        } while ($response->next_cursor);

        return $this;
    }

    protected function deleteUnecessaryFollowings() : self
    {
        $this->deletions = $this->getUsersDetailsForIds(
            Following::select('id')
                ->whereUserId($this->user->id)
                ->whereNotIn('id', $this->followings->pluck('id'))
                ->get()
                ->pluck('id')
        );

        if ($this->deletions->isNotEmpty()) {
            Following::whereUserId($this->user->id)
                ->whereIn('id', $this->deletions)
                ->delete();
        }

        return $this;
    }

    protected function insertNewFollowings() : self
    {
        $existing = Following::select('id')
            ->whereUserId($this->user->id)
            ->get()
            ->pluck('id');

        $inserts = $existing->isEmpty()
            ? $this->getUsersDetailsForIds($this->followings)
            : $this->additions = $this->getUsersDetailsForIds(
                $this->followings->filter(
                    fn ($id) => ! $existing->contains($id)
                )
            );

        Following::insert(
            $inserts
                ->map(function ($insert) {
                    return [
                        'id'       => $insert->id,
                        'user_id'  => $this->user->id,
                        'name'     => $insert->name,
                        'nickname' => $insert->screen_name,
                        'data'     => json_encode($insert),
                    ];
                })
                ->toArray()
        );

        return $this;
    }

    protected function createDiff() : self
    {
        if ($this->additions->isEmpty() && $this->deletions->isEmpty()) {
            return $this;
        }

        $this->user->diffs()->save(
            new Diff($attributes = [
                'for'       => 'followings',
                'additions' => $this->additions,
                'deletions' => $this->deletions,
            ])
        );

        return $this;
    }
}
