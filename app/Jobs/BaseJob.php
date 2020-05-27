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

    protected function makeDiffFor(string $for) : void
    {
        $ids = $this->getIdsFor($for);

        if ($this->user->{$for}->isNotEmpty()) {
            $additions = array_diff($ids, $this->user->{$for}->toArray());
            $deletions = array_diff($this->user->{$for}->toArray(), $ids);

            if (! count($additions) && ! count($deletions)) {
                return;
            }

            $this->user->diffs()->save(
                new Diff($attributes = [
                    'for'       => $for,
                    'additions' => $additions = $this->getUsersDetailsForIds($additions),
                    'deletions' => $deletions = $this->getUsersDetailsForIds($deletions),
                ])
            );
        }

        // We save the IDs when we are sure all the code above ran successfully.
        // That way, the next job will still be able to detected IDs that
        // changed at the time the failed job ran.
        $this->user->update([$for => $ids]);
    }

    public function getIdsFor(string $endpoint) : array
    {
        do {
            $this->checkForTwitterError(
                $response = Twitter::get("$endpoint/ids", [
                    'cursor' => $response->next_cursor ?? -1,
                ])
            );

            $ids = array_merge($ids ?? [], $response->ids);
        } while ($response->next_cursor);

        return $ids;
    }

    protected function getUsersDetailsForIds(array $ids) : array
    {
        // The code below uses vanilla PHP to work through arrays instead of Collections. More details:
        // https://github.com/benjamincrozat/chirp/commit/6e54b53ef8cd5085756ed226f1448e9fed092df4

        $chunks = array_chunk($ids, 100);

        if (! count($chunks)) {
            return $chunks;
        }

        $users = $this->getUsersFromIds($chunks);

        $friendships = $this->getConnectionsToUserFromIds($chunks);

        return array_map(function (object $user) use ($friendships) {
            $key = array_search($user->id, array_column((array) $friendships, 'id'));

            return array_merge((array) $user, (array) $friendships[$key]);
        }, $users);
    }

    public function getUsersFromIds(array $chunks) : array
    {
        return Arr::collapse(array_map(function (array $ids) {
            $this->checkForTwitterError(
                $users = Twitter::get('users/lookup', [
                    'user_id' => implode(',', $ids),
                ])
            );

            return $users;
        }, $chunks));
    }

    public function getConnectionsToUserFromIds(array $chunks) : array
    {
        return Arr::collapse(array_map(function (array $ids) {
            $this->checkForTwitterError(
                $friendships = Twitter::get('friendships/lookup', [
                    'user_id' => implode(',', $ids),
                ])
            );

            return $friendships;
        }, $chunks));
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
}
