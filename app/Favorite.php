<?php

namespace App;

use App\Traits\Unguarded;
use App\Presenters\TweetPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use Unguarded;

    protected $casts = [
        'data' => 'object',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPresenterAttribute() : TweetPresenter
    {
        return new TweetPresenter($this->data);
    }
}
