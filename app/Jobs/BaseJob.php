<?php

namespace App\Jobs;

use App\Diff;
use App\User;
use Exception;
use App\Facades\Twitter;
use Illuminate\Support\Arr;
use Illuminate\Bus\Queueable;
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
            ? []
            : array_diff($ids, $this->user->{$for}->toArray());

        $deletions = array_diff($this->user->{$for}->toArray(), $ids);

        if (! count($additions) && ! count($deletions)) {
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

    protected function getUsersForIds(array $ids) : array
    {
        $chunks = array_chunk($ids, 100);

        if (! count($chunks)) {
            return $chunks;
        }

        $users = Arr::collapse(array_map(function (array $ids) {
            $this->checkForTwitterError(
                $users = Twitter::get('users/lookup', [
                    'user_id' => implode(',', $ids),
                ])
            );

            return $users;
        }, $chunks));

        $friendships = Arr::collapse(array_map(function (array $ids) {
            $this->checkForTwitterError(
                $friendships = Twitter::get('friendships/lookup', [
                    'user_id' => implode(',', $ids),
                ])
            );

            return $friendships;
        }, $chunks));

        return array_map(function (object $user) use ($friendships) {
            $key = array_search($user->id, array_column((array) $friendships, 'id'));

            return array_merge((array) $user, (array) $friendships[$key]);
        }, $users);
    }
}
