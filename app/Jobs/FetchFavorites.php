<?php

namespace App\Jobs;

use App\Favorite;
use Illuminate\Support\Arr;
use App\Jobs\Traits\CallsTwitter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FetchFavorites extends BaseJob
{
    use CallsTwitter;

    protected Collection $favorites;

    public function __construct()
    {
        $this->favorites = new Collection;
    }

    public function handle() : void
    {
        $this
            ->fetchFavorites()
            ->deleteUnecessaryFavorites()
            ->insertNewFavorites();
    }

    protected function fetchFavorites() : self
    {
        do {
            $parameters = ['count' => 200, 'tweet_mode' => 'extended'];

            if (! empty($response)) {
                $parameters['max_id'] = Arr::last($response)->id;
            }

            $response = $this->checkForTwitterErrors(
                $this->twitter()->get('favorites/list', $parameters)
            );

            if (($parameters['max_id'] ?? 0) === Arr::last($response)->id) {
                break;
            }

            $this->favorites = ! empty($this->favorites)
                ? $this->favorites->concat($response)
                : collect($response);
        } while (true);

        return $this;
    }

    protected function deleteUnecessaryFavorites() : self
    {
        DB::table('favorites')
            ->whereUserId($this->user->id)
            ->whereNotIn('id', $this->favorites->pluck('id'))
            ->delete();

        return $this;
    }

    protected function insertNewFavorites() : self
    {
        $existing = DB::table('favorites')
            ->select('id')
            ->whereUserId($this->user->id)
            ->get()
            ->pluck('id');

        $new = $this->favorites->whereNotIn('id', $existing);

        Favorite::insert($new->map(function (object $favorite) {
            return [
                'id'      => $favorite->id,
                'user_id' => $this->user->id,
                'data'    => json_encode($favorite),
            ];
        })->toArray());

        return $this;
    }
}
