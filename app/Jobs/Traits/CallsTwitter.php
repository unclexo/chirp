<?php

namespace App\Jobs\Traits;

use Exception;
use App\Facades\Twitter;
use Illuminate\Support\Arr;
use Abraham\TwitterOAuth\TwitterOAuth;

trait CallsTwitter
{
    /**
     * Going through this method allows us to always access a fully set up TwitterOAuth object.
     * Putting `Twitter::setOauthToken()` in the constructor isn't possible because the job
     * is already initialized when it's being unserialized by Laravel coming from SQS.
     */
    protected function twitter() : TwitterOAuth
    {
        Twitter::setOauthToken(
            $this->user->token,
            $this->user->token_secret
        );

        return Twitter::getFacadeRoot();
    }

    public function getIdsFor(string $endpoint) : array
    {
        do {
            $response = $this->guardAgainstTwitterErrors(
                $this->twitter()->get("$endpoint/ids", [
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
            $users = $this->guardAgainstTwitterErrors(
                $this->twitter()->get('users/lookup', [
                    'user_id' => implode(',', $ids),
                ])
            );

            return $users;
        }, $chunks));
    }

    public function getConnectionsToUserFromIds(array $chunks) : array
    {
        return Arr::collapse(array_map(function (array $ids) {
            $friendships = $this->guardAgainstTwitterErrors(
                $this->twitter()->get('friendships/lookup', [
                    'user_id' => implode(',', $ids),
                ])
            );

            return $friendships;
        }, $chunks));
    }

    /**
     * @throws Exception
     */
    protected function guardAgainstTwitterErrors($response)
    {
        if (200 === Twitter::getLastHttpCode()) {
            return $response;
        }

        $error = $response->errors[0];

        // Tokens have been invalidated. We don't need to queue jobs nor use database space anymore.
        if (89 === $error->code) {
            $this->user->delete();
        }

        throw new Exception("Error code: {$error->code} for user #{$this->user->id}. Message: {$error->message}");
    }
}
