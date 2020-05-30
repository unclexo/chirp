<?php

namespace App;

use App\Traits\Unguarded;
use App\Presenters\TweetPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use Unguarded;

    public $timestamps = false;

    protected $casts = [
        'data' => 'object',
    ];

    public function scopeMatching(Builder $queryBuilder, string $query) : Builder
    {
        return $queryBuilder
            ->selectRaw(
                '*, MATCH(author_name, author_screen_name, full_text) AGAINST (? IN BOOLEAN MODE) AS score',
                [$query]
            )
            ->whereRaw(
                'MATCH(author_name, author_screen_name, full_text) AGAINST(? IN BOOLEAN MODE)',
                [$query]
            )
            ->orderBy('score', 'DESC');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPresenterAttribute() : TweetPresenter
    {
        return new TweetPresenter($this->data);
    }
}
