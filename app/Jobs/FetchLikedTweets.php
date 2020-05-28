<?php

namespace App\Jobs;

use App\Like;
use App\Facades\Twitter;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use App\Jobs\Traits\CallsTwitter;

class FetchLikedTweets extends BaseJob
{
    use CallsTwitter;

    public function handle() : void
    {
        Twitter::setOauthToken(
            $this->user->token,
            $this->user->token_secret
        );

        do {
            $parameters = ['count' => 200];

            if (! empty($response)) {
                $parameters['max_id'] = Arr::last($response)->id;
            }

            $this->checkForTwitterErrors(
                $response = Twitter::get('favorites/list', $parameters)
            );

            if (($parameters['max_id'] ?? 0) === Arr::last($response)->id) {
                break;
            }

            $likes = ! empty($likes)
                ? $likes->concat($response)
                : collect($response);
        } while (true);

        Like::whereUserId($this->user->id)->delete();

        // It seems like I'm doing something wrong and that I get duplicates from the
        // API. For now, I just ignore duplicate entries errors (they're not inserted
        // so my index is clean) and I'll see later if I can figure this out.
        Like::insertOrIgnore($likes->map(function (object $like) {
            return [
                'id'         => $like->id,
                'user_id'    => $this->user->id,
                'data'       => json_encode($like),
                'created_at' => Carbon::parse($like->created_at)->toDateTimeString(),
            ];
        })->toArray());
    }
}
