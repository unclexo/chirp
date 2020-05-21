<?php

namespace App\Jobs;

use App\Diff;
use App\User;
use Exception;
use App\Facades\Twitter;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

abstract class BaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;

    public $deleteWhenMissingModels = true;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @throws Exception
     */
    protected function checkForTwitterError($response) : void
    {
        if (200 !== Twitter::getLastHttpCode()) {
            throw new Exception(json_encode($response));
        }
    }

    protected function makeDiffFor(string $for) : void
    {
        do {
            $this->checkForTwitterError(
                $response = Twitter::get("$for/ids", [
                    'cursor' => $response->next_cursor ?? -1,
                ])
            );

            $ids = array_merge($ids ?? [], $response->ids);
        } while ($response->next_cursor);

        // If `$this->user->{$for}` is empty, it means it's a
        // 1st time user. There can't be any addition yet.
        $additions = $this->user->{$for}->isEmpty()
            ? new Collection
            : new Collection(array_diff($ids, $this->user->{$for}->toArray()));

        $deletions = new Collection(array_diff($this->user->{$for}->toArray(), $ids));

        if (! $additions->count() && ! $deletions->count()) {
            return;
        }

        $this->user->diffs()->save(
            new Diff($attributes = [
                'for'       => $for,
                'additions' => $additions = $this->getUsersForIds($additions),
                'deletions' => $deletions = $this->getUsersForIds($deletions),
            ])
        );

        $this->user->update([$for => $ids]);
    }

    protected function getUsersForIds($ids) : Collection
    {
        $chunks = (new Collection($ids))->chunk(100);

        if ($chunks->isEmpty()) {
            return $chunks;
        }

        $users = $chunks->map(function (Collection $ids) {
            $this->checkForTwitterError(
                $users = Twitter::get('users/lookup', [
                    'user_id' => $ids->join(','),
                ])
            );

            return $users;
        })->collapse();

        $friendships = $chunks->map(function (Collection $ids) {
            $this->checkForTwitterError(
                $friendships = Twitter::get('friendships/lookup', [
                    'user_id' => $ids->join(','),
                ])
            );

            return $friendships;
        })->collapse();

        return collect($users)->map(function ($user) use ($friendships) {
            $friendship = collect($friendships)->where('id', $this->user->id)->first();

            return array_merge((array) $user, (array) $friendship);
        });
    }
}
