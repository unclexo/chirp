<?php

namespace App\Jobs\Traits;

use App\User;
use Exception;
use App\Facades\Twitter;
use Illuminate\Support\Arr;

trait CallsTwitter
{
    public function getIdsFor(string $endpoint) : array
    {
        do {
            $response = $this->checkForTwitterErrors(
                Twitter::get("$endpoint/ids", [
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
            $users = $this->checkForTwitterErrors(
                Twitter::get('users/lookup', [
                    'user_id' => implode(',', $ids),
                ])
            );

            if (empty($users)) {
                return $this->emptyTwitterUser($ids[0]);
            }

            return $users;
        }, $chunks));
    }

    public function getConnectionsToUserFromIds(array $chunks) : array
    {
        return Arr::collapse(array_map(function (array $ids) {
            $friendships = $this->checkForTwitterErrors(
                Twitter::get('friendships/lookup', [
                    'user_id' => implode(',', $ids),
                ])
            );

            if (empty($friendships)) {
                return $this->emptyTwitterUser($ids[0]);
            }

            return $friendships;
        }, $chunks));
    }

    /**
     * @throws Exception
     */
    protected function checkForTwitterErrors($response)
    {
        if (200 === Twitter::getLastHttpCode()) {
            return $response;
        }

        if (404 === Twitter::getLastHttpCode()) {
            return;
        }

        $error = $response->errors[0];

        // User invalidated his token. We don't need jobs nor database space for him anymore.
        if (89 === $error->code) {
            $this->user->delete();
        }

        throw new Exception("Error code: {$error->code} for user #{$this->user->id}. Message: {$error->message}");
    }

    protected function emptyTwitterUser(int $id) : object
    {
        return (object) [
            'id'          => $id,
            'id_str'      => "$id",
            'name'        => 'Unknown',
            'screen_name' => 'unknown',
            'location'    => '',
            'description' => '',
            'url'         => '',
            'entities'    => [
                'url' => [
                    'urls' => [
                    ],
                ],
                'description' => [
                    'urls' => [
                    ],
                ],
            ],
            'protected'                          => false,
            'followers_count'                    => 0,
            'friends_count'                      => 0,
            'listed_count'                       => 0,
            'created_at'                         => 'Tue Mar 22 00:00:00 +0000 2006',
            'favourites_count'                   => 0,
            'utc_offset'                         => null,
            'time_zone'                          => null,
            'geo_enabled'                        => false,
            'verified'                           => false,
            'statuses_count'                     => 0,
            'lang'                               => null,
            'status'                             => [],
            'contributors_enabled'               => false,
            'is_translator'                      => false,
            'is_translation_enabled'             => false,
            'profile_background_color'           => '',
            'profile_background_image_url'       => '',
            'profile_background_image_url_https' => '',
            'profile_background_tile'            => false,
            'profile_image_url'                  => '',
            'profile_image_url_https'            => '',
            'profile_banner_url'                 => '',
            'profile_link_color'                 => '',
            'profile_sidebar_border_color'       => '',
            'profile_sidebar_fill_color'         => '',
            'profile_text_color'                 => '',
            'profile_use_background_image'       => false,
            'has_extended_profile'               => false,
            'default_profile'                    => false,
            'default_profile_image'              => false,
            'following'                          => false,
            'follow_request_sent'                => false,
            'notifications'                      => false,
            'translator_type'                    => 'none',
        ];
    }
}
